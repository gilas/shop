<?php

class Payment extends AppModel{
    public $status = array(
        '-1' => 'تائید نشده',
        '0' => 'بررسی نشده',
        '1' => 'تائید شده',
    );
    public $formattedStatus = array(
        '-1' => '<label class="label label-important">تائید نشده</label>',
        '0' => '<label class="label label-warning">بررسی نشده</label>',
        '1' => '<label class="label label-success">تائید شده</label>',
    );
    public $belongsTo = array('User');
    public function afterFind($results){
        if(empty($results)){
            return $results;
        }
        if($this->findQueryType != 'count'){
            foreach($results as &$result){
                $result['Payment']['namedStatus'] = @$this->status[$result['Payment']['status']];
                $result['Payment']['formattedStatus'] = @$this->formattedStatus[$result['Payment']['status']];
            }
        }
        return $results;
    }
}