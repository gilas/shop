<?php

class SmsesController extends AppController{

    public $uses = array('Sms');
    public $publicActions = array('receive');
    /**********  For sms Class *********/
    public $sms_username = null;
    public $sms_password = null;
    public $sms_number = null;
    // instance of nusoap class
    public $nusoap = null;
    // hold status of end action
    public $status = null;
    
    public function beforeFilter(){
        $this->_setParams();
        $link = SettingsController::read('SMS.link');
        App::import('Vendor','nusoap/nusoap');
        $this->nusoap = new nusoap_client($link, 'wsdl');
        $this->nusoap->decodeUTF8(false);
        parent::beforeFilter();
    }
    
    protected function _setParams(){
        $this->sms_username = SettingsController::read('SMS.username');
        $this->sms_password = SettingsController::read('SMS.password');
        $this->sms_number = SettingsController::read('SMS.number');
    }
    
    // get all messages from webservice that received
    protected function _inbox(){
        return $this->nusoap->call('getMessages', array(
        	'username'	=> $this->sms_username,
        	'password'	=> $this->sms_password,
        ));
    }
    
    // get all messages from webservice that sent
    protected function _outbox(){
        return $this->nusoap->call('getSentMessages', array(
        	'username'	=> $this->sms_username,
        	'password'	=> $this->sms_password,
        ));
    }
    
    /**
     * Send one message to contact(s)
     * 
     * Example:
     *      $this->__send('09159922885','Hello Hamid');
     *      $this->__send(array('09159922885','09359530193'),'Hello Boys');
     * 
     * @param mixed $to: one or many contacts
     * @param string $message: Message that must be send
     * @return return status of send message
     */
    protected function __send($to,$message){
        
        $send = 'send';
        if(is_array($to) && count($to) > 1){
            $send = 'multiSend';
        }
        if(empty($to)){
            return false;
        }
        $this->status = $this->nusoap->call($send, array(
        	'username'	=> $this->sms_username,
        	'password'	=> $this->sms_password,
        	'to'		=> $to,
        	'from'		=> $this->sms_number,
        	'message'	=> $message,
        ));
        
        return $this->_getStatus();
    }
    
    /**
     * Get message info from POST
     * 
     *  parameters of POST
     *      from :  mobile number of sender
     *      to   :  mobile number of receiver
     *      message :   message 
     *      timestamp : timestamp of message has been sent
     * @return above parameters
     */
    protected function _receive(){
        
        $this->status = $this->nusoap->call('verifyReceive', array(
        	'username'	=> $this->sms_username, 
        	'password'	=> $this->sms_password, 
        	'to'		=> $_POST['to'], 
        	'from'		=> $_POST['from'], 
        	'message'	=> $_POST['message'], 
        	'timestamp'	=> $_POST['timestamp']
        ));
        
        return $_POST;
    }
    
    /**
     * Change URL that it must receive SMS 
     * 
     * Example:
     *      $this->_changeURL('http://www.mosafer-behesht.ir/smses/receive');
     * 
     * @param string $url: it must a full address
     * @return return status of this action from webservice
     */
    protected function _changeURL($url){
        $this->status = $this->nusoap->call('changeReceiveURL', array(
        	'username'	=> $this->sms_username, 
        	'password'	=> $this->sms_password, 
            'receive_url' => $url,
        )); 
        
        return $this->_getStatus();
    }
    
    public function admin_settings(){
        if(SettingsController::read('SMS.link')){
            $this->_changeURL(SettingsController::read('SMS.link'));
        }
    }
    
    /**
     * Get info of account from webservice 
     * 
     * @return Info of account
     */
    protected function _accountInfo(){
        return $this->nusoap->call('accountInfo', array(
        	'username'	=> $this->sms_username, 
        	'password'	=> $this->sms_password, 
        )); 
    }
    
    /**
     * Get last status  
     * 
     * @return status
     */
    protected function _getStatus(){
        return $this->status;
    }
    
    /**
     * Save any SMS that sent or received in database
     * 
     *      $message must contaion:
     *          from:  sender
     *          to:    receiver
     *          message:   message
     *          identifier:  message-id that get from webservice
     * 
     * @param array $message: info of message
     * @return false for failure save or true 
     */
    function _save($message){
        $msg = array();
        $msg['to'] = $message['to'];
        $msg['from'] = $message['from'];
        $msg['message'] = $message['message'];
        $msg['send_time'] = $this->Jalali->date('Y/m/d H:i:s');
        $msg['identifier'] = $this->status['identifier'];
        $msg['status'] = $this->status['status'];
        $this->Sms->create();
        if($this->Sms->save($msg)){
            return true;
        }
        return false;
    }
    
    /*********  Now for controller ************/
    
    /**
     * Action that receive SMS
     */
    function receive(){
        $newMessage = $this->_receive();
        /*** any action can be here ******/
        
        $this->_save($newMessage);
        return $newMessage;
    }
    
    /**
     * 
     */
    public function admin_send(){
        if($this->request->data){
            $this->_send($this->request->data['to'],$this->request->data['message']);
            $this->Session->setFlash('پیام با موفقیت ارسال گردید.','success');
        }
    }
    
    /**
     * Action for send message 
     * This action can be use from any controller 
     */
    public function _send($to,$message){
        $this->__send($to,$message);
        $from = $this->sms_number;
        $timestamp = time();
        if(is_array($to) && count($to) > 1){
            foreach($to as $t){
                $this->_save(compact('t','from','message','timestamp'));
            }
        }else{
            $this->_save(compact('to','from','message','timestamp'));
        }
        
    }
    
    public function admin_index(){
        $this->pageTitle = 'لیست پیامک ها';
        $smses = $this->paginate();
        // add this helper for using FilterHelper in Filter Form
        $this->helpers[] = 'AdminForm';
        $this->set(compact('smses'));
    }
}