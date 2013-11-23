<?php
/**
 * Gallery Model
 *
 */
class Gallery extends ShopAppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'desc';
    
    public $actsAs = array(
        'UploadPack.Upload' => array(
            'image' => array(
                'styles' => array(
                    'thumb' => '180x120'
                ),
                'path' => ':webroot/img/Shop/Gallery/:id-:basename-:style.:extension'
            )
        )
    );

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'stuff_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'انتخاب کالا الزامی است',
			),
		),
	);
    
    public $belongsTo = array(
        'Stuff' => array(
            'className'    => 'Shop.Stuff',
            'foreignKey'   => 'stuff_id',
        ),
    );
    
}
