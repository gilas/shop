<?php
$this->Html->addCrumb($title);

// Add
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-plus icon-white')),array('action' => 'add', 'normalLink' => true ),array('class' => 'btn btn-success','escape' => false, 'rel' => 'tooltip','data-original-title' => 'افزودن','tooltip-place' => 'top'));
// Delete
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-trash icon-white')),array('action' => 'delete','confirm' => 'آیا مطمئن هستید ؟'),array('class' => 'btn btn-danger','escape' => false, 'rel' => 'tooltip','data-original-title' => 'حذف','tooltip-place' => 'top'));
// Edit
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-pencil icon-white')),array('action' => 'edit','method' => 'get','firstChild' => true),array('class' => 'btn btn-info','escape' => false, 'rel' => 'tooltip','data-original-title' => 'ویرایش','tooltip-place' => 'top'));
//Show toolbar
$this->AdminForm->showToolbar($title);

//Filtering
// we use action in options for rewriting action attr without querystring
echo $this->Filter->create('Coupon',array('action' => 'index'));
echo $this->Filter->input('serial',array('label' => 'شماره سریال',));
echo $this->Filter->input('type',array(
    'label' => 'نوع کوپن',
    'options' => $namedType,
    'empty' => '',
    )
);
echo $this->Filter->input('type',array(
    'label' => 'نوع ارزش',
    'options' => $namedDiscountType,
    'empty' => '',
    )
);
echo $this->Filter->end();

if (!empty($coupons)){
    // start form tag
    echo $this->AdminForm->startFormTag();
    //start table tag
    echo $this->Html->tag('table',null,array('class' => 'table table-bordered table-striped'));
    // th tag
    echo $this->Html->tableHeaders(array(
            array($this->AdminForm->selectAll() => array('class' => 'checkbox-column')),
            array('ردیف' => array('class' => 'row-column')),
            array('شماره سریال' => array('style' => 'width:180px')),
            array('نوع' => array('style' => 'width:70px')),
            array('نوع ارزش' => array('style' => 'width:70px')),
            array('ارزش' => array('style' => 'width:160px')),
            array('تاریخ ایجاد' => array('style' => 'width:160px')),
            array('تاریخ استفاده' => array('style' => 'width:160px')),
            array('استفاده شده در' => array('style' => 'width:160px')),
            array('وضعیت' => array('style' => 'width:53px')),
        )
    );
    //current index
    $index = $this->Filter->paginParams['limit'] * ($this->Filter->paginParams['page'] - 1);
    foreach ($coupons as $coupon){
        echo $this->Html->tag('tr');
            echo $this->Html->tag('td',$this->AdminForm->checkbox($coupon['Coupon']['id']),array('id' => 'grid-align'));
            echo $this->Html->tag('td',++$index,array('id' => 'grid-align'));
            echo $this->Html->tag('td', $this->Html->link($coupon['Coupon']['serial'],array('action' => 'edit', $coupon['Coupon']['id'])));
            echo $this->Html->tag('td', $coupon['Coupon']['namedType']);
            echo $this->Html->tag('td', $coupon['Coupon']['namedDiscountType']);
            $value = $coupon['Coupon']['discount_value'] . ' درصد';
            if($coupon['Coupon']['discount_type'] == 2){
                $value = $this->Html->price($coupon['Coupon']['discount_value']);
            }
            echo $this->Html->tag('td', $value);
            echo $this->Html->tag('td', Jalali::niceShort($coupon['Coupon']['created']));
            echo $this->Html->tag('td', Jalali::niceShort($coupon['Coupon']['used_date']));
            $factorLink = null;
            if(!empty($coupon['Coupon']['factor_id'])){
                $factorLink = $this->Html->link('سفارش '.$coupon['FactorHead']['number'],array('controller' => 'Orders', 'action' => 'details', $coupon['Coupon']['factor_id'])) ;
            }
            echo $this->Html->tag('td', $factorLink);
            echo $this->Html->tag('td', $coupon['Coupon']['formattedStatus']);
        echo $this->Html->useTag('tagend','tr');
        
    }//end foreach Ln 82
    echo $this->Html->useTag('tagend','table');//end table tag
    echo $this->AdminForm->endFormTag();// end form tag
}//end if Ln 56
echo $this->Filter->limitAndPaginate();// limitation and pagination
?>