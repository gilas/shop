<?php
App::uses('ShopAppController', 'Shop.Controller');
/**
 * Groups Controller
 *
 */
class GroupsController extends ShopAppController {   
    
    public $uses = array('Shop.Group');
    
    public $paginateConditions = array(
        'name' => array(
            'type' => 'LIKE',
            'field' => 'Group.name',
        ),
    );
    protected function _getParentTitle(){
        return 'مدیریت گروه های کاربری';
    }
    
    public function admin_index(){
        $this->pageTitle = $this->_getParentTitle();
        
        $groups = $this->paginate();
        //TODO: Show count of users for each group
        // add this helper for using FilterHelper in Filter Form
        $this->helpers[] = 'AdminForm';
        
        $this->set(compact('groups'));
        $this->set('title', $this->pageTitle);
    }
    public function admin_add(){
        $this->pageTitle = 'افزودن گروه های کاربری';
        $this->helpers[] = 'Validator';
        $this->set('title', $this->pageTitle);
        $this->set('parentTitle', $this->_getParentTitle());
        if ($this->request->is('post')) {
            $group = array(
                'name' => $this->request->data['Group']['name'],
                'discount' => $this->request->data['Group']['discount'],
            );
            if ($this->Group->save($group)) {
                $this->Session->setFlash('گروه کاربری با موفقیت ایجاد شد', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }
    }
    public function admin_edit($id = null){
        $this->pageTitle = 'ویرایش  گروه های کاربری';
        $this->helpers[] = 'Validator';
        $this->Group->id = $id;
        
        if (!$this->Group->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $tax = array(
                'name' => $this->request->data['Group']['name'],
                'discount' => $this->request->data['Group']['discount'],
            );
            if ($this->Group->save($tax)) {
                $this->Session->setFlash('گروه کاربری با موفقیت ویرایش گردید', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }else{
            $this->request->data = $this->Group->read();
        }
        
        $this->set('title', $this->pageTitle);
        $this->set('parentTitle', $this->_getParentTitle());
        $this->render('admin_add');
    }
    public function admin_delete(){
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        
        $id = $this->request->data['id']; // we receive id via posted data
        $count = count($id);
        if ($count == 1) {
            $id = current($id);
            $this->Group->id = $id;

            if ($this->Group->delete()) {
                $this->Session->setFlash('گروه کاربری  با موفقیت حذف شد', 'message', array('type' => 'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'message', array('type' => 'error'));
            }
        } elseif ($count > 1) {
            $countAffected = 0;
            foreach ($id as $i) {
                $this->Group->id = $i;
                if ($this->Group->delete()) {
                    $countAffected++;
                }
            }
            $this->Session->setFlash($countAffected . ' گروه کاربری  منو حذف گردید', 'message', array('type' => 'success'));
        }
        
        $this->redirect($this->referer());
    }
    public function admin_view($id = null){}
}