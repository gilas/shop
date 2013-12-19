<?php
App::uses('ShopAppController', 'Shop.Controller');
/**
 * Users Controller
 *
 */
class UserController extends ShopAppController {
    
    public $uses = array('Shop.ShopUser');
    public $baseUser = null;
    
    public $paginateConditions = array(
        'group' => array(
            'field' => 'ShopUser.group_id',
        ),
        'type' => array(
            'field' => 'ShopUser.type',
        ),
        'name' => array(
            'field' => 'User.name',
            'type' => 'LIKE',
        ),
    );
    
    public $publicActions = array('admin_detail','login', 'register');
    
    public function beforeFilter() {
        $this->baseUser = $this->_loadController('Users');
        parent::beforeFilter();
    }
    
    protected function _getParentTitle(){
        return 'مدیریت مشتریان';
    }
    
    public function admin_index(){
        $this->pageTitle = $this->_getParentTitle();
        $this->helpers[] = 'AdminForm';
        $this->set('users',$this->paginate());
        $this->set('groups', $this->ShopUser->Group->find('list'));
        $this->set('title', $this->pageTitle);
        $this->set('types', $this->ShopUser->namedType);
    }
    
    public function admin_details($id = null){
       $user = $this->ShopUser->read(null, $id);
       $this->pageTitle = 'جزئیات کاربر';
       $this->set('title', $this->pageTitle);
       $this->set('parentTitle',$this->_getParentTitle());
        $this->set(compact('user'));
    }
    
