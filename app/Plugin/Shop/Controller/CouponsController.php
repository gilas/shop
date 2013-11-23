<?php
App::uses('ShopAppController', 'Shop.Controller');
/**
 * Coupons Controller
 *
 */
class CouponsController extends ShopAppController {   
    public $uses = array('Shop.Coupon');
    
    protected function _getParentTitle(){
        return 'مدیریت کوپن';
    }
    
    public function admin_index(){
        $this->pageTitle = $this->_getParentTitle();
        $coupons = $this->paginate();
        
        // add this helper for using FilterHelper in Filter Form
        $this->helpers[] = 'AdminForm';
        $namedType = $this->Coupon->namedType;
        $namedDiscountType = $this->Coupon->namedDiscountType;
        $this->set(compact('coupons', 'namedType', 'namedDiscountType'));
        $this->set('title', $this->pageTitle);
    }
    public function admin_add(){
        $this->pageTitle = 'تولید کوپن';
        $this->helpers[] = 'Validator';
        $namedType = $this->Coupon->namedType;
        $namedDiscountType = $this->Coupon->namedDiscountType;
        $this->set(compact('namedType', 'namedDiscountType'));
        $this->set('title', $this->pageTitle);
        $this->set('parentTitle', $this->_getParentTitle());
        
        if ($this->request->is('post')) {
            if($this->request->data['Coupon']['discount_type'] == 1 and $this->request->data['Coupon']['discount_value'] > 100){
                $this->Session->setFlash('در نوع درصدی نباید ارزش بیشتر از 100 باشد.', 'message', array('type' => 'error'));
                return;
            }
            $this->Coupon->data = array(
                'type' => $this->request->data['Coupon']['type'],
                'serial' => $this->request->data['Coupon']['prefix'] . $this->_getRandomCode(),
                'discount_type' => $this->request->data['Coupon']['discount_type'],
                'discount_value' => $this->request->data['Coupon']['discount_value'],
            );
            if(! $this->Coupon->validates()){
                return;
            }
            $generatedCount = 0;
            for($i = 0; $i < $this->request->data['Coupon']['count']; $i++ ){
                $this->Coupon->create();
                $coupon = array(
                    'type' => $this->request->data['Coupon']['type'],
                    'serial' => $this->request->data['Coupon']['prefix'] . $this->_getRandomCode(),
                    'discount_type' => $this->request->data['Coupon']['discount_type'],
                    'discount_value' => $this->request->data['Coupon']['discount_value'],
                );
                if ($this->Coupon->save($coupon)) {
                    $generatedCount++ ;
                }else{
                    $i-- ;
                }
            }
            if($generatedCount > 0){
                $this->Session->setFlash($generatedCount . ' کوپن با موفقیت ایجاد شد', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }
    }
    
    protected function _getRandomCode(){
        mt_srand(crc32(microtime()));
        return mt_rand(1000000, 9999999);
    }
    public function admin_edit($id = null){
        $this->pageTitle = 'ویرایش  کوپن';
        $this->helpers[] = 'Validator';
        $this->Coupon->id = $id;
        if (!$this->Coupon->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $coupon = array(
                'name' => $this->request->data['Coupon']['name'],
                'percent' => $this->request->data['Coupon']['percent'],
            );
            if ($this->Coupon->save($coupon)) {
                $this->Session->setFlash('کوپن با موفقیت ویرایش گردید', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }else{
            $this->request->data = $this->Coupon->read();
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
            $this->Coupon->id = $id;

            if ($this->Coupon->delete()) {
                $this->Session->setFlash('کوپن با موفقیت حذف شد', 'message', array('type' => 'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'message', array('type' => 'error'));
            }
        } elseif ($count > 1) {
            $countAffected = 0;
            foreach ($id as $i) {
                $this->Coupon->id = $i;
                if ($this->Coupon->delete()) {
                    $countAffected++;
                }
            }
            $this->Session->setFlash($countAffected . ' کوپن حذف گردید', 'message', array('type' => 'success'));
        }
        $this->redirect($this->referer());
    }
    
    public function _canUseCoupon($coupon_id = null, $serial = null){
        $coupon = null;
        if($coupon_id){
            $this->Coupon->id = $coupon_id;
            $coupon = $this->Coupon->read();   
        }else{
            $coupon = $this->Coupon->find('first', array('conditions' => array('serial' => $serial)));
        }
        
        if(empty($coupon)){
            return false;
        }
        if($coupon['Coupon']['is_used']){
            return false;
        }
        return $coupon;
    }
    
    public function _useCoupon($coupon_id, $factor_id){
        $this->Coupon->id = $coupon_id;
        $coupon = $this->Coupon->read();
        if($coupon['Coupon']['is_used']){
            return false;
        }
        if($this->Coupon->save(array('is_used' => true, 'used_date' => Jalali::dateTime(), 'factor_id' => $factor_id))){
            return true;
        }
        return false;
    }
    
    
}