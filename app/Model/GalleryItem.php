<?php

App::uses('AppModel', 'Model');

/**
 * GalleryItem Model
 *
 * @property User $User
 * @property GalleryCategory $GalleryCategory
 */
class GalleryItem extends AppModel {

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
                    'thumb' => '180x120'
                ),
                'path' => ':webroot/img/imageGallery/:folder/:id-:basename-:style.:extension',
                'folder' => 'GalleryCategory.folder_name'
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
        'title' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'ورود عنوان تصویر الزامی است',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        )
        ,
        'gallery_category_id' => array(
            'notempty' => array(
                'rule' => 'notempty',
                'message' => 'لطفا یک مجموعه برای تصویر انتخاب نمایید'
            )
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
        ),
        'GalleryCategory' => array(
            'className' => 'GalleryCategory',
            'foreignKey' => 'gallery_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function isUniqueName($check) {
        $count = NULL;
        if (isset($this->data[$this->alias]['name'])) {
            $count = $this->find('count', array(
                'conditions' => array(
                    'gallery_category_id' => $this->data[$this->alias]['gallery_category_id'],
                    'GalleryItem.name' => $this->data[$this->alias]['name']
                )
                    )
            );
            if ($count)
                return FALSE;
            return TRUE;
        }
    }

}
