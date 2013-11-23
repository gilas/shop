<?php
/**
 * Category Model
 *
 */
class Category extends ShopAppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
    
    public $actsAs = array(
        'UploadPack.Upload' => array(
            'thumbnail' => array(
                'styles' => array(
                    'thumb' => '180x120'
                ),
                'path' => ':webroot/img/Shop/Category/:id-:basename-:style.:extension'
            )
        ),
        'Tree'
    );

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'ورود عنوان مجموعه الزامی است',
			),
		),
	);
}
