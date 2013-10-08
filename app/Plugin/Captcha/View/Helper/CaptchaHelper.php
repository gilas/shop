<?php

/**
 * Copyright 2009-2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The LGPL License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2009-2010, Cake Development Corporation (http://cakedc.com)
 * @license LGPL License (http://www.opensource.org/licenses/lgpl-2.1.php)
 */

/**
 * TinyMCE Helper
 *
 * @package TinyMCE
 * @subpackage TinyMCE.View.Helper
 */
class CaptchaHelper extends AppHelper {

    /**
     * Other helpers used by FormHelper
     *
     * @var array
     */
    public $helpers = array('Html');


    
    public function showCaptcha(){
        
        return $this->Html->image(array('action' => 'captcha'), array('style' => 'cursor:pointer','title' => 'برای بارگذاری مجدد کلیک نمایید','onclick' => 'this.src = this.src + \'?\' + (new Date()).getTime();'));
    }

}
