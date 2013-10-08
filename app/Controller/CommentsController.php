<?php

App::uses('AppController', 'Controller');

/**
 * Comments Controller
 *
 * @property Comment $Comment
 */
class CommentsController extends AppController {

    public $publicActions = array('add_comment', 'latestComments');

    public function beforeRender() {
        parent::beforeRender();
        if ($this->request->params['action'] == 'admin_replyComment' || $this->request->params['action'] == 'admin_editComment')
            $this->layout = 'comment';
    }

    private function _haveHttpPrefix($url = Null) {
        if (substr($url, 0, 7) != 'http://')
            $url = 'http://' . $url;
        return $url;
    }

    public function admin_index() {
        $this->pageTitle = 'مشاهده نظرات';

        $comments = $this->Comment->find('all', array('order' => array('Comment.created' => 'DESC')));
        for ($i = 0; $i < count($comments); $i++) {
            if ($comments[$i]['Comment']['parent_id'] != 0) {
                $parentName = $this->Comment->findById($comments[$i]['Comment']['parent_id'], array('fields' => 'name'));
                $comments[$i]['Comment']['parent_name'] = $parentName['Comment']['name'];
            }
        }
        $this->set('comments', $comments);
    }

/**
 * Add comment for given $content_id
 * 
 * @param mixed $data : data of comment
 * @param mixed $content_id : id of content that must add current comment to it
 * @param mixed $is_published : true or false : that indicate the comment show directly or not
 * @return  $success
 *           1 : Comment added and can show it directly
 *           2 : Comment added but cann't show it directly
 *           false : Comment Not added   
 */
    public function add_comment(array $data, $content_id, $is_published) {

        $this->request->data = $data;
        $this->request->data['Comment']['created'] = Jalali::dateTime();
        $this->request->data['Comment']['content_id'] = $content_id;
        $this->request->data['Comment']['published'] = $is_published;
        $this->request->data['Comment']['website'] = $this->_haveHttpPrefix($this->request->data['Comment']['website']);

        if ($this->Comment->save($this->request->data)) {
            if ($is_published){
                return 1;
            }else{
                return 2;
            }
        }
        return false;
    }

    public function admin_view($id = NULL) {
        $this->helpers = array('Comment');
        $this->pageTitle = 'مشاهده نظرات مطالب';
        $this->set('comments', $this->Comment->find('threaded', array(
                    'conditions' => array('Comment.content_id' => $id),
                    'order' => array('Comment.created' => 'desc')
                )));
    }

    public function admin_publish_comment($id = NULL) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        $this->Comment->id = $id;
        if (!$this->Comment->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->Comment->saveField('published', 1)) {
            $this->Session->setFlash('نظر با موفقیت منتشر شد.', 'message', array('type' => 'success'));
            $this->redirect($this->referer());
        }
    }

    public function admin_unpublish_comment($id = NULL) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        $this->Comment->id = $id;
        if (!$this->Comment->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->Comment->saveField('published', 0)) {
            $this->Session->setFlash('نظر با موفقیت از حالت انتشار خارج شد.', 'message', array('type' => 'success'));
            $this->redirect($this->referer());
        }
    }

    public function admin_delete($id = NULL) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        $this->Comment->id = $id;
        if (!$this->Comment->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->Comment->delete()) {
            $this->Session->setFlash('نظر با موفقیت حذف شد.', 'message', array('type' => 'success'));
            $this->redirect($this->referer());
        }
    }

    public function admin_replyComment($id = NULL) {
        $this->helpers = array('TinyMCE.TinyMCE');
        $this->pageTitle = 'پاسخ به نظر';
        $comment = $this->Comment->find('first', array('conditions' => array('Comment.id' => $id)));
        $this->set('comment', $comment);
        if ($this->request->is('post')) {
            $this->request->data['Comment']['parent_id'] = $comment['Comment']['id'];
            $this->request->data['Comment']['content_id'] = $comment['Comment']['content_id'];
            $this->request->data['Comment']['name'] = 'مدیریت';
            $this->request->data['Comment']['email'] = '1razzaghi@gmail.com';
            $this->request->data['Comment']['website'] = 'http://bigitblog.ir';
            $this->request->data['Comment']['published'] = 1;
            $this->request->data['Comment']['created'] = Jalali::dateTime();
            if ($this->Comment->save($this->request->data)) {
                $this->Session->setFlash('پاسخ شما با موفقیت ارسال شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }
    }

    public function admin_editComment($id = NULL) {
        $this->helpers = array('TinyMCE.TinyMCE');
        $this->pageTitle = 'ویرایش نظر';
        $this->Comment->id = $id;
        if (!$this->Comment->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Comment->save($this->request->data)) {
                $this->Session->setFlash('نظر با موفقیت ویرایش شد.', 'message', array('type' => 'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        } else {
            $this->request->data = $this->Comment->read();
        }
    }

    public function latestComments() {
        $this->helpers = array('Text');
        $comments = $this->Comment->find('all', array(
            'conditions' => array(
                'Comment.published' => '1'
            ),
            'fields' => array(
                'name', 'id'
            ),
            'order' => 'Comment.created DESC',
            'contain' => array('Content.title', 'Content.slug'),
            'limit' => '5'
                )
        );
        $this->set('comments', $comments);
    }

}
