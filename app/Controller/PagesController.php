<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

    public $publicActions = array('display');
    
    // List of defined actions in this controller that must exec
    public $definedActions = array(
        'contact_us',
    );
/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Pages';

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 */
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
        if(in_array($page, $this->definedActions)){
            return $this->setAction($page);
        }
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}
    
    function contact_us(){
        $this->pageTitle = 'ارتباط با ما';
        if($this->request->isPost()){
            $subject = 'پیام از طرف '.$this->request->data['name'];
            $message = $this->request->data['message'];
            $email = $this->request->data['email'];
                        
           $messageForUs = $message. '<br/> فرستنده پیام : '.  $this->request->data['name'].' ، پست الکترونیک : '. $email;
           // send email for us
            if($this->_sendEmail($subject, $messageForUs, null,null)){
                // send email for user
               if($this->request->data['forward']){
                    $this->_sendEmail($subject, $message, null,$email);
               }
                $this->Session->setFlash('پیام ارسال گردید','message', array('type' => 'success'));
                $this->redirect('/');
           }else{
               $this->Session->setFlash('اشکال در ارسال پیام','message', array('type' => 'error'));
           }
        }
        
    }
}