    public function admin_add(){
    	$this->pageTitle = 'افزودن کاربر';
		$this->set('title', $this->pageTitle);
       	$this->set('parentTitle',$this->_getParentTitle());
		$this->set('roles',$this->ShopUser->User->Role->find('list'));
		$this->set('types',$this->ShopUser->namedType);
        $this->loadModel('State');
        $this->set('states', $this->State->find('threaded'));
		
        if ($this->request->is('post')) {
            if($this->request->data['User']['password'] != $this->request->data['User']['password-2']){
                $this->Session->setFlash('رمز عبور با تکرار رمز عبور برابر نیست', 'message', array('type' => 'error'));
                return;
            }
			
            $user_id = $this->baseUser->_createUser(array(
                'name' => $this->request->data['User']['name'],
                'username' => $this->request->data['User']['username'],
                'password' => $this->request->data['User']['password'],
                'email' => $this->request->data['User']['email'],
                'role_id' => $this->request->data['User']['role_id'],
                'active' => $this->request->data['User']['active'],
            ));
			
            if(! $user_id){
                return;
            }
			
            $shop_user_id = $this->_createUser(array(
                'user_id' => $user_id,
                'type' => 2,
                'address' => $this->request->data['ShopUser']['address'],
                'phone' => $this->request->data['ShopUser']['phone'],
                'mobile' => $this->request->data['ShopUser']['mobile'],
                'code_posti' => $this->request->data['ShopUser']['code_posti'],
                'city' => $this->request->data['ShopUser']['city'],
            ));
			
            if(! $shop_user_id){
                $this->ShopUser->delete($user_id);
                return;
            }
			$this->redirect(array('action' => 'index'));
        }
    }
    public function admin_edit($id = null){
        $this->pageTitle = 'ویرایش کاربر';
		$this->set('title', $this->pageTitle);
       	$this->set('parentTitle',$this->_getParentTitle());
		$this->set('roles',$this->ShopUser->User->Role->find('list'));
        $this->loadModel('State');
        $this->set('states', $this->State->find('threaded'));
		
		$this->ShopUser->id = $id;
        if (!$this->ShopUser->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        $user = $this->ShopUser->read();
        if($this->request->is('post') || $this->request->is('put')){
            if($this->request->data['User']['password'] !== $this->request->data['User']['password-2']){
                $this->Session->setFlash('کلمه عبور با تکرار کلمه عبور برابر نیست','alert',array('type' => 'error'));
                return;
            }
            if(empty($this->request->data['User']['password'])){
                unset($this->request->data['User']['password']);
            }
            
            // user cann't inactive self
            if($id == $this->Auth->user('id')){
                $this->request->data['User']['active'] = 1;
            }
            $this->ShopUser->User->id = $user['ShopUser']['user_id'];
            if($this->ShopUser->User->save($this->request->data['User']) and $this->ShopUser->save($this->request->data['ShopUser'])){
                $this->Session->setFlash('کاربر ویرایش گردید','alert',array('type' => 'success'));
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Session->setFlash('اشکال در ویرایش کاربر','alert',array('type' => 'error'));
            }
        } else {
            $this->request->data = $this->ShopUser->read();
            //unset this field
            unset($this->request->data['User']['password']);
        }
		
		$this->render('admin_add');
    }
    public function admin_delete(){
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        $this->_doSafe();
        $id = $this->request->data['id']; // we recieve id via posted data
        $count = count($id);
        if ($count == 1) {
            $id = current($id);
            $this->ShopUser->id = $id;
			$shop_user = $this->ShopUser->read();
            if ($this->ShopUser->delete($id, false)) {
            	$this->ShopUser->User->delete($shop_user['ShopUser']['user_id']);
                $this->Session->setFlash('کاربر با موفقیت حذف شد.', 'alert', array('type' => 'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'alert', array('type' => 'error'));
            }
        } elseif ($count > 1) {
            $countAffected = 0;
            foreach ($id as $i) {
                $this->User->id = $i;
				$shop_user = $this->ShopUser->read();
                if ($this->ShopUser->delete($id, false)) {
                	$this->ShopUser->User->delete($shop_user['ShopUser']['user_id']);
                    $countAffected++;
                }
            }
            $this->Session->setFlash($countAffected . ' کاربر با موفقیت حذف شد.', 'alert', array('type' => 'success'));
        }else{
            $this->Session->setFlash(SettingsController::read('Error.Code-17'), 'alert', array('type' => 'error'));
        }
        $this->redirect($this->referer());
    }
	
	public function admin_active(){
		$this->loadModel('User');
		if($this->request->data['id']){
			foreach($this->request->data['id'] as &$id){
				$shop_user = $this->ShopUser->find('first', array(
					'conditions' => array('id' => $id),
					'contain' => false,
					'fields' => 'user_id',
				));
				$id = $shop_user['ShopUser']['user_id'];
			}
		}
        $this->_changeStatus('User', 'active', 1, 'کاربر فعال گردید.');
        $this->redirect($this->referer());
    }
    
    public function admin_inactive(){
    	$this->loadModel('User');
		if($this->request->data['id']){
			foreach($this->request->data['id'] as &$id){
				$shop_user = $this->ShopUser->find('first', array(
					'conditions' => array('id' => $id),
					'contain' => false,
					'fields' => 'user_id',
				));
				$id = $shop_user['ShopUser']['user_id'];
			}
		}
        //remove owner from list
        $this->_doSafe();
        $this->_changeStatus('User', 'active', 0, 'کاربر غیرفعال گردید.');
        $this->redirect($this->referer());
    }
	
	/**
 *  Safe sent Data and remove owner from it
 */
    protected function _doSafe(){
        //remove owner acount
        if(! empty($this->request->data['id'])){
            foreach($this->request->data['id'] as $key => $user_id){
                if($user_id == $this->Auth->user('id')){
                    unset($this->request->data['id'][$key]);
                }
            }
        }
    }
    
    
    /**
     * View information of current user to current user
     */
    public function view(){
        $user = $this->ShopUser->read(null, $this->Auth->user('ShopUser.id'));
        $this->set(compact('user'));
    }
    
    /**
     * Edit information of current user
     */
    public function edit(){
        $user = $this->ShopUser->read(null, $this->Auth->user('ShopUser.id'));
        $this->set(compact('user'));
        if($this->request->is('post')){
            if($this->request->data('User.password') != $this->request->data('User.password1')){
                $this->Session->setFlash('رمز عبور با تکرار آن برابر نیست', 'message', array('type' => 'error'));
            }
            $shopUser = array(
                'mobile' => $this->request->data('User.mobile'),
                'phone' => $this->request->data('User.phone'),
                'address' => $this->request->data('User.address'),
            );
            $this->ShopUser->id = $this->Auth->user('ShopUser.id');
            $this->ShopUser->save($shopUser);
            
            $user = array(
                'name' => $this->request->data('User.name'),
                'email' => $this->request->data('User.email'),
                'password' => $this->request->data('User.password'),
            );
            $this->baseUser->_updateUser($this->Auth->user('ShopUser.user_id'), $user);
            $this->Session->setFlash('اطلاعات کاربر ویرایش گردید.', 'message', array('type' => 'success'));
            $this->redirect(array('action' => 'view'));
        }
    }
    
    /**
     * Create User, This function used with other Controllers
     * 
     * @param mixed $user , must contain this fields
     *          user_id, type, address, phone, mobile
     * @return
     */
    public function _createUser($user = array()){
        if(empty($user)){
            return false;
        }
        $user['group_id'] = 1;
        $this->ShopUser->create();
        if(! $this->ShopUser->save($user)){
            return false;
        }
        return $this->ShopUser->id ;
    }
    
    public function _login($username, $password){
        $success = $this->baseUser->_login($username, $password);
        if(! $success){ return false;}
        $shopUser = $this->ShopUser->find('first', array(
            'conditions' => array('user_id' => $this->Auth->user('id')),
            'contain' => 'Group',
        ));
		
        if(! $shopUser){ 
            $this->Auth->logout();
            return false;
        }
        $shopUser['ShopUser']['Group'] = $shopUser['Group'];
        $shopUser = $shopUser['ShopUser'];
        $this->Session->write('Auth.User.ShopUser', $shopUser);
        return true;
    }
    
    public function login(){
        $this->pageTitle = 'ورود کاربران';
        if ($this->Auth->loggedIn()) {
            $this->redirect('/');
        }
        if ($this->request->is('post')) {
            $success = $this->_login($this->request->data('User.username'), $this->request->data('User.password'));
            if ($success) {
                $this->Session->setFlash('شما با موفقیت وارد سیستم شدید', 'message', array('type' => 'success'));
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-11'), 'message', array('type' => 'error'));
            }
        }
		$this->loadModel('State');
        $this->set('states', $this->State->find('threaded'));
    }

    public function register(){
        $this->loadModel('State');
        $this->set('states', $this->State->find('threaded'));
        if ($this->request->is('post')) {
            if($this->request->data['password'] != $this->request->data['password2']){
                $this->Session->setFlash('رمز عبور با تکرار رمز عبور برابر نیست', 'message', array('type' => 'error'));
                return;
            }
            $user_id = $this->baseUser->_createUser(array(
                'name' => $this->request->data['name'],
                'username' => $this->request->data['username'],
                'password' => $this->request->data['password'],
                'email' => $this->request->data['email'],
                'role_id' => 18,
                'active' => true,
            ));
            if(! $user_id){
                return;
            }
            $shop_user_id = $this->_createUser(array(
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
			$this->_login($this->request->data['username'], $this->request->data['password']);
			$this->redirect('/');
			//TODO: Must redirect to link given by url
            //$this->redirect(array('action' => 'submitCart'));
        }
		$this->render('login');
    }
    
    public function admin_getStatistics(){
        $stats = array();
        $stats['newUsers'] = $this->ShopUser->find('all', array(
            'contain' => 'User',
            'order' => 'ShopUser.id DESC',
            'limit' => 5,
        ));
        return $stats;
    }
}
