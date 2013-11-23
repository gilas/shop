<?php

class FactorHead extends ShopAppModel {
    
    /**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'ورود فروشنده یا خریدار الزامی است',
			),
		),
        'date' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'ورود تاریخ سفارش الزامی است',
			),
		),
        'number' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'ورود شماره سفارش الزامی است',
			),
		),
        'total_price' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => '',
			),
		),
        'final_price' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => '',
			),
		),
	);
    
     public $belongsTo = array(
        'ShopUser' => array(
            'className' => 'Shop.ShopUser',
            'foreignKey' => 'user_id',
        ),
        'Tax' => array(
            'className' => 'Shop.Tax',
            'foreignKey' => 'tax_id',
        ),
        'Coupon' => array(
            'className' => 'Shop.Coupon',
            'foreignKey' => 'coupon_id',
        ),
        'Deport' => array(
            'className' => 'Shop.Deport',
            'foreignKey' => 'deport_id',
        ),
    );
    
    public $hasMany = array(
        'Items' => array(
            'className' => 'Shop.FactorItem',
            'foreignKey' => 'head_id',
        ),
    );
    
    public $namedType = array(
        1 => 'خرید',
        2 => 'فروش',
    );
    
    public function afterFind($results){
        if(empty($results)){
            return $results;
        }
        if($this->findQueryType != 'count' and $this->findQueryType != 'list'){
            foreach($results as &$result){
                //TODO: Unknown error , how to get type of find (all, first, count, ...) 
                if(!empty($result['FactorHead']) and is_array($result['FactorHead'])){
                    $result['FactorHead']['namedType'] =  @$this->namedType[$result['FactorHead']['type']];
                }
            }
        }
        return $results;
    }
}
