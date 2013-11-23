<?php

class Group extends ShopAppModel {
    
    public $displayField = 'name';
    
    public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'ورود عنوان گروه الزامی است.',
			),
		),
        'discount' => array(
			'range' => array(
				'rule' => array('range', -1, 101),
				'message' => 'درصد تخفیف باید مابین 0 و 100 باشد.',
			),
		),
	);
}
