<?php
$this->Html->addCrumb('لیست فاکتور ها');
//Filtering
// we use action in options for rewriting action attr without querystring
echo $this->Filter->create('Order',array('action' => 'index'));
echo $this->Filter->input('number',array('label' => 'شماره سفارش'));
echo $this->Filter->input('status',array('label' => 'وضعیت سفارش', 'options' => $namedStatus, 'empty' => ''));
echo $this->Filter->end();

if (!empty($orders)){
    //start table tag
    echo $this->Html->tag('table',null,array('class' => 'table table-bordered table-striped'));
    // th tag
    echo $this->Html->tableHeaders(array(
            array('ردیف' => array('class' => 'row-column')),
            array('شماره سفارش' => array('style' => 'width:180px')),
            array('مبلغ' => array('style' => 'width:160px')),
            array('تاریخ سفارش' => array('class' => 'width:160px')),
            array('وضعیت' => array('class' => 'width:160px')),
        )
    );
    //current index
    $index = $this->Filter->paginParams['limit'] * ($this->Filter->paginParams['page'] - 1);
    foreach ($orders as $order){

        echo $this->Html->tag('tr');
            echo $this->Html->tag('td',++$index,array('id' => 'grid-align'));
            echo $this->Html->tag('td', $this->Html->link($order['FactorHead']['number'],array('action' => 'viewFactor',$order['FactorHead']['id'])));
            echo $this->Html->tag('td', $this->Html->price($order['FactorHead']['final_price']));
            echo $this->Html->tag('td', $order['FactorHead']['date']);
            echo $this->Html->tag('td', $order['FactorHead']['formattedStatus']);
        echo $this->Html->useTag('tagend','tr');
        
    }//end foreach Ln 82
    echo $this->Html->useTag('tagend','table');//end table tag
}//end if Ln 56
echo $this->Filter->limitAndPaginate();// limitation and pagination
?>