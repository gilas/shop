<?php
// Add
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-plus icon-white')),array('action' => 'add','menu_type_id' => @$this->request->named['menu_type_id'],'normalLink' => true ),array('class' => 'btn btn-success','escape' => false, 'rel' => 'tooltip','data-original-title' => 'افزودن','tooltip-place' => 'bottom'));
// Delete
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-trash icon-white')),array('action' => 'delete','confirm' => 'آیا مطمئن هستید ؟'),array('class' => 'btn btn-danger','escape' => false, 'rel' => 'tooltip','data-original-title' => 'حذف','tooltip-place' => 'bottom'));
// Edit
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-pencil icon-white')),array('action' => 'edit','method' => 'get','firstChild' => true),array('class' => 'btn btn-info','escape' => false, 'rel' => 'tooltip','data-original-title' => 'ویرایش','tooltip-place' => 'bottom'));

// Order Top and Down
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-retweet icon-white')),'',array('class' => 'btn btn-info','escape' => false,'isParent' => 'order', 'rel' => 'tooltip','data-original-title' => 'اولویت بندی','tooltip-place' => 'top'));
    // Order Up
    $this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-arrow-up')). ' حرکت به بالا',array('action' => 'move','type' => 'Up'),array('escape' => false,'parent' => 'order'));
    //Order Down
    $this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-arrow-down')). ' حرکت به پایین',array('action' => 'move','type' => 'Down'),array('escape' => false,'parent' => 'order'));

$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-check icon-white')),'',array('class' => 'btn btn-info','escape' => false,'isParent' => 'publish', 'rel' => 'tooltip','data-original-title' => 'انتشار','tooltip-place' => 'top'));
    // Publish
    $this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-ok')). ' انتشار',array('action' => 'publish'),array('escape' => false, 'parent' => 'publish'));
    // unPublish
    $this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-remove')).' عدم انتشار',array('action' => 'unPublish'),array('escape' => false, 'parent' => 'publish'));
    
//Show toolbar
$this->AdminForm->showToolbar('لیست منو ها');

//Filtering
// we use action in options for rewriting action attr without querystring
echo $this->Filter->create('Menu',array('action' => 'index'));
echo $this->Filter->input('title',array('label' => 'عنوان'));
echo $this->Filter->input('published',array(
    'label' => 'وضعیت',
    'options' => array('' => '','0' => 'منتشر نشده', '1' => 'منتشر شده'))
);
echo $this->Filter->input('menu_type_id',array(
    'label' => 'موقعیت منو',
    'options' => $menuTypes,
    'empty' => ''
    )
);
echo $this->Filter->end();

if (!empty($menus)){
    // start form tag
    echo $this->AdminForm->startFormTag();
    //start table tag
    echo $this->Html->tag('table',null,array('class' => 'table table-bordered table-striped'));
    // th tag
    echo $this->Html->tableHeaders(array(
            $this->AdminForm->selectAll(),
            'ردیف',
            'عنوان',
            'نشانی اینترنتی',
            'موقعیت',
            'نوع گزینه',
            'منتشر شده',
            array('ترتیب' => array('class' => 'ordering-col' )),
        )
    );
    //current index
    $index = $this->Filter->paginParams['limit'] * ($this->Filter->paginParams['page'] - 1);
    
    foreach ($menus as $menu){
        
        // start TR tag
        echo $this->Html->tag('tr');
        
        // checkbox
        echo $this->Html->tag('td',$this->AdminForm->checkbox($menu['Menu']['id']),array('id' => 'grid-align'));
        
        // row count
        echo $this->Html->tag('td',++$index,array('id' => 'grid-align'));
        
        // title with count level in begin
        $title = $this->Html->link($menu['Menu']['title'],array('action' => 'edit',$menu['Menu']['id']));
        for($i=0;$i<$menu['Menu']['level'] ; $i++){
            $title = $this->Html->tag('span','|&mdash;',array('class' => 'gi')) . $title;
        }
        echo $this->Html->tag('td',$title);
        
        // link with truncate if it is longer that 40 character
        echo $this->Html->tag('td',
            $this->Html->link(
                String::truncate($menu['Menu']['link'],40),$menu['Menu']['link'],array('target' => '_blank')
            ),
            array('class' => 'dir-left')
        );
        
        // menu type title
        echo $this->Html->tag('td',$this->Html->link($menu['MenuType']['title'],array('controller' =>'menuTypes', 'action' => 'edit', $menu['MenuType']['id'])));
        
        // link type title
        echo $this->Html->tag('td',$menu['LinkType']['name']);
        
        // published or non published
        $typePublish = null;
        if ($menu['Menu']['published']) {
            // Published
            $typePublish = $this->AdminForm->item(
                $this->Html->image('tick.png'),//title
                array('action' => 'unPublish'),// url
                array('escape' => false, 'class' => 'btn active btn-small')//option
            );
        } else {
            // Non Published
            $typePublish = $this->AdminForm->item(
                $this->Html->image('publish_x.png'),
                array('action' => 'publish'),
                array('escape' => false, 'class' => 'btn btn-small')//option
            );
        }
        echo $this->Html->tag('td',$typePublish,array('id' => 'grid-align'));
        
        // Ordering
        $ordering = null;
        
        // order up
        if(!empty($menu['Menu']['hasLeft'])){
           $ordering .= $this->AdminForm->item(
                $this->Html->tag('i','',array('class' => 'icon-arrow-up icon-white')),
                array('action' => 'move','type' => 'Up'),
                array('class' => 'btn btn-info','style' => 'float:right','escape' => false)
            );
        } 
        
        // order down
        if(!empty($menu['Menu']['hasRight'])){ 
            $ordering .= $this->AdminForm->item(
                $this->Html->tag('i','',array('class' => 'icon-arrow-down icon-white')),
                array('action' => 'move','type' => 'Down'),
                array('class' => 'btn btn-info','style' => 'float:left','escape' => false)
            );
        }
        echo $this->Html->tag('td',$ordering);
        
        // end TR tag
        echo $this->Html->useTag('tagend','tr');
        
    }//end foreach Ln 82
    echo $this->Html->useTag('tagend','table');//end table tag
    echo $this->AdminForm->endFormTag();// end form tag
}//end if Ln 56
echo $this->Filter->limitAndPaginate();// limitation and pagination
?>