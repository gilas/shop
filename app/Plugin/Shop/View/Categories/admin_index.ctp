<?php
$this->Html->addCrumb($title);

// Add
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-plus icon-white')),array('action' => 'add', 'normalLink' => true ),array('class' => 'btn btn-success','escape' => false, 'rel' => 'tooltip','data-original-title' => 'افزودن','tooltip-place' => 'top'));
// Delete
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-trash icon-white')),array('action' => 'delete','confirm' => 'آیا مطمئن هستید ؟'),array('class' => 'btn btn-danger','escape' => false, 'rel' => 'tooltip','data-original-title' => 'حذف','tooltip-place' => 'top'));
// Edit
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-pencil icon-white')),array('action' => 'edit','method' => 'get','firstChild' => true),array('class' => 'btn btn-info','escape' => false, 'rel' => 'tooltip','data-original-title' => 'ویرایش','tooltip-place' => 'top'));

// Order Top and Down
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-retweet icon-white')),'',array('class' => 'btn btn-info','escape' => false,'isParent' => 'order', 'rel' => 'tooltip','data-original-title' => 'اولویت بندی','tooltip-place' => 'top'));
    //Order Down but show arraw up, because we fetch content DESC from table
    $this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-arrow-up')). ' حرکت به بالا',array('action' => 'move','type' => 'Up'),array('escape' => false,'parent' => 'order'));
    //Order Up but show arraw down, because we fetch content DESC from table
    $this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-arrow-down')). ' حرکت به پایین',array('action' => 'move','type' => 'Down'),array('escape' => false,'parent' => 'order'));
    
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-check icon-white')),'',array('class' => 'btn btn-info','escape' => false,'isParent' => 'publish', 'rel' => 'tooltip','data-original-title' => 'انتشار','tooltip-place' => 'top'));
    // Publish
    $this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-ok')). ' انتشار',array('action' => 'publish'),array('escape' => false, 'parent' => 'publish'));
    // unPublish
    $this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-remove')).' عدم انتشار',array('action' => 'unPublish'),array('escape' => false, 'parent' => 'publish'));
//Show toolbar
$this->AdminForm->showToolbar($title);

//Filtering
// we use action in options for rewriting action attr without querystring
echo $this->Filter->create('Category',array('action' => 'index'));
echo $this->Filter->input('name',array('label' => 'عنوان'));
echo $this->Filter->end();

if (!empty($categories)){
    // start form tag
    echo $this->AdminForm->startFormTag();
    //start table tag
    echo $this->Html->tag('table',null,array('class' => 'table table-bordered table-striped'));
    // th tag
    echo $this->Html->tableHeaders(array(
            array($this->AdminForm->selectAll() => array('class' => 'checkbox-column')),
            array('ردیف' => array('class' => 'row-column')),
            array('عنوان' => array('style' => 'width:180px')),
            array('منتشر شده' => array('class' => 'published-column')),
            array('کالا' => array('style' => 'width:21px')),
            array('تصویر' => array('style' => 'width:180px')),
            array('ترتیب' => array('class' => 'ordering-col')),
        )
    );
    //current index
    $index = $this->Filter->paginParams['limit'] * ($this->Filter->paginParams['page'] - 1);
    
    foreach ($categories as $category){
        
        // start TR tag
        echo $this->Html->tag('tr');
        
        // checkbox
        echo $this->Html->tag('td',$this->AdminForm->checkbox($category['Category']['id']),array('id' => 'grid-align'));
        
        // row count
        echo $this->Html->tag('td',++$index,array('id' => 'grid-align'));
        
        // name
        // name with count level in begin
        $name = $this->Html->link($category['Category']['name'],array('action' => 'edit',$category['Category']['id']));
        for($i=0;$i<$category['Category']['level'] ; $i++){
            $name = $this->Html->tag('span','|&mdash;',array('class' => 'gi')) . $name;
        }
            
        echo $this->Html->tag('td', $this->Html->link($name,array('action' => 'edit',$category['Category']['id']), array('escape' => false)));
        
        $published = '';
        if ($category['Category']['published']) {
            // Published
            $published = $this->AdminForm->item(
                $this->Html->image('tick.png'),//title
                array('action' => 'unPublish'),// url
                array('escape' => false, 'class' => 'btn active btn-small')//option
            );
        } else {
            // Non Published
            $published = $this->AdminForm->item(
                $this->Html->image('publish_x.png'),
                array('action' => 'publish'),
                array('escape' => false, 'class' => 'btn btn-small')
            );
        }
        echo $this->Html->tag('td', $published, array('id' => 'grid-align') );      
        echo $this->Html->tag('td', '' );
        echo $this->Html->tag('td', $this->Upload->image($category, 'Category.thumbnail', array('style' => 'thumb')));
        
        //Order Up but show arraw down, because we fetch content DESC from table
        $order = '';
        if(!empty($category['Category']['hasLeft'])){
           $order = $this->AdminForm->item(
                $this->Html->tag('i','',array('class' => 'icon-arrow-up icon-white')),
                array('action' => 'move','type' => 'Up'),
                array('class' => 'btn btn-info','style' => 'float:right','escape' => false)
            );
        } 
        
        //Order Down but show arraw up, because we fetch content DESC from table
        if(!empty($category['Category']['hasRight'])){ 
             $order = $this->AdminForm->item(
                $this->Html->tag('i','',array('class' => 'icon-arrow-down icon-white')),
                array('action' => 'move','type' => 'Down'),
                array('class' => 'btn btn-info','style' => 'float:left','escape' => false)
            );
        }
        echo $this->Html->tag('td', $order, array('id' => 'grid-align'));
                
        
        // end TR tag
        echo $this->Html->useTag('tagend','tr');
        
    }//end foreach Ln 82
    echo $this->Html->useTag('tagend','table');//end table tag
    echo $this->AdminForm->endFormTag();// end form tag
}//end if Ln 56
echo $this->Filter->limitAndPaginate();// limitation and pagination
?>