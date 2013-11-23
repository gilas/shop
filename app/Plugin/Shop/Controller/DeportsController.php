<?php
App::uses('ShopAppController', 'Shop.Controller');
/**
 * Deports Controller
 *
 */
class DeportsController extends ShopAppController {
    public $uses = array('Shop.Deport');
    
    public $paginateConditions = array(
        'name' => array(
            'type' => 'LIKE',
            'field' => 'Deport.name',
        ),
    );
    
    protected function _getParentTitle(){
        return 'مدیریت روش ارسال کالا';
    }
    
    public function admin_index(){
        $this->pageTitle = $this->_getParentTitle();
        $deports = $this->paginate();
        
        // add this helper for using FilterHelper in Filter Form
        $this->helpers[] = 'AdminForm';
        
        $this->set(compact('deports'));
        $this->set('title', $this->pageTitle);
    }
    
    public function admin_add(){
        $this->pageTitle = 'افزودن روش ارسال کالا';
        $this->helpers[] = 'Validator';
        if ($this->request->is('post')) {
            $tax = array(
                'name' => $this->request->data['Deport']['name'],
                'price' => $this->request->data['Deport']['price'],
            );
            if ($this->Deport->save($tax)) {
                $this->Session->setFlash('روش ارسال کالا با موفقیت ایجاد شد', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }
        $this->set('title', $this->pageTitle);
        $this->set('parentTitle', $this->_getParentTitle());
    }
    
    public function admin_edit($id = null){
        $this->pageTitle = 'ویرایش  روش ارسال کالا';
        $this->helpers[] = 'Validator';
        $this->Deport->id = $id;
        if (!$this->Deport->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $tax = array(
                'name' => $this->request->data['Deport']['name'],
                'price' => $this->request->data['Deport']['price'],
            );
            if ($this->Deport->save($tax)) {
                $this->Session->setFlash('روش ارسال کالا با موفقیت ویرایش گردید', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }else{
            $this->request->data = $this->Deport->read();
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
            $this->Deport->id = $id;

            if ($this->Deport->delete()) {
                $this->Session->setFlash('روش ارسال کالا با موفقیت حذف شد', 'message', array('type' => 'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'message', array('type' => 'error'));
            }
        } elseif ($count > 1) {
            $countAffected = 0;
            foreach ($id as $i) {
                $this->Deport->id = $i;
                if ($this->Deport->delete()) {
                    $countAffected++;
                }
            }
            $this->Session->setFlash($countAffected . ' روش ارسال کالا منو حذف گردید', 'message', array('type' => 'success'));
        }
        $this->redirect($this->referer());
    }
    
    public function _getList(){
        return $this->Deport->find('list');
    }
}