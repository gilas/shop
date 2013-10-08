<?php
class Role extends AppModel {
    public $actsAs = array('Tree');
    public $hasMany = array('User');
    public $hasOne = array(
        'Aro' => array('foreignKey' => 'foreign_key'),
    );
    public $validate = array(
        'name' => array(
            'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'تکمیل این فیلد ضروری است',
			),
        ),
        'title' => array(
            'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'تکمیل این فیلد ضروری است',
			),
        ),
    );
}