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
    
    public $namedStatus = array(
        -1 => 'لغو شده',
         0 => 'پرداخت نشده',
         1 => 'پرداخت شده ولی ارسال نشده',
         2 => 'ارسال شده',
         3 => 'خاتمه',
    );
    
    public $formattedStatus = array(
        -1 => '<label class="label label-danger">لغو شده</label>',
         0 => '<label class="label label-info">پرداخت نشده</label>',
         1 => '<label class="label label-inverse">پرداخت شده ولی ارسال نشده</label>',
         2 => '<label class="label label-success">ارسال شده</label>',
         3 => '<label class="label">خاتمه</label>',
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
                    $result['FactorHead']['namedStatus'] =  @$this->namedStatus[$result['FactorHead']['status']];
                    $result['FactorHead']['formattedStatus'] =  @$this->formattedStatus[$result['FactorHead']['status']];
                }
            }
        }
        return $results;
    }
}
