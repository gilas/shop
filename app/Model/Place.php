<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Place extends AppModel {

    public $tablePrefix = 'yg_';
    public $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'ورود نام برای مکان الزامی است',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        )
    );

}

?>
