<?php
App::uses('AppModel', 'Model');
/**
 * ContentCategory Model
 *
 * @property ContentCategory $ParentContentCategory
 * @property ContentCategory $ChildContentCategory
 * @property Content $Content
 */
class ContentCategory extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
        public $actsAs = array('Tree');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'ورود نام مجموعه الزامی است',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Content' => array(
			'className' => 'Content',
			'foreignKey' => 'content_category_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
    
    public $namedAccess = array(
        0 => 'عمومی',
        1 => 'نمایش در صفحه شخصی اعضا',
    );

}
