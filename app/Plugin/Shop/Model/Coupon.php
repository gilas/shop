<?php

class Coupon extends ShopAppModel {
    
    public $belongsTo = array(
        'FactorHead' => array(
            'className'     => 'Shop.FactorHead',
            'foreignKey'    => 'factor_id',
        ),
    );
    public $namedType = array(
        1 => 'یکبار مصرف',
        2 => 'چندبار مصرف',
    );
    
    public $namedDiscountType = array(
        1 => 'درصدی',
        2 => 'ارزشی',
    );
    
    
    public function afterFind($results){
        if(empty($results)){
            return $results;
        }
        if($this->findQueryType != 'count' and $this->findQueryType != 'list'){
            foreach($results as &$result){
                //TODO: Unknown error , how to get type of find (all, first, count, ...) 
                if(!empty($result['Coupon']) and is_array($result['Coupon'])){
                    $result['Coupon']['namedType'] =  @$this->namedType[$result['Coupon']['type']];
                    $result['Coupon']['namedDiscountType'] =  @$this->namedDiscountType[$result['Coupon']['discount_type']];
                    if($result['Coupon']['is_used'] == 0){
                        $result['Coupon']['formattedStatus'] = '<span class="label label-success">بلا استفاده</span>'; 
                    }else{
                        $result['Coupon']['formattedStatus'] = '<span class="label label-danger">استفاده شده</span>';
                    }
                }
            }
        }
        return $results;
    }
}
