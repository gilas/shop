<?php
App::uses('ShopAppController', 'Shop.Controller');
/**
 * Comments Controller
 *
 */
class CommentsController extends ShopAppController {   
    public $uses = array('Shop.Comment');
    
    protected function _getParentTitle(){
        return 'مدیریت نظرات';
    }
    
    public function admin_index(){
        $this->pageTitle = $this->_getParentTitle();
        $taxes = $this->paginate();
        
        // add this helper for using FilterHelper in Filter Form
        $this->helpers[] = 'AdminForm';
        
        $this->set(compact('taxes'));
        $this->set('title', $this->pageTitle);
    }
    public function admin_add(){
        $this->pageTitle = 'افزودن نظر';
        $this->helpers[] = 'Validator';
        $this->set('title', $this->pageTitle);
        $this->set('parentTitle', $this->_getParentTitle());
    }
    public function admin_edit($id = null){
        $this->pageTitle = 'ویرایش  نظر';
        $this->helpers[] = 'Validator';
        $this->set('title', $this->pageTitle);
        $this->set('parentTitle', $this->_getParentTitle());
        $this->render('admin_add');
    }
    public function admin_delete(){
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        $this->redirect($this->referer());
    }
    public function admin_view($id = null){}
}