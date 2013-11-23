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
    
    public $publicActions = array('admin_detail');
    
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
    
    //TODO: Complete it
    public function admin_detail($id = null){
        echo 'fd';
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
}
