<?php

/**
 * Filter Helper class used for filtering form in pages that must have pagination and limitation
 * 
 * @package     Gilas
 * @author      Hamid Mamdoohi
 * @copyright   2012
 * @version     0.1
 * @access      public
 */
class ProfileHelper extends AppHelper{
    
/**
 * Used Helpers
 *
 * @var array
 */
    public $helpers = array('Html','Form','Paginator');
    
    public function url($url = array()){
        $url = $this->Html->url($url);
        $newUrl = $this->Html->url('/').'~'. $this->request['username'].'/';
        return str_replace($this->Html->url('/'), $newUrl, $url);
    }
    
    public function link($title, $url = null, $options = array(), $confirmMessage = false) {
        $url = $this->Html->url($url);
        $newUrl = '/~'. $this->request['username'].'/';
        $url = str_replace($this->Html->url('/'), $newUrl, $url);
        return $this->Html->link($title, $url, $options, $confirmMessage);
    }
}