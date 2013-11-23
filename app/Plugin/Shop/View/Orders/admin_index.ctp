<?php
$this->Html->addCrumb($title);

// Add
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-plus icon-white')),array('action' => 'add', 'type' => $type, 'normalLink' => true ),array('class' => 'btn btn-success','escape' => false, 'rel' => 'tooltip','data-original-title' => 'افزودن','tooltip-place' => 'top'));
// Delete
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-trash icon-white')),array('action' => 'delete','confirm' => 'آیا مطمئن هستید ؟'),array('class' => 'btn btn-danger','escape' => false, 'rel' => 'tooltip','data-original-title' => 'حذف','tooltip-place' => 'top'));
// Edit
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-pencil icon-white')),array('action' => 'edit','method' => 'get','firstChild' => true),array('class' => 'btn btn-info','escape' => false, 'rel' => 'tooltip','data-original-title' => 'ویرایش','tooltip-place' => 'top'));
//Show toolbar
$this->AdminForm->showToolbar($title);

//Filtering
// we use action in options for rewriting action attr without querystring
echo $this->Filter->create('Order',array('action' => 'index'));
echo $this->Filter->input('number',array('label' => 'شماره سفارش'));
echo $this->Filter->input('type',array('label' => 'نوع سفارش', 'options' => $namedType, 'empty' => ''));
echo $this->Filter->end();

if (!empty($orders)){
    // start form tag
    echo $this->AdminForm->startFormTag();
    //start table tag
    echo $this->Html->tag('table',null,array('class' => 'table table-bordered table-striped'));
    // th tag
    echo $this->Html->tableHeaders(array(
            array($this->AdminForm->selectAll() => array('class' => 'checkbox-column')),
            array('ردیف' => array('class' => 'row-column')),
            array('شماره سفارش' => array('style' => 'width:180px')),
            array('نوع سفارش' => array('style' => 'width:160px')),
            array('نام خریدار/فروشنده' => array('style' => 'width:160px')),
            array('مبلغ' => array('style' => 'width:160px')),
            array('تاریخ سفارش' => array('class' => 'width:160px')),
            array('مشاهده فاکتور' => array('class' => 'width:160px')),
        )
    );
    //current index
    $index = $this->Filter->paginParams['limit'] * ($this->Filter->paginParams['page'] - 1);
    foreach ($orders as $order){

        echo $this->Html->tag('tr');
            echo $this->Html->tag('td',$this->AdminForm->checkbox($order['FactorHead']['id']),array('id' => 'grid-align'));
            echo $this->Html->tag('td',++$index,array('id' => 'grid-align'));
            echo $this->Html->tag('td', $this->Html->link($order['FactorHead']['number'],array('action' => 'edit',)));
            echo $this->Html->tag('td', $order['FactorHead']['namedType']);
            echo $this->Html->tag('td', $order['ShopUser']['User']['name']);
            echo $this->Html->tag('td', $this->Html->price($order['FactorHead']['final_price']));
            echo $this->Html->tag('td', $order['FactorHead']['date']);
            echo $this->Html->tag('td', $this->AdminForm->_createIframe($this->Html->tag('i','',array('class' => 'icon-file')), array('action' => 'detail', $order['FactorHead']['id'], 'layout' => 'iframe'), array('escape' => false, 'class' => 'btn btn-warning')), array('id' => 'grid-align'));
        echo $this->Html->useTag('tagend','tr');
        
    }//end foreach Ln 82
    echo $this->Html->useTag('tagend','table');//end table tag
    echo $this->AdminForm->endFormTag();// end form tag
}//end if Ln 56
echo $this->Filter->limitAndPaginate();// limitation and pagination
?>