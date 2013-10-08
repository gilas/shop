<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
    public $actsAs = array('Containable');
    
/**
 * Update children level for current row 
 * 
 * @return void
 */
    public function updateChildrenLevel(){
        $this->recursive = -1;
        $row = $this->read();
        $children = $this->children(null,true);
        if($children){
            foreach($children as $child){
                $this->id = $child[$this->name]['id'];
                $this->saveField('level',$row[$this->name]['level'] + 1);
                $this->updateChildrenLevel();
            }
        }
    }
    
    public function beforeSave(){
        $this->data[$this->name]['modified'] = Jalali::dateTime();
        // So this is new row
        if(! $this->id){
            $this->data[$this->name]['created'] = $this->data[$this->name]['modified'];
        }
        return true;
    }
    
/**
 * find State and City for gived result
 *      this method find 'city' index in result array and add two index 'State','City' to result array that this
 * notice : this Model must has accociate with State Model  
 * 
 * @param array $result this param must contain city index
 */
    protected function _getCityInfo(&$result){
        if(empty($result['city'])){
            return ;
        }
        $city = $this->State->find('first',array(
            'conditions' => array(
                'id' => $result['city']
            ),
        )
        );
        $result['City'] = $city['State'];
        
        $state = $this->State->find('first',array(
            'conditions' => array(
                'id' => $city['State']['parent_id']
            ),
            )
        );  
        $result['State'] = $state['State'];  
    }
    
    function checkDate($check){
        return preg_match('^1[0-9]{3}-[0-1]{1}[0-9]{1}-[0-3]{1}[0-9]{1}^', current($check));
    }
}
