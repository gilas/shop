<?php

/**
 * PmController
 *      Private Message
 *      users can send or receive pm, we have 4 folder for any user
 *      this folders is :
 *          - inbox  : received pm holds in this
 *          - outbox : sent pm holds in this
 *          - draft  : saved pm holds in this
 *          - trash  : deleted pm holds in this 
 * 
 * @package Gilas
 * @author Hamid
 * @copyright 2013
 * @version $Id$
 * @access public
 */
class PmsController extends AppController{
    
    
	public $uses = array('Message');
    
/**
 * Get recipients for sending message
 * 
 * @return array of users format : user_id => user_name
 */
    protected function _getRecipients($conditions = array()){
	   $users = $this->Message->Recipients->Recipient->find('list', array(
            'conditions' => $conditions,
            'fields' => array('Recipient.id','Recipient.name')
            )
        );
        
        // remove owner
        unset($users[$this->Auth->user('id')]);
        
        /**
         * Formatting, every user has three field, 
         *      user_id   : for saving in table
         *      user_name : for showing to end user
         *      parent_id : this field used for reply pm, that this must has
         *                  id of parent (reader of message) that we want reply to it
         *                  because we use this function to creaete new pm, so parent_id = 0
         */
        $return = array();
        foreach($users as $user_key => $user_name){
            $return[] = array(
                    'user_id' =>   $user_key,
                    'user_name' => $user_name,
                    'parent_id' => 0,
                );
        }
        return $return;
    }
    
/**
 * Read message if user can read it 
 * 
 * @param mixed $msg_id
 * @return
 */
    protected function _readMessage($msg_id){
        return $this->Message->find('first',array(
                'conditions'=> array(
                    'Reader.user_id' => $this->Auth->user('id'),
                    'Reader.message_id' => $msg_id,
                )
            ));
    }

/**
 * Read message if user can read it 
 * 
 * @param mixed $reader_id
 * @return
 */
    protected function _readMessageByReaderID($reader_id){
        $method = 'first';
        if(is_array($reader_id)){
            $method = 'all';
        }
        $reader = $this->Message->Reader->find($method,array(
                'conditions'=> array(
                    'Reader.user_id' => $this->Auth->user('id'),
                    'Reader.id' => $reader_id,
                ),
                'contain' => array('Message.Sender.SenderInfo','Message.Recipients.Recipient', )
            ));
        if($reader){
            switch($method){
                case 'first':
                    $reader = $this->_removeOtherRecipients($reader);
                break;
                default:
                    foreach($reader as &$re){
                        $re = $this->_removeOtherRecipients($re);    
                    }
                break;
            }
        }
        return $reader;
    }
/**
 * if reader is not sender , so we must don't show other recipients to current user
 * 
 * @param array $message , 
 *          full info of message such as sender, reader, recipient
 *          Structure of array becomes from PmsController::_readMessageByReaderID
 * @return array $message , but removed other recipients
 */
    protected function _removeOtherRecipients($message){
        if($message['Message']['Sender']['SenderInfo']['id'] != $message['Reader']['user_id']){
            
            foreach($message['Message']['Recipients'] as $key => $recipient){
                
                if($recipient['user_id'] != $message['Reader']['user_id']){
                    unset($message['Message']['Recipients'][$key]);
                }
            }
        }
        return $message;
    }
    
/**
 * Fetch all rows for current folder, 
 *    ما ممکنه پیامی برای کاربری فرستاده باشیم پس این پیام باید در صندوق خروجی
 *    نمایش داده شود. حال فرض شود طرف مقابل به همان پیام پاسخ دهد. بنابراین انتظار داریم
 *    آن پیام در صندوق ورودی ما باشد . ولی چون پدراین پیام در صندوق ورودی نیست پس باید
 *    راهی برای آوردن این قبیل پیام ها به صندوق ورودی (علاوه بر نمایش در صندوق خروجی) 
 *    پیدا کرد . که بهترین راهی که فعلا به ذهنم رسید این بود که آی دی تمام پیام هایی
 *    که در پوشه داده شده قرار می گیرد را در بیاورم
 * 
 * @param mixed $folder
 * @param mixed $conditions
 * @return
 */
    protected function _readerId($folder, $conditions = array()){
        $conditions = array_merge(array(
                'Reader.user_id'=>$this->Auth->user('id'), 
                'Reader.folder' => $folder,
            ),$conditions);
        // Fetch all rows for current folder
       $readerRows = $this->Message->Reader->find('all',array(
            'contain' => 'Message',
            'fields' =>  array('Reader.id','Reader.parent_id','Reader.new'),
            'conditions'=> $conditions,
            'order' => 'Reader.id DESC',
       ));
       /**
        * Remove all rows that have same parent
        */
       $finalIDs = array();
       if($readerRows){
            $givedParents = array();
            foreach($readerRows as $row){
                $parent_id = $row['Reader']['parent_id'];
                if($parent_id != 0){
                    // keep the first of row and delete all rows that have this parent_id
                    if(! in_array($parent_id, $givedParents)){
                       $givedParents[] = $parent_id;
                       $finalIDs[] = $row;
                   }
                }else{
                    // if reply of this row is in $finalID, so delete this row
                    if(! in_array($row['Reader']['id'], $givedParents)){
                        $finalIDs[] = $row;
                    }
                }
            }
       }
       /**
        * Formatting result
        */
       return Set::combine($finalIDs, '{n}.Reader.id', '{n}.Reader.id');
    }
    
/**
 * Create new message
 * 
 * @param mixed $msg_id, id of message that we must get message from it, such as draft
 * @return
 */
    public function admin_add($msg_id = null){
	   $this->helpers[] = 'TinyMCE.TinyMCE';
       
        $this->set('users',$this->_getRecipients());
        
		if($this->request->is('post')){
		  // parent of new message is 0
          $this->request->data['Message']['parent_id'] = 0;
            // if user want save message
			if($this->request->data['Message']['method'] == 'save'){
    			 // Save it
    		     if($this->_save($this->request->data['Message'])){
    		         $this->Session->setFlash('پیام با موفقیت ذخیره شد.', 'message', array('type' => 'success'));
                     $this->redirect(array('action' => 'index', 'folder' => $this->Message->folders['draft']));
    		     }else{
    		          $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
                     return;
    		     }
			}else{
			     $message = $this->request->data['Message'];
                 // User send multiple users
			     if(isset($this->request->data['Message']['isList'])){
			         $recipients = array();
			         $recipientsInfo = $this->request->data['Message']['Recipients'];
                     if(!empty($this->request->data['Message']['Recipients']['id'])){
                        $selected = $this->request->data['Message']['Recipients']['id'];
                         unset($recipientsInfo['id']);
    			         foreach($recipientsInfo as $recipient){
    			             if(in_array($recipient['user'], $selected)){
    			                 $recipients[] = $recipient;
    			             }
    			         }
                     }
                     $message = array_merge($this->request->data['Message'], array('Recipients' => $recipients));
			     }
                // if user want send message
    			 if($this->_send($message)){
                    $this->Session->setFlash('پیام با موفقیت ارسال گردید.', 'message', array('type' => 'success'));
                    $this->redirect(array('action' => 'index', 'folder' => $this->Message->folders['outbox']));
    		     }else{
    		          $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
                     return;
    		     }
			}
		}elseif($msg_id){ // Give message from url (Such give message from draft)
            $msg = $this->Message->find('first', array(
                'conditions' => array(
                    'Message.id' => $msg_id,
                    'Message.user_id' => $this->Auth->user('id'),
                ),
                'contain' => false,
            ));
            
            $this->request->data['message'] = $msg['Message'];
        }
    }

/**
 * List of messages for current user
 * 
 * @return void
 */
    public function admin_index() {
        $this->pageTitle = 'لیست پیام ها';
        $folder = 1;
        if(isset($this->request->named['folder'])){
            $folder = $this->request->named['folder'];
        }else{
            $this->request->params['named']['folder'] = $folder;
        }
        $conditions = array();
        if(isset($this->request->named['content'])){
            $conditions =array(
                'OR' => array(
                    'Message.subject LIKE' => '%'.$this->request->named['content'].'%',
                    'Message.message LIKE' => '%'.$this->request->named['content'].'%',
                ),
            );
        }
        // Only message for current user must be listed
        $this->paginate['contain'] = array( 'Message.Sender.SenderInfo', 'Message.Recipients.Recipient');
        $this->paginate['conditions']['Reader.id'] = $this->_readerId($folder, $conditions);
        /**
         * With This we can show newest pm in top of list
         * 
         * $this->paginate['order'] = 'Reader.new DESC, Message.created DESC';
         */
        
        $this->paginate['order'] = 'Message.created DESC';
        $pms = $this->paginate('Reader');
        if($pms){
            foreach($pms as &$pm){
                $pm = $this->_lastConversation($pm);
                $pm['Message']['childCount'] = $this->_countConversation($pm['Reader']['parent_id']);
                
            }
        }
        $selectedFolder = $this->Message->folders[$folder];
        // add this helper for using FilterHelper in Filter Form
        $this->helpers[] = 'AdminForm';
        $this->set(compact('pms', 'selectedFolder'));
    }
    
/**
 * Return count of conversations for current reader, 
 * 
 * @param mixed $parentReader_id, give Reader.id, this id must be parent
 * @return
 */
    protected function _countConversation($parentReader_id){
        if($parentReader_id != 0)
            return $this->Message->Reader->childCount($parentReader_id) + 1;
        return false;
    }
    
/**
 * Return last message for current message
 * 
 * @param mixed $parent, Parent Message that must be has Reader array in it
 * @return array message, return last Message for gived parent
 */
    protected function _lastConversation($parent){
        // if This pm is parent
        if($parent['Reader']['parent_id'] == 0){
            $reader = $this->Message->Reader->find('first', array(
                'contain' => array( 'Message.Sender.SenderInfo', 'Message.Recipients.Recipient'),
                'conditions' => array(
                    'Reader.parent_id' => $parent['Reader']['id'],
                    'Reader.rght' => $parent['Reader']['rght'] - 1,// last child
                ), 
            ));
            if($reader){
                return $reader;    
            }
            return $parent;
        }else{
            // else give last conversation for parent of this pm
            return $this->_lastConversation($this->_readMessageByReaderID($parent['Reader']['parent_id']));
        }
    }
    
/**
 * Delete message
 * 
 * @param mixed $reader_id
 * @return void
 */
	public function admin_delete(){
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        $reader_id = $this->request->data['id']; // we recieve id via posted data
        $count = count($reader_id);
        if ($count == 1) {
            $reader_id = current($reader_id);

            if ($this->_delete($reader_id)) {
                $this->Session->setFlash('پیام با موفقیت حذف شد.', 'message', array('type' =>
                    'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'message', array('type' => 'error'));
            }
        } elseif ($count > 1) {
            $countAffected = 0;
            foreach ($reader_id as $i) {
                if ($this->_delete($i)) {
                    $countAffected++;
                }
            }
            $this->Session->setFlash($countAffected . ' پیام با موفقیت حذف شد.', 'message', array('type' => 'success'));
        }
        $this->redirect($this->referer());
	}
    

/**
 * Delete given message
 * 
 * @param mixed $reader_id, Reader.id for current message
 * @return
 */
    protected function _delete($reader_id){
        // Check User can access to this message id
        $message = $this->_readMessageByReaderID($reader_id);
        if(! $message){
            return false;
        }
        // if it is not parent
        if($message['Reader']['parent_id'] != 0){
            return $this->_delete($message['Reader']['parent_id']);
        }else{
            // get rows for this conversation
            $reader_ids = $this->_getReaderPath($message['Reader']['id']);
            
            // update folder of all
            if($this->Message->Reader->updateAll(array('folder' => $this->Message->folders['trash']), array('id' => $reader_ids ))){
                return true;
            }
            return false;
        }
    }
    
/**
 * Read message and load all conversation for it
 * 
 * @param mixed $reader_id
 * @return void
 */
	public function admin_read($reader_id = null){
	   $message = $this->_readMessageByReaderID($reader_id);
       // do not show empty message of saved message
       if(! $message or $message['Reader']['folder'] == $this->Message->folders['draft']){
            $this->Session->setFlash('چنین پیامی یافت نشد.', 'message', array('type' => 'error'));
            $this->redirect(array('action' => 'index'));
       }
       $message = $this->_getConversation($message['Reader']['id']);
       // set origin
       $origin = $message[0];
       unset($message[0]);
       
	   $this->set(array(
            'message' => $origin,
            'conversations' => $message,
       ));
       $this->helpers[] = 'TinyMCE.TinyMCE';
       $replyUsers = array();
       if($origin['Message']['Sender']['user_id'] == $this->Auth->user('id')){
            foreach($origin['Message']['Recipients'] as $recipient){
                $replyUsers[] = array(
                    'user_id' => $recipient['Recipient']['id'],
                    'user_name' => $recipient['Recipient']['name'],
                    'parent_id' => $recipient['id'],
                );
            }
       }else{
            $replyUsers[] = array(
                'user_id' => $origin['Message']['Sender']['SenderInfo']['id'],
                'user_name' => $origin['Message']['Sender']['SenderInfo']['name'],
                'parent_id' => $origin['Message']['Sender']['id'],
            );
       }
       // Get recipients for sending message
       $this->set('users',$replyUsers);
       if($this->request->isPost()){
            // if user want save message
			if($this->request->data['Message']['method'] == 'save'){
    			 // Save it
    		     if($this->_save($this->request->data['Message'])){
    		         $this->Session->setFlash('پیام با موفقیت ذخیره شد.', 'message', array('type' => 'success'));
                     $this->redirect(array('action' => 'index', 'folder' => $this->Message->folders['draft']));
    		     }else{
    		          $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
                     return;
    		     }
			}else{
			     $message = $this->request->data['Message'];
                 
                 // User send multiple users
			     if(isset($this->request->data['Message']['isList'])){
			         $recipients = array();
			         $recipientsInfo = $this->request->data['Message']['Recipients'];
                     if(!empty($this->request->data['Message']['Recipients']['id'])){
                        $selected = $this->request->data['Message']['Recipients']['id'];
                         unset($recipientsInfo['id']);
    			         foreach($recipientsInfo as $recipient){
    			             if(in_array($recipient['user'], $selected)){
    			                 $recipients[] = $recipient;
    			             }
    			         }
                     }
                     $message = array_merge($this->request->data['Message'], array('Recipients' => $recipients));
			     }
                // if user want send message
    			 if($this->_send($message)){
                    $this->Session->setFlash('پیام با موفقیت ارسال گردید.', 'message', array('type' => 'success'));
                    $this->redirect(array('action' => 'index', 'folder' => $this->Message->folders['outbox']));
    		     }else{
    		          $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
                     return;
    		     }
			}
       }
	}

/**
 * Get conversation for this message
 * 
 * @param mixed $reader_id
 * @return
 */
	protected function _getConversation($reader_id){
	   $message = $this->_readMessageByReaderID($reader_id);
       if(! $message){
            return false;
       }
       if($message['Reader']['parent_id'] != 0){
            return $this->_getConversation($message['Reader']['parent_id']);
       }else{
            $id = $this->_getReaderPath($message['Reader']['id']);
            // Update Fields
            foreach($id as $i){
                $this->Message->Reader->id = $i;
                $this->Message->Reader->save(array(
                    'read_date' => Jalali::dateTime(),
                    'new' => 0,
                ));
            }
            return $this->_readMessageByReaderID($id);
       }
	}
    
/**
 * Return array of id for this parent
 * 
 * @param array ID
 * @return
 */
    protected function _getReaderPath($parentReader_id){
        $readers = array_merge(
            $this->Message->Reader->getPath($parentReader_id),
            $this->Message->Reader->children($parentReader_id)
        );
        return Set::combine($readers, '{n}.Reader.id', '{n}.Reader.id');    
    }


	public function _save($params = array()){
	   
	   // create data
	   $data['Message']['user_id'] = $data['Reader']['user_id'] = $this->Auth->user('id');
       $data['Message']['subject'] = (isset($params['subject'])?$params['subject']:'بدون موضوع');
       $data['Message']['message'] = $params['message'];
       $data['Message']['parent_id'] = 0; 
       $data['Reader']['read_date'] = 0;
       $data['Reader']['new'] = 0;
       // Save message as draft for User
       $data['Reader']['folder'] = $this->Message->folders['draft'];
        $data['Message']['created'] = Jalali::dateTime(); 
        //Save message, saver
        $this->Message->saveAll($data);
       //TODO: this public function return true in any conditions
       return $this->Message->id;
	}
    
    public function _send($params = array()){
        
        if(empty($params['Recipients'])){
            return false;
        }
        // Create Message
       $data['Message']['user_id'] = $data['Reader']['user_id'] = $this->Auth->user('id');
       $data['Message']['subject'] = $params['subject'];
       $data['Message']['message'] = $params['message'];
       $data['Message']['created'] = Jalali::dateTime();  
       $data['Reader']['read_date'] = Jalali::dateTime();
       
       // Create Reader : Reader is current user
       $data['Reader']['new'] = 0;
       $data['Reader']['folder'] = $this->Message->folders['outbox'];
       $data['Reader']['is_sender'] = true;
       $data['Reader']['parent_id'] = (isset($params['parent_id']))?$params['parent_id']:0;
       // get data of recipients
       $i = 0;
       $recipients = array();
       foreach($params['Recipients'] as $recipient){
            // user can't send message to own
            if($recipient['user'] == $this->Auth->user('id')){
                continue;
            }
            $recipients[$i]['user_id'] = $recipient['user'];
            $recipients[$i]['read_date'] = 0;
            $recipients[$i]['new'] = 1;
            $recipients[$i]['folder'] = $this->Message->folders['inbox'];
            $recipients[$i]['parent_id'] = (isset($recipient['parent_id']))?$recipient['parent_id']:0;
            $i++;
       }
        //Save message, sender data
        $this->Message->saveAll($data);
        if($this->Message->id){
            //Save recipients data
            foreach($recipients as $r){
                $this->Message->Recipients->create();
                $r['message_id'] = $this->Message->id;
                $this->Message->Recipients->save($r);
            }
        }
        
       // return id for success saving otherwise return false
       return $this->Message->id;
    }
    
/**
 * return count of new message 
 * 
 * @return
 */
    public function countNewMessages(){
        $count = $this->Message->Reader->find('count', array(
			'contain' => false,
			'conditions'=>array(
                'Reader.user_id'=>$this->Auth->user('id'), 
                'Reader.new' => 1, 
                'Reader.folder' => $this->Message->folders['inbox']
            ),
		));
		return $count;
    }
    /******** for register users ****/
    public function index(){
        $this->admin_index();
    }
    public function add($msg_id = null){
        $this->admin_add($msg_id);
        $this->set('users',$this->_getRecipients(array('role_id <>' => 3)));// Not Register User
    }
    public function read($reader_id = null){
        $this->admin_read($reader_id);
    }
    public function delete(){
        $this->admin_delete();
    }
    
}