<?php

App::uses('AppModel', 'Model');

/**
 * User Model
 *
 * @property Content $Content
 * @property GalleryItem $GalleryItem
 */
class User extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'تکمیل این فیلد ضروری است',
			),
		),
		'username' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'تکمیل این فیلد ضروری است',
			),
            'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'این نام کاربری قبلا انتخاب شده است',
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'تکمیل این فیلد ضروری است',
                'on' => 'create',
			),//TODO: I comment it beacause we use shenasname for password and it can below 5 digit
//            'minLength' => array(
//                'rule'    => array('minLength', '6'),
//                'message' => 'حداقل 6 کاراکتر باید وارد شود',
//                'allowEmpty' => true,
//            ),
		),
        'email' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'تکمیل این فیلد ضروری است',
			),
            'email' => array(
				'rule' => array('email'),
				'message' => 'پست الکترونیک صحیح نمی باشد',
			),
		),
	);
    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Content' => array(
            'className' => 'Content',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'GalleryItem' => array(
            'className' => 'GalleryItem',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
    );
    
    public $belongsTo = array('Role');
    
    public function beforeSave() {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }
    
    public function bindNode($user) {
            return array('model' => 'Role', 'foreign_key' => $user['User']['role_id']);
    }

}
