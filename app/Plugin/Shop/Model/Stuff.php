<?php
/**
 * Stuff Model
 *
 */
class Stuff extends ShopAppModel {

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
                'path' => ':webroot/img/Shop/Stuff/:id-:basename-:style.:extension'
            ),
            'download_file' => array(
                'styles' => array(
                    'thumb' => '180x120'
                ),
                'path' => ':webroot/img/Shop/Stuff/download/:id-:basename-:style.:extension'
            ),
            'attachments' => array(
                'styles' => array(
                    'thumb' => '180x120'
                ),
                'path' => ':webroot/img/Shop/Stuff/attachments/:id-:basename-:style.:extension'
            ),
        )
    );

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'code' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'ورود کد کالا الزامی است',
			),
            'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'کد کالا تکراری می باشد',
			),
		),
        'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'ورود نام کالا الزامی است',
			),
		),
        'category_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'انتخاب مجموعه کالا الزامی است',
			),
		),
        'count' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'ورود تعداد کالا الزامی است',
			),
		),
        'price' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'ورود قیمت کالا الزامی است',
			),
		),
	);
    
    public $belongsTo = array(
        'Category' => array(
            'className'    => 'Shop.Category',
            'foreignKey'   => 'category_id',
        ),
        'Deport' => array(
            'className'    => 'Shop.Deport',
            'foreignKey'   => 'deport_id',
        ),
        'Tax' => array(
            'className'    => 'Shop.Tax',
            'foreignKey'   => 'tax_id',
        ),
    );
    
    public $hasMany = array(
        'Gallery' => array(
            'className'     => 'Shop.Gallery',
            'foreignKey'    => 'stuff_id',
        )
    );
    
    public $namedType = array(
        1 => 'حقیقی',
        2 => 'مجازی',
    );
    
    public $namedOrder = array(
        1 => 'مستقیم',
        2 => 'پس از تائید مدیریت',
    );
    
    public function afterFind($results){
        if(empty($results)){
            return $results;
        }
        if($this->findQueryType != 'count' and $this->findQueryType != 'list'){
            foreach($results as &$result){
                //TODO: Unknown error , how to get type of find (all, first, count, ...) 
                if(!empty($result['Stuff']) and is_array($result['Stuff'])){
                    $result['Stuff']['namedType'] =  @$this->namedType[$result['Stuff']['type']];
                    $result['Stuff']['namedOrder'] =  @$this->namedOrder[$result['Stuff']['order']];
                    if(!empty($result['Stuff']['discount'])){
                        $result['Stuff']['PriceWithDiscount'] = $result['Stuff']['price'] - ($result['Stuff']['price'] * $result['Stuff']['discount'] / 100);
                    }
                }
            }
        }
        return $results;
    }
}
