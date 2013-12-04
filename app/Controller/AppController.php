<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        'Acl',
        'Auth' => array(
            'authorize' => array('Actions' => array('actionPath' => 'controllers'),),
        ),
        'Session',
        'GilasAcl',
        //'DebugKit.Toolbar'
        //TODO: we have an error in ajax forms and some forms e: UsersController::admin_add
        //'Security',
    );
    public $helpers = array(
        'Form',
        'Html',
        'Session',
        'Validator',
    );

    /**
     * default paginate options
     */
    public $paginate = array('limit' => 20, 'paramType' => 'named');

    /**
     * this variable used for filtering in admin List
     * all fields that used in filter form must be come here
     * use 'type' index if you want use LIKE method
     */
    public $paginateConditions = array();
    
    public $publicActions = array('captcha');
    
    public $pageTitle = null;

    public function beforeFilter() {
        $classProperties = get_class_vars('AppController');
        if($this->publicActions !== '*'){
            if(is_string($this->publicActions)){
                $this->publicActions = array($this->publicActions);
            }
            $this->publicActions = array_merge($this->publicActions , $classProperties['publicActions']);
        }
        parent::beforeFilter();
        $this->__initializeAuth();
        $this->_loadSettings();
    }
    
    /**
     * Load Settings for system
     * 
     */
    protected function _loadSettings(){
        Configure::write('debug', SettingsController::read('System.Debug'));
    }
    
    private function __initializeAuth(){
        $this->Auth->authError = 'اجازه دسترسی به آدرس درخواستی را ندارید.';
        //$this->Auth->loginAction =    array('plugin' => null,'controller' => 'users','action' => 'login');
        //$this->Auth->logoutRedirect = array('plugin' => null,'controller' => 'users','action' => 'login');
        // Redirect to Shop
        $this->Auth->loginAction =    array('plugin' => 'Shop','controller' => 'User','action' => 'login');
        $this->Auth->logoutRedirect = array('plugin' => 'Shop','controller' => 'User','action' => 'login');
        $this->Auth->authenticate =   array(
            // Login Only actived users
            AuthComponent::ALL => array('scope' => array('User.active' => true)),
            'Form',
        );
        $this->Auth->flash =  array('element' => 'message','key' => 'auth','params' => array('type' => 'warning  no-margin-login top',));
        
        $this->Auth->allow($this->publicActions);
    }


    public function beforeRender() {
        parent::beforeRender();
        $this->theme = SettingsController::read('Site.Template');
        if ($this->request['prefix']) {
            $this->theme = null;
        }
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
        }
        if (!empty($this->request->named['layout'])) {
            $this->layout = 'iframe';
        }
        $this->set('title_for_layout', $this->pageTitle);
    }

    /**
     * Override paginate method for adding conditions fields 
     * 
     * @param mixed $object
     * @param mixed $scope
     * @param mixed $whitelist
     * @return
     */
    public function paginate($object = null, $scope = array(), $whitelist = array()) {
        if (@$this->paginate['paramType'] == 'querystring') {
            $query = $this->request->query;
        } else {
            $query = $this->request->named;
        }
        // we won't use this fields
        unset($query['page'], $query['limit']);
        $keys = array();
        // get paginateConditions and format it
        foreach ($this->paginateConditions as $i => $keyName) {
            $options = array();
            if (!is_int($i)) {
                $options = (array) $keyName;
                $keyName = $i;
            }
            $keys[$keyName] = $options;
            // Set default value, if it is set
            if(isset($options['default'])){
                if(empty($query[$keyName])){
                    $query[$keyName] = $options['default'];
                    // add default to request for another 
                    if (@$this->paginate['paramType'] == 'querystring') {
                       $this->request->query[$keyName] = $options['default'];
                    } else {
                        $this->request->params['named'][$keyName] = $options['default'];
                        
                    }
                }
            }
        }
        if($query){
            foreach ($query as $key => $value) {
                $field = $key;
                if (!empty($keys[$key]['field'])) {
                    $field = $keys[$key]['field'];
                }
                // used only query keys that becomes in paginateConditions
                if (!in_array($key, array_keys($keys))) {
                    continue;
                }

                // we may have more than one named param with one key, so we recieve first param
                if (is_array($value)) {
                    $value = array_shift($value);
                }

                // escape empty values
                if (strlen($value) == 0) {
                    continue;
                }

                // no option for this key
                if (empty($keys[$key]['type'])) {
                    // field is array, so we must OR between their
                    if(is_array($field)){
                        foreach($field as $f){
                            $this->paginate['conditions']['OR'][$f] = $value;
                        }
                    }else{
                        $this->paginate['conditions'][$field] = $value;
                    }
                    continue;
                } elseif (strtoupper(@$keys[$key]['type']) == 'LIKE') {
                    // field is array, so we must OR between their
                    if(is_array($field)){
                        foreach($field as $f){
                            $this->paginate['conditions']['OR'][$f . ' LIKE'] = '%' . $value . '%';
                        }
                    }else{
                        $this->paginate['conditions'][$field . ' LIKE'] = '%' . $value . '%';
                    }
                    continue;
                }
            }
        }

        // add this helper for using FilterHelper in Filter Form
        $this->helpers[] = 'Filter';
        // call parent method and return it
        return parent::paginate($object, $scope, $whitelist);
    }

    /**
     * choose action for given action via adminForm
     * all sent data for admin form will be recieve by this action and this action choose requested action
     * @return void
     */
    public function admin_dispatch() {
        if (empty($this->request->data['action'])) {
            $this->Session->setFlash('اشکال در پردازش اطلاعات', 'alert', array('type' => 'error'));
            $this->redirect($this->referer());
        }
        $action = $this->request->data['action'];
        unset($this->request->data['action']);
        if($this->GilasAcl->hasPermission(array('action' => $action))){
            //with prefix
            return $this->setAction('admin_' . $action);
        }
        $this->Auth->flash($this->Auth->authError);
        $this->redirect($this->referer());
    }
    
    /**
     * choose action for given action via adminForm
     * all sent data for admin form will be recieve by this action and this action choose requested action
     * @return void
     */
    public function dispatch() {
        if (empty($this->request->data['action'])) {
            $this->Session->setFlash('اشکال در پردازش اطلاعات', 'alert', array('type' => 'error'));
            $this->redirect($this->referer());
        }
        $action = $this->request->data['action'];
        unset($this->request->data['action']);
        if($this->GilasAcl->hasPermission(array('action' => $action))){
            //without prefix
            return $this->setAction($action);
        }
        $this->Auth->flash($this->Auth->authError);
        $this->redirect($this->referer());
    }

    /**
     * Specify row can move Up or move down, by adding 'hasRight' and 'hasLeft' indexes
     *  if row has right brother so can move down
     *  if row has left brother so can move up
     * @param mixed $rows
     * @param mixed $model : model Name
     * @return void
     */
    protected function _recognizeMoving(&$rows, $model) {
        if ($rows) {
            // Check the item can move to up or down
            //      rght = lft - 1    lft  rght     lft = rght + 1
            //     ----------        ----------      -----------
            //     left child         current        right child   
            //
            foreach ($rows as &$row) {
                $left = $row[$model]['lft'];
                $right = $row[$model]['rght'];
                foreach ($rows as $r) {
                    // escape own
                    if ($r[$model]['id'] == $row[$model]['id']) {
                        continue;
                    }
                    // right item so item can move to down 
                    if ($r[$model]['lft'] == ($right + 1)) {
                        $row[$model]['hasRight'] = true;
                    }

                    // left item so item can move to up
                    if ($r[$model]['rght'] == ($left - 1)) {
                        $row[$model]['hasLeft'] = true;
                    }
                }
            }
        }
    }

    /**
     * Change value for field from model by given id and show flash message
     * This action used for AdminForms that send id of rows via post
     * 
     * @param mixed $model
     * @param mixed $field
     * @param mixed $value
     * @param mixed $flashMessage
     * @return void
     */
    protected function _changeStatus($model, $field, $value, $flashMessage) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        $id = $this->request->data['id'];
        $count = count($id);
        if ($count == 1) {
            $id = current($id);
            $this->{$model}->id = $id;
            if ($this->{$model}->saveField($field, $value)) {
                $this->Session->setFlash($flashMessage, 'message', array('type' => 'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-17'), 'message', array('type' => 'error'));
            }
        } elseif ($count > 1) {
            $countAffected = 0;
            foreach ($id as $i) {
                $this->{$model}->id = $i;
                if ($this->{$model}->saveField($field, $value)) {
                    $countAffected++;
                }
            }
            $this->Session->setFlash($countAffected . ' ' . $flashMessage, 'message', array('type' => 'success'));
        }
    }

    /**
     * Move up or down for given id via post for specified $model then show $flashMessage
     * 
     * @param mixed $model
     * @param mixed $flashMessage
     * @return void
     */
    protected function _move($model, $flashMessage) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        $id = $this->request->data['id'];
        $type = $this->request->data['type'];
        $type = ($type == 'Up') ? 'Up' : 'Down';
        // moveUp or moveDown
        $type = 'move' . $type;
        $count = count($id);
        if ($count == 1) {
            $id = current($id);
            // moveUp or moveDown
            if ($this->{$model}->{$type}($id)) {
                $this->Session->setFlash($flashMessage, 'message', array('type' => 'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-17'), 'message', array('type' => 'error'));
            }
        } elseif ($count > 1) {
            $countAffected = 0;
            foreach ($id as $i) {
                if ($this->{$model}->{$type}($i)) {
                    $countAffected++;
                }
            }
            $this->Session->setFlash($countAffected . ' ' . $flashMessage, 'message', array('type' => 'success'));
        }
    }
    
    /**
     * Use to load Controller in another Controllers
     * 
     * @param mixed $controller : name of controller without "Controller" trailer
     * @param bool $initialize : true of false , for call constructClasses()
     * @return : Object of $controller
     */
    protected function _loadController($controller, $initialize = true){
        App::import('Controller',$controller);
        $controller = pluginSplit($controller);
        $controller = $controller[1] . 'Controller';
        $obj = new $controller;
        if($initialize){
            $obj->constructClasses();
        }
        return $obj;
    }
    
    /**
     * Settings for each Controller
     * the Controller must be has a view file for this action that call in it the below code
     * echo $this->requestAction(array('controller' => 'settings', 'action' => 'index', 'section' => '{Your-Section}'), array('return'));
     * 
     * @return void
     */
    public function admin_settings(){}
    
    /**
     * Send PM
     * 
     * @param mixed $user_id
     * @param mixed $subject
     * @param mixed $message
     * @return
     */
    protected function _sendPM($user_id, $subject, $message){
        $pms = $this->_loadController('Pms');
        return $pms->_send(array(
            'subject' => $subject,
            'message' => $message,
            'Recipients' => array(
                array(
                    'user' => $user_id,
                    'parent_id' => 0,
                )
            ),
        ));
    }
    
    /**
     * Send Email
     * 
     * @param mixed $user_id
     * @param mixed $subject
     * @param mixed $message
     * @return
     */
    protected function _sendEmail($subject, $message, $to = null, $from = null){
        
        if(empty($to)){
            $to = array('info@mosafer-behesht.com' => 'ستاد ساماندهی امور زائرین');
        }
        
        if(empty($from)){
            $from = array('info@mosafer-behesht.com' => 'ستاد ساماندهی امور زائرین');
        }
        App::uses('CakeEmail', 'Network/Email');
        
        $email = new CakeEmail('default');
        
        $email->from($from);
        $email->to($to);
        $email->subject($subject);
        if($email->send($message)){
            return true;
        }
        return false;
    }
    
    protected function _clearCache($key){
        $dir = new Folder(CACHE);
        $cacheSetting = Cache::settings();
        $files = $dir->find($cacheSetting['prefix'] . $key . '(.*)');
        
        if($files){
            foreach($files as $file){
                // remove prefix
                $file = str_replace($cacheSetting['prefix'], '', $file);
                Cache::delete($file);
            }
        }
    }
    
    public function captcha()  {
        $this->autoRender = false;
        $this->layout='ajax';
        if(!isset($this->Captcha))   { //if Component was not loaded throug $components array()
            App::import('Component','Captcha.Captcha'); //load it
            $this->Captcha = new CaptchaComponent($this->Components); //make instance
        }
        $this->Captcha->create(100,30,6);
    }
    
}
