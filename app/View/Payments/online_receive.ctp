<?php

// Session is deleted automatically
if(empty($ref_url)){
    $ref_url = '/';
}
if(! isset($verify)){
    echo $this->Html->tag('h1','خطا در دریافت اطلاعات');
    echo $this->Html->link('بازگشت',$ref_url);
    return;
}
if($verify == false){
    echo $this->Html->tag('h1',$msg);
    echo $this->Html->tag('h1','خطا : '. $error);
}else{
    echo $this->Html->tag('h1',$msg);
}
echo $this->Html->link('بازگشت',$ref_url);
?>