<?php

/*
 * Created By : Mohammad Razzaghi
 * Email : 1razzaghi@gmail.com
 * Blog : http://bigitblog.ir
 * Social Networks : 
 *          http://facebook.com/1razzaghi
 *          http://twitter.com/1razzaghi
 */

class UsersController extends AppController {
    
    public $publicActions = array('login', 'logout','register');
    
    public $paginateConditions = array(
        'username' => array(
            'type' => 'LIKE',
            'field' => 'User.username',
        ),
        'active' => array('field' => 'User.active'),
        'role_id' => array('field' => 'User.role_id'),
    );
    public $components = array('Captcha.Captcha');
    
    public function beforeRender() {
        parent::beforeRender();
        if ($this->request->params['action'] == 'admin_login')
            $this->layout = 'login';
    }

    public function admin_login() {
        $this->layout = 'login';
        $this->pageTitle = 'ورود به قسمت مدیریت';
        $this->Auth->authenticate['Form']['scope'] = array('Role.name' => array('Admin', 'SuperAdmin') );
        if ($this->Auth->loggedIn()) {
            $this->redirect(array('controller' => 'dashboards', 'action' => 'index', 'admin' => TRUE));
        }
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                //Update Fields
                $this->User->id = $this->Auth->user('id');
                $this->User->save(array(
                    'last_logged_in' => Jalali::dateTime(),
                    'last_ip_logged_in' => $this->request->clientIp(),
                ));
                $this->Session->setFlash('شما با موفقیت وارد سیستم شدید', 'message', array('type' => 'success'));
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-11'), 'message', array('type' => 'error'));
            }
        }
    }
    
    public function login(){
        $this->pageTitle = 'ورود کاربران';
        if ($this->Auth->loggedIn()) {
            $this->redirect('/');
        }
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                //Update Fields
                $this->User->id = $this->Auth->user('id');
                $this->User->save(array(
                    'last_logged_in' => Jalali::dateTime(),
                    'last_ip_logged_in' => $this->request->clientIp(),
                ));
                $this->Session->setFlash('شما با موفقیت وارد سیستم شدید', 'message', array('type' => 'success'));
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-11'), 'message', array('type' => 'error'));
            }
        }
    }
    
    public function _login($username, $password){
        $user = $this->User->find('first', array(
            'conditions' => array('username' => $username, 'password' => AuthComponent::password($password) , 'active' => true),
            'contain' => 'Role',
        ));
        if(empty($user)){
            return false;
        }
        // for artichecure in Auth
        $user['User']['Role'] = $user['Role'];
        $user = $user['User'];
        if ($this->Auth->login($user)) {
            //Update Fields
            $this->User->id = $this->Auth->user('id');
            $this->User->save(array(
                'last_logged_in' => Jalali::dateTime(),
              //  'last_ip_logged_in' => $this->request->clientIp(),
            ));
        }
        return (bool)$user;
    }

    public function admin_logout() {
        $this->Session->setFlash('شما با موفقیت از سیستم خارج شدید', 'message', array('type' => 'success'));
        $this->redirect($this->Auth->logout());
    }
    public function logout() {
        $this->admin_logout();
    }

    public function admin_index(){
        $this->helpers[] = 'AdminForm';
        $this->set('users',$this->paginate());
        $this->set('roles', $this->User->Role->find('list'));
    }
    
    public function admin_active(){
        $this->_changeStatus('User', 'active', 1, 'کاربر فعال گردید.');
        $this->redirect($this->referer());
    }
    
    public function admin_inactive(){
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
    
    public function admin_add(){
        $this->helpers[] = 'Validator';
        $this->pageTitle = 'افزودن کاربر';
        $this->set('roles',$this->User->Role->find('list'));
        if($this->request->is('post')){
            if($this->request->data['User']['password'] !== $this->request->data['User']['password-2']){
                $this->Session->setFlash('کلمه عبور با تکرار کلمه عبور برابر نیست','message',array('type' => 'error'));
                return;
            }
            $this->request->data['User']['registered_date'] = Jalali::dateTime();
            if($this->User->save($this->request->data)){
                $this->Session->setFlash('کاربر جدید درج گردید','message',array('type' => 'success'));
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Session->setFlash('اشکال در درج کاربر جدید','message',array('type' => 'error'));
            }
        }
    }
    
    public function admin_edit($id = null){
        $this->helpers[] = 'Validator';
        $this->pageTitle = 'ویرایش کاربر';
        $this->set('roles',$this->User->Role->find('list'));
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        
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
            if($this->User->save($this->request->data)){
                $this->Session->setFlash('کاربر ویرایش گردید','alert',array('type' => 'success'));
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Session->setFlash('اشکال در ویرایش کاربر','alert',array('type' => 'error'));
            }
        } else {
            $this->request->data = $this->User->read();
            //unset this field
            unset($this->request->data['User']['password']);
        }
    }
 
    public function admin_delete() {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        $this->_doSafe();
        $id = $this->request->data['id']; // we recieve id via posted data
        $count = count($id);
        if ($count == 1) {
            $id = current($id);
            $this->User->id = $id;

            if ($this->User->delete()) {
                $this->Session->setFlash('کاربر با موفقیت حذف شد.', 'alert', array('type' => 'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'alert', array('type' => 'error'));
            }
        } elseif ($count > 1) {
            $countAffected = 0;
            foreach ($id as $i) {
                $this->User->id = $i;
                if ($this->User->delete()) {
                    $countAffected++;
                }
            }
            $this->Session->setFlash($countAffected . ' کاربر با موفقیت حذف شد.', 'alert', array('type' => 'success'));
        }else{
            $this->Session->setFlash(SettingsController::read('Error.Code-17'), 'alert', array('type' => 'error'));
        }
        $this->redirect($this->referer());
    }
    
    /**
     * Create User, This function used with other Controllers
     * 
     * @param mixed $user , must contain this fields
     *          name, username, password, role_id
     * @return
     */
    public function _createUser($user = array()){
        if(empty($user)){
            return false;
        }
        $this->User->create();
        $user['registered_date'] = Jalali::dateTime();
        if(! $this->User->save($user)){
            return false;
        }
        return $this->User->id ;
    }
    
    public function register(){
        $this->pageTitle = 'ثبت نام';
        
        $showCaptcha = SettingsController::read('User.showCaptcha');
        if($showCaptcha){
            $this->helpers[] = 'Captcha.Captcha';    
        }
        if($this->data){
            if($showCaptcha){
                if(! $this->Captcha->check($this->data['User']['captcha'])){
                    $this->Session->setFlash('برابر نیست', 'message', array('type' => 'error'));
                }
            }
        }
    }

}

?>
