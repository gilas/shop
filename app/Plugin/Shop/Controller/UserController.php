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
    );
    
    public $publicActions = array('admin_detail','login');
    
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
        //TODO: Complete it
    }
    public function admin_edit($id = null){
        //TODO: Complete it
    }
    public function admin_delete(){
        //TODO: Complete it
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
        $this->baseUser = $this->_loadController('Users');
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
            $this->baseUser = $this->_loadController('Users');
            debug($this->request->data);
            $success = $this->baseUser->_login($this->request->data('User.username'), $this->request->data('User.password'));
            if ($success) {
                
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
                
                $this->Session->setFlash('شما با موفقیت وارد سیستم شدید', 'message', array('type' => 'success'));
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-11'), 'message', array('type' => 'error'));
            }
        }
        $this->render('/Users/login');
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
