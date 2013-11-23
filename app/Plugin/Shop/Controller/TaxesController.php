<?php
App::uses('ShopAppController', 'Shop.Controller');
/**
 * Taxes Controller
 *
 */
class TaxesController extends ShopAppController {
    
    public $uses = array('Shop.Tax');
    
    public $paginateConditions = array(
        'name' => array(
            'type' => 'LIKE',
            'field' => 'Tax.name',
        ),
    );
    
    protected function _getParentTitle(){
        return 'مدیریت مالیات';
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
        $this->pageTitle = 'افزودن مالیات';
        $this->helpers[] = 'Validator';
        if ($this->request->is('post')) {
            $tax = array(
                'name' => $this->request->data['Tax']['name'],
                'percent' => $this->request->data['Tax']['percent'],
            );
            if ($this->Tax->save($tax)) {
                $this->Session->setFlash('مالیات با موفقیت ایجاد شد', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }
        $this->set('title', $this->pageTitle);
        $this->set('parentTitle', $this->_getParentTitle());
    }
    public function admin_edit($id = null){
        $this->pageTitle = 'ویرایش  مالیات';
        $this->helpers[] = 'Validator';
        $this->Tax->id = $id;
        if (!$this->Tax->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $tax = array(
                'name' => $this->request->data['Tax']['name'],
                'percent' => $this->request->data['Tax']['percent'],
            );
            if ($this->Tax->save($tax)) {
                $this->Session->setFlash('مالیات با موفقیت ویرایش گردید', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }else{
            $this->request->data = $this->Tax->read();
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
            $this->Tax->id = $id;

            if ($this->Tax->delete()) {
                $this->Session->setFlash('مالیات با موفقیت حذف شد', 'message', array('type' => 'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'message', array('type' => 'error'));
            }
        } elseif ($count > 1) {
            $countAffected = 0;
            foreach ($id as $i) {
                $this->Tax->id = $i;
                if ($this->Tax->delete()) {
                    $countAffected++;
                }
            }
            $this->Session->setFlash($countAffected . ' مالیات منو حذف گردید', 'message', array('type' => 'success'));
        }
        $this->redirect($this->referer());
    }
    
    public function _getList(){
        return $this->Tax->find('list');
    }
}