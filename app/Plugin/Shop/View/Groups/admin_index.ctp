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
echo $this->Filter->create('Group',array('action' => 'index'));
echo $this->Filter->input('name',array('label' => 'عنوان'));
echo $this->Filter->end();

if (!empty($groups)){
    // start form tag
    echo $this->AdminForm->startFormTag();
    //start table tag
    echo $this->Html->tag('table',null,array('class' => 'table table-bordered table-striped'));
    // th tag
    echo $this->Html->tableHeaders(array(
            array($this->AdminForm->selectAll() => array('class' => 'checkbox-column')),
            array('ردیف' => array('class' => 'row-column')),
            'عنوان',
            array('درصد تخفیف' => array('style' => 'width:100px')),
            array('کاربران' => array('style' => 'width:100px')),
            array('تاریخ ایجاد' => array('style' => 'width:100px')),
        )
    );
    //current index
    $index = $this->Filter->paginParams['limit'] * ($this->Filter->paginParams['page'] - 1);
    foreach ($groups as $group){
        echo $this->Html->tag('tr');
            echo $this->Html->tag('td',$this->AdminForm->checkbox($group['Group']['id']),array('id' => 'grid-align'));
            echo $this->Html->tag('td',++$index,array('id' => 'grid-align'));
            echo $this->Html->tag('td', $this->Html->link($group['Group']['name'],array('action' => 'edit', $group['Group']['id'])));
            echo $this->Html->tag('td', $this->Html->percent($group['Group']['discount']));
            echo $this->Html->tag('td', $this->Html->link($this->Html->tag('i','',array('class' => 'icon-user')),array('controller' => 'User','action' => 'index', 'group' => $group['Group']['id']), array('escape' => false, 'class' => 'btn')), array( 'id' => 'grid-align'));
            echo $this->Html->tag('td', Jalali::niceShort($group['Group']['created']));
        echo $this->Html->useTag('tagend','tr');
        
    }//end foreach Ln 82
    echo $this->Html->useTag('tagend','table');//end table tag
    echo $this->AdminForm->endFormTag();// end form tag
}//end if Ln 56
echo $this->Filter->limitAndPaginate();// limitation and pagination
?>