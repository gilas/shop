<?php

class Tax extends ShopAppModel {


	public $displayField = 'name';
    
    public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'ورود عنوان الزامی است',
			),
		),
        'percent' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'ورود درصد مالیات الزامی است',
			),
		),
    );
}
