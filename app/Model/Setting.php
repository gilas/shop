<?php

App::uses('AppModel', 'Model');

/**
 * Setting Model
 *
 */
class Setting extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'site_name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'site_name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'ورود نام سایت الزامی است',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'admin_address' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'ورود آدرس پوشه مدیریت الزامی است',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

}
