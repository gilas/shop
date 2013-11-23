<?php

class ShopUser extends ShopAppModel {
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
        ), 
        'Group' => array(
            'className' => 'Shop.Group',
            'foreignKey' => 'group_id',
        ),
    );
    
    public $namedType = array(
        1 => 'فروشنده',
        2 => 'خریدار',
    );
    
    public function afterFind($results){
        if(empty($results)){
            return $results;
        }
        if($this->findQueryType != 'count' and $this->findQueryType != 'list'){
            foreach($results as &$result){
                //TODO: Unknown error , how to get type of find (all, first, count, ...) 
                if(!empty($result['ShopUser']) and is_array($result['ShopUser'])){
                    $result['ShopUser']['namedType'] =  @$this->namedType[$result['ShopUser']['type']];
                }
            }
        }
        return $results;
    }
}
