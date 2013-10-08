<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
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
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class AppHelper extends Helper {
    // used for disable prefix in links
    // disable plugin 
    // only used in HtmlHelper
    public function defaultLink($title, $url = null, $options = array(), $confirmMessage = false) {
        if(! is_a($this,'HtmlHelper')){
            return;
        }
        if(is_array($url)){
            $prefixes = Router::prefixes();
            foreach($prefixes as $prefix)
            {
                // if user specified prefix break loop
                if(isset($url[$prefix])){
                    break;
                }
                $url[$prefix] = false;    
                
            }
            $url['plugin'] = false;
        }
        
        
        return $this->link($title, $url, $options, $confirmMessage);

    }
	
	public function getCityAsOptionTag($states){
		$output = '';
		foreach($states as $state){
			$cities = '';
			foreach($state['children'] as $city){
				$cities .= $this->tag('option',$city['State']['name'],array('value' => $city['State']['id']));
			}
			$output .= $this->tag('optgroup',$cities,array('label' => $state['State']['name']));
		}
		return $output;
	}
	
	public function getCityList($states){
		$output = array();
		foreach($states as $state){
			$cities = array();
			foreach($state['children'] as $city){
				$cities[$city['State']['id']] =  $city['State']['name'];
			}
			$output[$state['State']['name']] = $cities ;
		}
		return $output;
	}
	
	public function price($price,$showUnit = true){
	   $number = number_format($price);
       if($showUnit){
        $number .= ' ریال';
       }
		return $number;
	}
    
    public function percent($number){
        return $number . ' %';
    }
    
    // ToolTip
    //NOTICE: if you use tooltip, use must load qtip.js manually
    public $tooltipCounts = 0;
    public function tooltip($message){
        $id = 'tip'. $this->tooltipCounts;
        $this->tooltipCounts ++ ;
        $this->scriptBlock('$(function(){$("#'.$id.'").qtip({content: "'.$message.'",position: {corner: {tooltip: "bottomMiddle",target: "topLeft"}},show: "mouseover",hide: "mouseout",style: {lineHeight:1.5, textAlign: "right",tip: true,name: "blue"}});})',array('inline' => false));
        return $this->image('icons/info.png',array('id' => $id, 'style' => 'width:15px; margin: 0 5px;'));
    }
}
