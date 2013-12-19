<?php
$this->Html->addCrumb($title);

// Add
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-plus icon-white')),array('action' => 'add', 'normalLink' => true ),array('class' => 'btn btn-success','escape' => false, 'rel' => 'tooltip','data-original-title' => 'افزودن','tooltip-place' => 'top'));
// Delete
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-trash icon-white')),array('action' => 'delete','confirm' => 'آیا مطمئن هستید ؟'),array('class' => 'btn btn-danger','escape' => false, 'rel' => 'tooltip','data-original-title' => 'حذف','tooltip-place' => 'top'));
// Edit
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-pencil icon-white')),array('action' => 'edit','method' => 'get','firstChild' => true),array('class' => 'btn btn-info','escape' => false, 'rel' => 'tooltip','data-original-title' => 'ویرایش','tooltip-place' => 'top'));
  
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-check icon-white')),'',array('class' => 'btn btn-info','escape' => false,'isParent' => 'publish', 'rel' => 'tooltip','data-original-title' => 'انتشار','tooltip-place' => 'top'));
    // Publish
    $this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-ok')). ' فعال',array('action' => 'active'),array('escape' => false, 'parent' => 'publish'));
    // unPublish
    $this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-remove')).' غیرفعال',array('action' => 'inactive'),array('escape' => false, 'parent' => 'publish'));
//Show toolbar
$this->AdminForm->showToolbar($title);

//Filtering
// we use action in options for rewriting action attr without querystring
echo $this->Filter->create('ShopUser',array('action' => 'index'));
echo $this->Filter->input('name',array('label' => 'نام مشتری'));
echo $this->Filter->input('type',array('label' => 'نوع مشتری', 'options' => $types, 'empty' => ''));
echo $this->Filter->input('group',array('label' => 'گروه مشتریان', 'options' => $groups, 'empty' => ''));
echo $this->Filter->end();

if (!empty($users)){
    // start form tag
    echo $this->AdminForm->startFormTag('User', array('manual' => true));
    //start table tag
    echo $this->Html->tag('table',null,array('class' => 'table table-bordered table-striped'));
    // th tag
    echo $this->Html->tableHeaders(array(
            array($this->AdminForm->selectAll() => array('class' => 'checkbox-column')),
            array('ردیف' => array('class' => 'row-column')),
            array('نام مشتری' => array('style' => 'width:160px')),
            array('نوع مشتری' => array('style' => 'width:160px')),
            array('نام کاربری' => array('style' => 'width:160px')),
            array('گروه مشتریان' => array('class' => 'width:160px')),
            array('فعال' => array('class' => 'published-column')),
            array('تاریخ ثبت نام' => array('class' => 'width:160px')),
            array('آخرین تاریخ ورود' => array('class' => 'width:160px')),
            array('جزئیات' => array('class' => 'width:160px')),
        )
    );
    //current index
    $index = $this->Filter->paginParams['limit'] * ($this->Filter->paginParams['page'] - 1);
    
    foreach ($users as $user){
        
        // start TR tag
        echo $this->Html->tag('tr');
        
        // checkbox
        echo $this->Html->tag('td',$this->AdminForm->checkbox($user['ShopUser']['id']),array('id' => 'grid-align'));
        
        // row count
        echo $this->Html->tag('td',++$index,array('id' => 'grid-align'));
        
        $link = $this->Html->link($user['User']['name'],array('action' => 'edit',$user['ShopUser']['id']));
        if(!empty($this->request->named['layout'])){
            $link = sprintf(
                    '<a onclick=\'window.parent.chooseUser(%s, %s)\'>%s</a>',
                    $this->request->named['row'], 
                    json_encode(array(
                            'id' => $user['ShopUser']['id'], 
                            'name' => $user['User']['name'],
                        )
                    ),
                    $user['User']['name']
            );
        }
   
        echo $this->Html->tag('td', $link);
        
        echo $this->Html->tag('td', $user['ShopUser']['namedType']);

        echo $this->Html->tag('td', $this->Html->link($user['User']['username'],array( 'controller' => 'Users','action' => 'index', 'username' => $user['User']['username'], 'plugin' => false)));
        
        echo $this->Html->tag('td', $this->Html->link($user['Group']['name'],array('action' => 'index','group' => $user['Group']['id'])));
        
        $published = '';
        if ($user['User']['active']) {
            // Published
            $published = $this->AdminForm->item(
                $this->Html->image('tick.png'),//title
                array('action' => 'inactive'),// url
                array('escape' => false, 'class' => 'btn active btn-small')//option
            );
        } else {
            // Non Published
            $published = $this->AdminForm->item(
                $this->Html->image('publish_x.png'),
                array('action' => 'active'),
                array('escape' => false, 'class' => 'btn btn-small')
            );
        }
        echo $this->Html->tag('td', $published, array('id' => 'grid-align') );  
        
        echo $this->Html->tag('td', Jalali::niceShort($user['User']['registered_date']));
        
        echo $this->Html->tag('td', Jalali::niceShort($user['User']['last_logged_in']));
        
        echo $this->Html->tag('td', $this->AdminForm->_createIframe($this->Html->tag('i','',array('class' => 'icon-file')), array('action' => 'details', $user['ShopUser']['id'], 'layout' => 'iframe'), array('escape' => false, 'class' => 'btn btn-warning')), array('id' => 'grid-align'));    
                
        // end TR tag
        echo $this->Html->useTag('tagend','tr');
        
    }//end foreach Ln 82
    echo $this->Html->useTag('tagend','table');//end table tag
    echo $this->AdminForm->endFormTag();// end form tag
}//end if Ln 56
echo $this->Filter->limitAndPaginate();// limitation and pagination
?>