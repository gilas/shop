<?php
$this->Html->addCrumb('مدیریت پرداخت ها');
// Add
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-plus icon-white')),array('action' => 'add','menu_type_id' => @$this->request->named['menu_type_id'],'normalLink' => true ),array('class' => 'btn btn-success','escape' => false, 'rel' => 'tooltip','data-original-title' => 'افزودن','tooltip-place' => 'bottom'));
// Delete
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-trash icon-white')),array('action' => 'delete','confirm' => 'آیا مطمئن هستید ؟'),array('class' => 'btn btn-danger','escape' => false, 'rel' => 'tooltip','data-original-title' => 'حذف','tooltip-place' => 'bottom'));
// Edit
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-pencil icon-white')),array('action' => 'edit','method' => 'get','firstChild' => true),array('class' => 'btn btn-info','escape' => false, 'rel' => 'tooltip','data-original-title' => 'ویرایش','tooltip-place' => 'bottom'));

$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-check icon-white')),'',array('class' => 'btn btn-info','escape' => false,'isParent' => 'publish', 'rel' => 'tooltip','data-original-title' => 'انتشار','tooltip-place' => 'top'));
    //Accept
    $this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-ok')). ' تایید پرداخت',array('action' => 'changeStatus', 'status' => 1),array('escape' => false, 'parent' => 'publish'));
    // Reject
    $this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-remove')).' عدم تایید پرداخت',array('action' => 'changeStatus', 'status' => -1),array('escape' => false, 'parent' => 'publish'));
 
// Settings
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-wrench icon-white')),array('action' => 'settings', 'layout' => 'iframe'),array('class' => 'btn btn-warning','escape' => false, 'rel' => 'tooltip','data-original-title' => 'تنظیمات','tooltip-place' => 'bottom'));
//Show toolbar
$this->AdminForm->showToolbar('مدیریت پرداخت ها');

//Filtering
// we use action in options for rewriting action attr without querystring
echo $this->Filter->create('Menu',array('action' => 'index'));
echo $this->Filter->input('title',array('label' => 'عنوان'));
echo $this->Filter->input('published',array(
    'label' => 'وضعیت',
    'options' => array('' => '','0' => 'منتشر نشده', '1' => 'منتشر شده'))
);
echo $this->Filter->end();
if (!empty($payments)){
    // start form tag
    echo $this->AdminForm->startFormTag();
    //start table tag
    echo $this->Html->tag('table',null,array('class' => 'table table-bordered table-striped'));
    // th tag
    echo $this->Html->tableHeaders(array(
            $this->AdminForm->selectAll(),
            'ردیف',
            $this->Paginator->sort('Person.id','پرداخت کننده'),
            $this->Paginator->sort('Payment.price','مبلغ'),
            $this->Paginator->sort('Payment.type','نحوه پرداخت'),
            $this->Paginator->sort('Payment.ref_num','شناسه پرداخت'),
            $this->Paginator->sort('Payment.status','وضعیت'),
            $this->Paginator->sort('Payment.pay_date','تاریخ پرداخت'),
            array('عملیات' => array('class' => 'ordering-col' )),
        )
    );
    //current index
    $index = $this->Filter->paginParams['limit'] * ($this->Filter->paginParams['page'] - 1);
    
    foreach ($payments as $payment){
        
        // start TR tag
        echo $this->Html->tag('tr');
        // checkbox
        echo $this->Html->tag('td',$this->AdminForm->checkbox($payment['Payment']['id']),array('id' => 'grid-align'));
        // row count
        echo $this->Html->tag('td',++$index,array('id' => 'grid-align'));
        echo $this->Html->tag('td',$this->Html->link(h($payment['User']['name']), array('controller' => 'users', 'action' => 'view', $payment['Payment']['user_id'])));
        echo $this->Html->tag('td', $this->Html->price($payment['Payment']['price']));
        echo $this->Html->tag('td', $payment['Payment']['type']);
        echo $this->Html->tag('td', $payment['Payment']['ref_num']);
        echo $this->Html->tag('td', $payment['Payment']['formattedStatus']);
        echo $this->Html->tag('td', $payment['Payment']['pay_date']);
        
        $typeStatus = null;
        if (! $payment['Payment']['status']) {
            // Accept
            $typeStatus = $this->AdminForm->item(
                $this->Html->image('tick.png', array('title' => 'تایید پرداخت', 'alt' => 'تایید پرداخت')),//title
                array('action' => 'changeStatus', 'status' => 1),// url
                array('escape' => false, 'class' => 'btn btn-small','style' => 'float:left',)//option
            );
            // Reject
            $typeStatus .= $this->AdminForm->item(
                $this->Html->image('publish_x.png', array('title' => 'عدم تایید پرداخت', 'alt' => 'عدم تایید پرداخت')),
                array('action' => 'changeStatus', 'status' => -1),
                array('escape' => false, 'class' => 'btn btn-small','style' => 'float:right',)//option
            );
        }
        echo $this->Html->tag('td',$typeStatus,array('id' => 'grid-align'));
        
        // end TR tag
        echo $this->Html->useTag('tagend','tr');
        
    }//end foreach Ln 82
    echo $this->Html->useTag('tagend','table');//end table tag
    echo $this->AdminForm->endFormTag();// end form tag
}//end if Ln 56
echo $this->Filter->limitAndPaginate();// limitation and pagination
?>