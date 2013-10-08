<?php

class Payment extends AppModel{
    public $status = array(
        '-1' => 'تائید نشده',
        '0' => 'بررسی نشده',
        '1' => 'تائید شده',
    );
    
    public $belongsTo = array('Person');
    
    public function afterFind($results){
        if(empty($results)){
            return $results;
        }
        if($this->findQueryType != 'count'){
            foreach($results as &$result){
                $result['Payment']['namedStatus'] = @$this->status[$result['Payment']['status']];
            }
        }
        return $results;
    }
}