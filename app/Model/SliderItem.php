<?php
App::uses('AppModel', 'Model');
/**
 * SliderItem Model
 *
 */
class SliderItem extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
    
    var $actsAs = array(
        'UploadPack.Upload' => array(
            'image' => array(
                'styles' => array(
                    'thumb' => '100x80'
                ),
                'path' => ':webroot/img/slider/:id-:basename_:style.:extension'
            ),
        ),
        'Tree',
    );

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'link' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'تکمیل این فیلد اجباری است.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'تکمیل این فیلد اجباری است.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'تکمیل این فیلد اجباری است.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'image' => array(
            'notempty' => array(
                'rule' => array('attachmentPresence'),
                'message' => 'انتخاب تصویر الزامی است',
                'on' => 'create',
            ),
            'maxSize' => array(
                'rule' => array('attachmentMaxSize', 2096576),
                'message' => 'اندازه تصویر آپلودی نمی تواند بیشتر از 2 مگابایت باشد'
            ),
            'extension' => array(
                'rule' => array('attachmentContentType', array('image/jpeg', 'image/gif', 'image/png', 'image/pjpeg')),
                'message' => 'فقط مجاز به آپلود تصویر می باشید'
            )
        )
	);

    public $belongsTo = array(
    	'LinkType' => array(
    		'className' => 'LinkType',
    		'foreignKey' => 'link_type_id',
    		'conditions' => '',
    		'fields' => '',
    		'order' => ''
    	),
    );
}
