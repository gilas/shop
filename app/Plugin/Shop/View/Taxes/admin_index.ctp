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
echo $this->Filter->create('Tax',array('action' => 'index'));
echo $this->Filter->input('name',array('label' => 'عنوان'));
echo $this->Filter->end();

if (!empty($taxes)){
    // start form tag
    echo $this->AdminForm->startFormTag();
    //start table tag
    echo $this->Html->tag('table',null,array('class' => 'table table-bordered table-striped'));
    // th tag
    echo $this->Html->tableHeaders(array(
            array($this->AdminForm->selectAll() => array('class' => 'checkbox-column')),
            array('ردیف' => array('class' => 'row-column')),
            array('عنوان' => array('style' => 'width:180px')),
            array('درصد مالیات' => array('style' => 'width:160px')),
        )
    );
    //current index
    $index = $this->Filter->paginParams['limit'] * ($this->Filter->paginParams['page'] - 1);
    foreach ($taxes as $tax){
        echo $this->Html->tag('tr');
            echo $this->Html->tag('td',$this->AdminForm->checkbox($tax['Tax']['id']),array('id' => 'grid-align'));
            echo $this->Html->tag('td',++$index,array('id' => 'grid-align'));
            echo $this->Html->tag('td', $this->Html->link($tax['Tax']['name'],array('action' => 'edit', $tax['Tax']['id'])));
            echo $this->Html->tag('td', $tax['Tax']['percent'] . ' %');
        echo $this->Html->useTag('tagend','tr');
        
    }//end foreach Ln 82
    echo $this->Html->useTag('tagend','table');//end table tag
    echo $this->AdminForm->endFormTag();// end form tag
}//end if Ln 56
echo $this->Filter->limitAndPaginate();// limitation and pagination
?>