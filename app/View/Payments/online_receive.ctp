<?php

// Session is deleted automatically
if(empty($ref_url)){
    $ref_url = '/';
}
if(! isset($verify)){
    echo $this->Html->tag('h4','خطا در دریافت اطلاعات');
    echo $this->Html->link('بازگشت',$ref_url);
    return;
}
if($verify == false){
    echo $this->Html->tag('h4',$msg);
    echo $this->Html->tag('h4','خطا : '. $error);
    echo $this->Html->link('بازگشت',$ref_url);
}else{
    echo $this->Html->tag('h4',$msg);
    echo $this->Html->link('ادامه فرایند سفارش',$ref_url, array('class' => 'btn btn-success'));
}
?>