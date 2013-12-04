<?php
App::uses('ShopAppController', 'Shop.Controller');
/**
 * FactorHeads Controller
 *
 */
class OrdersController extends ShopAppController {
    
    public $uses = array('Shop.FactorHead', 'Shop.FactorItem', 'Shop.Deport', 'Shop.Stuff');
    
    public $paginateConditions = array(
        'type' => array(
            'field' => 'FactorHead.type',
            'default' => 1,
        ),
        'status' => array(
            'field' => 'FactorHead.status',
        ),
        'number' => array(
            'field' => 'FactorHead.number',
            'type' => 'LIKE',
        ),
    );
    
    public $paginate = array(
        'order' => 'FactorHead.id DESC',
    );
    
    public $publicActions = array(
            'addToCart', 'viewCart', 'deleteFromCart', 
            'emptyCart', 'submitCart', 'register', 
            'addCoupon', 'deleteCoupon', 'setDeport',
    );
    
    protected function _getParentTitle($type){
        if($type == 1){
            return 'مدیریت سفارشات خرید';
        }
        return 'مدیریت سفارشات فروش';
    }
/**
 * admin_index method
 *
 * @return void
 */
    public function admin_index() {
        $type = 1;
        if(!empty($this->passedArgs['type'])){
            $type = (int)$this->passedArgs['type'];
        }
        if(!empty($this->passedArgs['date'])){
            $this->paginate['conditions']['date'] = str_replace('-', '/', $this->passedArgs['date']);
        }
        $this->pageTitle = $this->_getParentTitle($type);
        $this->paginate['contain'] = 'ShopUser.User';
        $orders = $this->paginate();
        
        // add this helper for using FilterHelper in Filter Form
        $this->helpers[] = 'AdminForm';
        $this->set(compact('orders'));
        $this->set('title', $this->pageTitle);
        $this->set('type', $type);
        $this->set('namedType', $this->FactorHead->namedType);
        $this->set('namedStatus', $this->FactorHead->namedStatus);
    }

/**
 * admin_add method
 *
 * @return void
 */
    public function admin_add() {
        $type = 1;

        if(!empty($this->passedArgs['type'])){
            $type = (int)$this->passedArgs['type'];
        }
        if($type == 1){
            $this->pageTitle = 'افزودن سفارش خرید';
        }else{
            $this->pageTitle = 'افزودن سفارش فروش';
        }
        
        $this->helpers[] = 'Validator';
        $this->helpers[] = 'AdminForm';
        if ($this->request->is('post')) {
            $success = false;
            if($type == 1){
                $success = $this->_saveAsBuy();
            }else{
                $success = $this->_saveAsSell();
            }
            if($success){
                $this->Session->setFlash('سفارش با موفقیت ایجاد شد', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            }
            $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
        }
        $this->set('type', $type);
        $this->set('title', $this->pageTitle);
        $this->set('parentTitle', $this->_getParentTitle($type));
    }
    
    public function _saveAsBuy(){
        $head = array(
            'user_id' => $this->request->data('FactorHead.user_id'),
            'type' => 1,
            'date' => $this->request->data('FactorHead.date'),
            'number' => $this->request->data('FactorHead.number'),
        );
        $stuffObj = $this->_loadController('Shop.Stuffs');
        $itemsWithCount = Set::combine($this->request->data, 'Item.{n}.code', 'Item.{n}');
        
        unset($itemsWithCount['']);
        $itemsInfo = $stuffObj->_getInfo(array_keys($itemsWithCount));
        
        $total = 0;
        foreach( $itemsWithCount as $code => $item){
                $total += $item['price'] * $item['count'];
        }
        $head['total_price'] = $total;
        $head['final_price'] = $total - (int)$this->request->data('discount');
        $this->FactorHead->create();
        if ($this->FactorHead->save($head)) {
        	$this->_changeStatus($this->FactorHead->id, 1);
            $item = array('head_id' => $this->FactorHead->id);
            foreach( $itemsWithCount as $code => $itm){
                $item['stuff_id'] = $itemsInfo[$code]['id'];
                $item['count'] = $itm['count'];
                $item['price'] = $itm['price'];
                $item['total_price'] = $itm['price'] * $itm['count'];
                $this->FactorItem->create();
                if ($this->FactorItem->save($item)){
                    $stuffObj->Stuff->id = $itemsInfo[$code]['id'];
                    if(!empty($stuffObj->Stuff->id)){
                        $stuffObj->Stuff->saveField('count', $itemsInfo[$code]['count'] + $itm['count']);
                    }
                }
            }
            return true;
        } 
        return false;
    }
    
    public function _saveAsSell(){
        $head = array(
            'user_id' => $this->request->data('FactorHead.user_id'),
            'type' => 2,
            'date' => $this->request->data('FactorHead.date'),
            'number' => $this->request->data('FactorHead.number'),
        );
        $stuffObj = $this->_loadController('Shop.Stuffs');
        $itemsWithCount = Set::combine($this->request->data, 'Item.{n}.code', 'Item.{n}.count');
        unset($itemsWithCount['']);
        $itemsInfo = $stuffObj->_getInfo(array_keys($itemsWithCount));
        
        $total = 0;
        foreach( $itemsWithCount as $code => $count){
            if($itemsInfo[$code]['count'] < $count){
                return false;
            }
            $total += $itemsInfo[$code]['price'] * $count;
        }
        $head['total_price'] = $total;
        $head['final_price'] = $total - (int)$this->request->data('discount');
        $this->FactorHead->create();
        if ($this->FactorHead->save($head)) {
            $this->_changeStatus($this->FactorHead->id, 1);
            $item = array('head_id' => $this->FactorHead->id);
            foreach( $itemsWithCount as $code => $count){
                $item['stuff_id'] = $itemsInfo[$code]['id'];
                $item['count'] = $count;
                $item['price'] = $itemsInfo[$code]['price'];
                $item['total_price'] = $itemsInfo[$code]['price'] * $count;
                $this->FactorItem->create();
                if ($this->FactorItem->save($item)){
                    $stuffObj->Stuff->id = $itemsInfo[$code]['id'];
                    if(!empty($stuffObj->Stuff->id)){
                        $stuffObj->Stuff->saveField('count', $itemsInfo[$code]['count'] - $count);
                    }
                }
            }
            return true;
        } 
        return false;
    }

/**
 * admin_edit method
 * //TODO: This function not work
 * @param string $id
 * @return void
 */
    public function admin_edit($id = null) {
        
        $this->helpers[] = 'TinyMCE.TinyMCE';
        $this->pageTitle = 'ویرایش  سفارش';
        $this->helpers[] = 'Validator';
        $this->FactorHead->id = $id;
        if (!$this->FactorHead->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->FactorHead->save($this->request->data)) {
                $this->Session->setFlash('سفارش با موفقیت ویرایش شد', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }else{
            $this->request->data = $this->FactorHead->read();
        }
        $categories = $this->FactorHead->Category->generateTreeList();
        $this->set('categories', $categories);
        $this->set('title', $this->pageTitle);
        $this->set('parentTitle', $this->_getParentTitle());
        $this->set('types', $this->FactorHead->namedType);
        $this->set('orders', $this->FactorHead->namedOrder);
        $this->render('admin_add');
    }

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
    public function admin_delete() {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }

        $id = $this->request->data['id']; // we recieve id via posted data
        $count = count($id);
        if ($count == 1) {
            $id = current($id);
            $this->FactorHead->id = $id;

            if ($this->FactorHead->delete()) {
                $this->Session->setFlash('سفارش با موفقیت حذف شد', 'message', array('type' => 'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'message', array('type' => 'error'));
            }
        } elseif ($count > 1) {
            $countAffected = 0;
            foreach ($id as $i) {
                $this->FactorHead->id = $i;
                if ($this->FactorHead->delete()) {
                    $countAffected++;
                }
            }
            $this->Session->setFlash($countAffected . ' سفارش حذف گردید', 'message', array('type' => 'success'));
        }
        $this->redirect($this->referer());
    }
    
/**
 * Add stuff to cart
 * This function can only used via AJAX, because it hasn't view
 * 
 * @return Count of Stuffs that exists in Cart
 */
    public function addToCart() {
        $this->autoRender = false;
        if (!$this->request->is('post')) {
            return false;
        }
        $stuff_id = $this->request->data('stuff_id');
        $count = intval($this->request->data('count'));
        if($count == 0){
            return 'تعداد صحیح وارد شود.';
        }
        $stuff = $this->Stuff->find('first', array('conditions' => array('id' => $stuff_id, 'published' => true, 'count >=' => $count ), 'contain' => false));
        if(empty($stuff)){
            return 'به اندازه تعداد درخواستی کالا در انبار موجود نمی باشد.';
        }
        
        $this->Session->write('Cart.item.'.$stuff_id, $count);
        
        return count($this->Session->read('Cart.item'));
    }
    
/**
 * Remove stuff from cart
 * Called only by POST request
 * 
 * @return void
 */
    public function deleteFromCart($stuff_id) {
        if (!$this->request->is('post')) {
            $this->Session->setFlash('درخواست معتبر نمی باشد', 'message', array('type' => 'error'));
            $this->redirect($this->referer());
        }
        if(empty($stuff_id)){
            $this->Session->setFlash('کالا معتبر نمی باشد.', 'message', array('type' => 'error'));
            $this->redirect($this->referer());
        }
        if($this->Session->check('Cart.item.'.$stuff_id)){
            $this->Session->delete('Cart.item.'.$stuff_id);
            $this->Session->setFlash('کالا از سبد خرید حذف گردید.', 'message', array('type' => 'success'));
        }else{
            $this->Session->setFlash('کالا در سبد خرید یافت نشد.', 'message', array('type' => 'error'));
        }
        $this->redirect($this->referer());
        
    }
    
/**
 * View Cart
 * 
 */
    public function viewCart(){
        
		$stuffs = $this->_readStuffFromCart();
        $this->set('deports', $this->Deport->find('all'));
        $this->set('stuffs', $stuffs);
        return $stuffs;
    }
	
/**
 * Read Stuff from cart and fetch other info for it from Tables
 */
	protected function _readStuffFromCart(){
		$items = $this->Session->read('Cart.item');
		if(empty($items)){
            $this->Session->setFlash('سبد خرید خالی می باشد.', 'message', array('type' => 'error'));
            $this->redirect($this->referer());
        }
        $stuffs = array();
        if($items){
            foreach($items as $stuff_id => $count){
                $stuffs[] = $this->Stuff->find('first', array('conditions' => array('Stuff.id' => $stuff_id, 'Stuff.published' => true, 'count >=' => $count )));
            }
        }
		return $stuffs;
	}
    
/**
 * Empty Cart
 * Empty cart and redirect to referer
 * 
 */
    public function emptyCart(){
        if (!$this->request->is('post')) {
            $this->Session->setFlash('درخواست معتبر نمی باشد', 'message', array('type' => 'error'));
            $this->redirect($this->referer());
        }
        $this->Session->delete('Cart.item');
        $this->Session->setFlash('سبد خرید خالی شد.', 'message', array('type' => 'success'));
        $this->redirect($this->referer());
    }
    
/**
 * Add Coupon to cart
 * This used via AJAX
 */
    public function addCoupon(){
        $this->autoRender = false;
        if (!$this->request->is('post')) {
            return false;
        }
        $coupon = $this->_loadController('Shop.Coupons')->_canUseCoupon(null, $this->request->data('coupon'));
        if(empty($coupon)){
            return 'کوپن یافت نشد.';
        }
        
        $this->Session->write('Cart.coupon', $coupon['Coupon']);
        //Send value with type, so if type is percent, calculate and show it
        return json_encode(array('type' => $coupon['Coupon']['discount_type'], 'value' => $coupon['Coupon']['discount_value']));
    }
    
/**
 * Set deport for cart
 * This used via AJAX
 */
    public function setDeport(){
        $this->autoRender = false;
        if (!$this->request->is('post')) {
            return false;
        }
        $deport_id = $this->request->data('deport_id');
        if($deport_id == 0){
            $this->Session->delete('Cart.deport');
            return true;
        }
        $deport = $this->Deport->read(null, $deport_id);
        if(empty($deport)){
            return 'روش ارسال یافت نشد.';
        }
        
        $this->Session->write('Cart.deport', $deport['Deport']);
        return true;
    }
    
/**
 * Delete Coupon from cart
 * Used via POST request
 */
    public function deleteCoupon(){
        if (!$this->request->is('post')) {
            $this->Session->setFlash('درخواست معتبر نمی باشد', 'message', array('type' => 'error'));
            $this->redirect($this->referer());
        }
        $this->Session->delete('Cart.coupon');
        $this->Session->setFlash('کوپن ثبت شده از درخواست حذف گردید', 'message', array('type' => 'success'));
        $this->redirect($this->referer());
    }
    
    public function submitCart(){
        //TODO: Check tax for any stuff
        if(!$this->_userIsLogin()){
            $this->redirect(array('action' => 'register'));
        }
        
        $stuffs = $this->_readStuffFromCart();
		
        $total = 0;
        if($stuffs){
            foreach($stuffs as $stuff){
                $price = $stuff['Stuff']['price'];
                if(!empty($stuff['Stuff']['discount'])){
                    $price = $stuff['Stuff']['PriceWithDiscount'];
                }
				// Multiple price with count and add to total
                $total += $price * $this->Session->read('Cart.item.'. $stuff['Stuff']['id']);
            }
        }
        $finalPrice = $total;
		
        /**
         * Coupon
         */
        if($this->Session->check('Cart.coupon')){
            if($this->Session->read('Cart.coupon.discount_type') == 1){
                $finalPrice -= $finalPrice * $this->Session->read('Cart.coupon.discount_value') / 100;
            }else{
                $finalPrice -=$this->Session->read('Cart.coupon.discount_value');
            }
        }
		
        /**
         * Deport
         */
        if($this->Session->check('Cart.deport')){
            $finalPrice +=$this->Session->read('Cart.deport.price');
        }
		
        /**
         * Tax
         */
        if($this->Session->check('Cart.tax')){
            $percent = $this->Session->read('Cart.tax.percent');
            $finalPrice += $finalPrice * $percent / 100;
        }
        
        $factorHead = array(
            'user_id' => $this->Auth->user('ShopUser.id'),
            'type' => 2, //خرید
            'date' => Jalali::date('Y/m/d'),
            'number' => Jalali::date('ymd'),
            'total_price' => $total,
            'coupon_id' => ($this->Session->check('Cart.coupon'))?$this->Session->read('Cart.coupon.id'):null,
            'deport_id' => ($this->Session->check('Cart.deport'))?$this->Session->read('Cart.deport.id'):null,
            'tax_id' => ($this->Session->check('Cart.tax'))?$this->Session->read('Cart.tax.id'):null,
            'final_price' => $finalPrice,
            
        );
        
        if($this->FactorHead->save($factorHead)){
            $this->FactorHead->saveField('number',$factorHead['number'].$this->FactorHead->id );
            $this->_changeStatus($this->FactorHead->id, -2);
			
            // Now after we save factor, we must redirect user to payment
            // We save only factor head and no change in count of stuffs,
            //TODO: remove save factor head and when user purchased, then add to tables
            $this->redirect(array('action' => 'sendPayment', $this->FactorHead->id));
        }else{
            $this->Session->setFlash('اشکال در ثبت سفارش', 'message', array('type' => 'error'));
            $this->redirect(array('action' => 'viewCart'));
        }
    } 
    
/**
 * View saved factor
 */
    public function viewFactor($factorID = null){
        $factor = $this->_readFactorFromUser($factorID);
        if(empty($factor)){
            $this->Session->setFlash('فاکتور یافت نشد.', 'message', array('type' => 'error'));
            $this->redirect(array('action' => 'index'));
        }
		// Check if user want see factor and factor paymented, so fetch payment info
        if($this->action == 'viewFactor' and $factor['FactorHead']['status'] > 0){
            $this->set('payInfo', $this->_getPaymentInfo($factorID));
        }
        $this->set(compact('factor'));
        return $factor;
    }
    
    protected function _getPaymentInfo($factorID){
        return $this->_loadController('Payments')->_getPaymentInfo('shop-'.$factorID);
    }
    
    protected function _readFactorFromUser($factorID){
        $this->FactorHead->recursive = 2;
        return $this->FactorHead->find('first', array(
            'conditions' => array(
                'FactorHead.id' => $factorID, 
                'FactorHead.user_id' => $this->Auth->user('ShopUser.id'), 
            ),
        ));
    }
    protected function _userIsLogin(){
        return $this->Auth->loggedIn();
    }
    
	//TODO: We must use UserController for this action
    public function register($type = null){
        $this->loadModel('State');
        $this->set('states', $this->State->find('threaded'));
        if ($this->request->is('post')) {
            $user = $this->_loadController('Users');
            $shop_user = $this->_loadController('Shop.User');
            
            switch($type){
                case 'register':
                    if($this->request->data['password'] != $this->request->data['password2']){
                        $this->Session->setFlash('رمز عبور با تکرار رمز عبور برابر نیست', 'message', array('type' => 'error'));
                        return;
                    }
                    $user_id = $user->_createUser(array(
                        'name' => $this->request->data['name'],
                        'username' => $this->request->data['username'],
                        'password' => $this->request->data['password'],
                        'role_id' => 18,
                        'active' => true,
                    ));
                    if(! $user_id){
                        return;
                    }
                    $shop_user_id = $shop_user->_createUser(array(
                        'user_id' => $user_id,
                        'type' => 2,
                        'address' => $this->request->data['address'],
                        'phone' => $this->request->data['phone'],
                        'mobile' => $this->request->data['mobile'],
                        'code_posti' => $this->request->data['code_posti'],
                        'city' => $this->request->data['city'],
                    ));
                    if(! $shop_user_id){
                        return;
                    }
                case 'login':
                    if(! $shop_user->_login($this->request->data['username'], $this->request->data['password'])){
                        return;
                    }
                    break;
                default:
                    return;
            }
            $this->redirect(array('action' => 'submitCart'));
        }
    }
    
/**
 * Initialize Payment params and redirect user to 
 *  payment page
 * 
 * 
 * @return void
 */
	public function sendPayment($factorID){
	   // This function read factor and if has error redirect user to index page
	   $factor = $this->viewFactor($factorID);
       
	   
       // get Ref ID
       $refID = 'shop-'.$factor['FactorHead']['id'];
       
       // get Object 
       $pay = $this->_loadController('Payments');
       
       // Check payment info
       $payInfo = $pay->_getPaymentInfo($refID);

       if($payInfo){
            $this->Session->setFlash('فاکتور قبلا پرداخت شده است.', 'message', array('type' => 'warning'));
            $this->redirect(array('action' => 'viewFactor', $factorID));
        
        // if has no payment info and data is sent, execute this
       }else{
            $price = $factor['FactorHead']['final_price'];
            $section = sprintf('فاکتور خرید <b>%s</b> به شماره خرید <b>%s</b>', $factor['ShopUser']['User']['name'], $factor['FactorHead']['number']);
            // Set Parameters for this payment
    		$pay->_setParams($price,array('controller' => 'Orders','action' => 'submitFactor', 'plugin' => 'Shop', $factor['FactorHead']['id']),$refID,array('Section' => $section, 'noTax' => true));
            
            // redirect to payment page
    		$this->redirect($pay->_sendPage());
        }
      
	}


    public function submitFactor($factorID){
        $factor = $this->viewFactor($factorID);
        $refID = 'shop-'.$factorID;// get Ref ID
        $pay = $this->_loadController('Payments');// get Object 
        $payInfo = $pay->_getPaymentInfo($refID);// Check payment info
        
        if($payInfo and $payInfo['status'] > 0){
        	
            $stuffs = $this->_readStuffFromCart();
            
            foreach($stuffs as $stuff){
                $count = $this->Session->read('Cart.item.'. $stuff['Stuff']['id']);
                $price = $stuff['Stuff']['price'];
                if(!empty($stuff['Stuff']['discount'])){
                    $price = $stuff['Stuff']['PriceWithDiscount'];
                }
                $factorItem = array(
                    'head_id' => $factorID,
                    'stuff_id' => $stuff['Stuff']['id'],
                    'count' => $count,
                    'price' => $price,
                    'total_price' => $price * $count,
                );
                $this->FactorItem->create();
                if($this->FactorItem->save($factorItem)){
                    $this->Stuff->updateAll(
                        array('Stuff.count' => 'Stuff.count - '.$count),
                        array('Stuff.id' => $factorItem['stuff_id'])
                    );
                }
            }
            $coupon = $this->_loadController('Shop.Coupons');
            $coupon->_useCoupon($factor['FactorHead']['coupon_id'], $this->FactorHead->id);
            $this->Session->delete('Cart');
            $this->_changeStatus($factorID, 1);
            $this->Session->setFlash('پرداخت با موفقیت انجام گردید', 'message', array('type' => 'success'));
            $this->redirect(array('action' => 'viewFactor', $factorID));
        }
        $this->Session->setFlash('اشکال در پرداخت', 'message', array('type' => 'error'));
        $this->redirect(array('action' => 'viewFactor', $factorID));
    }
    
/**
 * for Each changes in status of factor, we must store User, State, Date of any change 
 */
    protected function _changeStatus($factorID, $status){
        $this->FactorHead->id = $factorID;
        $this->FactorHead->recursive = -1;
        $factor = $this->FactorHead->read(array('status', 'status_dates'));
        $dates = json_decode($factor['FactorHead']['status_dates']);
        $dates[] = array(
            'u' => $this->Auth->user('id'),
            's' => $status,
            'd' => Jalali::dateTime(),
        );
        $dates = json_encode($dates);
        return $this->FactorHead->save(array('status' => $status, 'status_dates' => $dates)); 
    }
    
/**
 * fetch info of sell orders,
 * This function can use only from requestAction function
 * 
 * @passedArgs  status (status of order), type (type of find such as all, count, list, ...)
 * @return Info of sell orders
 */
    public function admin_getSellOrders(){
        $status = 0;
        if(!empty($this->passedArgs['status'])){ $status = $this->passedArgs['status']; }
        $type = 'all';
        if(!empty($this->passedArgs['type'])){ $type = $this->passedArgs['type']; }
        
        return $this->FactorHead->find($type, array(
            'conditions' => array(
                'FactorHead.type' => 2, // sell order
                'FactorHead.status' => $status,
            ),
        ));
    }  
/**
 * List Orders of current user
 */
    public function index(){
        unset($this->paginateConditions['type']);
        $this->paginate['conditions'] = array(
            'ShopUser.id' => $this->Auth->user('ShopUser.id'),
        ); 
        $orders = $this->paginate();
        $this->set(compact('orders'));
        $this->set('title', $this->pageTitle);
        $this->set('namedType', $this->FactorHead->namedType);
        $this->set('namedStatus', $this->FactorHead->namedStatus);
    } 
    
/**
 * fetch Statistics
 * This function can use only from requestAction function
 * 
 * @return return follow items 
 * 				newOrders : count of new orders,
 *  			todayOrders : count of new orders that submitted in today,
 * 				favoriteStuff : {name,count} of stuff that more than others ordered in new orders,
 * 				newestFactors : info of 5 newest orders,
 * 				newestFactors : info of 5 newest orders,
 */
    public function admin_getStatistics(){
        $stats = array();
        $stats['newOrders'] = $this->FactorHead->find('count', array(
            'conditions' => array(
                'FactorHead.type' => 2,
                'FactorHead.status' => 1,
            ),
        ));
        $stats['todayOrders'] = $this->FactorHead->find('count', array(
            'conditions' => array(
                'FactorHead.type' => 2,
                'FactorHead.status' => 1,
                'FactorHead.date' => Jalali::date('Y/m/d'),
            ),
        ));
        $favoriteStuff = $this->FactorItem->find('first', array(
            'conditions' => array(
                'FactorHead.type' => 2,
                'FactorHead.status >=' => 1,
            ),
            'fields' => array('Stuff.name', 'count(*) * FactorItem.count as c'),
            'contain' => array('Stuff', 'FactorHead'),
            'group' => 'FactorItem.stuff_id',
            'order' => 'c DESC',
        ));
        $stats['favoriteStuff']['name'] = @$favoriteStuff['Stuff']['name'];
        $stats['favoriteStuff']['count'] = @$favoriteStuff['0']['c'];
        
        $newestFactors = $this->FactorHead->find('all', array(
            'conditions' => array(
                'FactorHead.type' => 2,
                'FactorHead.status' => 1,
            ),
            'order' => 'FactorHead.id DESC',
            'contain' => 'ShopUser.User',
            'limit' => 5,
        ));
        $stats['newestFactors'] = $newestFactors;
        
        return $stats;
    }

    public function admin_details($factorID = null){
        if(empty($factorID)){
            $this->Session->setFlash('سفارش یافت نشد.', 'message', array('type' => 'error'));
            $this->redirect('/');
        }
        $this->FactorHead->recursive = 2;
        $factor = $this->FactorHead->read(null, $factorID);
        $this->set(compact('factor'));
        $this->pageTitle = 'مشاهده سفارش';
        $this->set('title', $this->pageTitle);
        $this->set('parentTitle', $this->_getParentTitle($factor['FactorHead']['type']));
    }
}
