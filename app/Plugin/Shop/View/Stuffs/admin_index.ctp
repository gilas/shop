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
    $this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-ok')). ' انتشار',array('action' => 'publish'),array('escape' => false, 'parent' => 'publish'));
    // unPublish
    $this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-remove')).' عدم انتشار',array('action' => 'unPublish'),array('escape' => false, 'parent' => 'publish'));
//Show toolbar
$this->AdminForm->showToolbar($title);

//Filtering
// we use action in options for rewriting action attr without querystring
echo $this->Filter->create('Stuff',array('action' => 'index'));
echo $this->Filter->input('code',array('label' => 'کد کالا'));
echo $this->Filter->input('name',array('label' => 'نام کالا'));
echo $this->Filter->input('category',array('label' => 'مجموعه کالا', 'options' => $categories, 'empty' => ''));
echo $this->Filter->end();

if (!empty($stuffs)){
    // start form tag
    echo $this->AdminForm->startFormTag();
    //start table tag
    echo $this->Html->tag('table',null,array('class' => 'table table-bordered table-striped'));
    // th tag
    echo $this->Html->tableHeaders(array(
            array($this->AdminForm->selectAll() => array('class' => 'checkbox-column')),
            array('ردیف' => array('class' => 'row-column')),
            array('کد کالا' => array('style' => 'width:160px')),
            array('نام کالا' => array('style' => 'width:160px')),
            'مجموعه',
            array('منتشر شده' => array('class' => 'published-column')),
            array('تعداد موجود' => array('style' => 'width:160px')),
            'قیمت',
            array('تصویر' => array('style' => 'width:180px')),
        )
    );
    //current index
    $index = $this->Filter->paginParams['limit'] * ($this->Filter->paginParams['page'] - 1);
    
    foreach ($stuffs as $stuff){
        
        // start TR tag
        echo $this->Html->tag('tr');
        
        // checkbox
        echo $this->Html->tag('td',$this->AdminForm->checkbox($stuff['Stuff']['id']),array('id' => 'grid-align'));
        
        // row count
        echo $this->Html->tag('td',++$index,array('id' => 'grid-align'));
        
        // code     
        $link = $this->Html->link($stuff['Stuff']['code'],array('action' => 'edit',$stuff['Stuff']['id']));
        if(!empty($this->request->named['layout'])){
            $link = sprintf(
                    '<a onclick=\'window.parent.setItem(%s, %s)\'>%s</a>',
                    $this->request->named['row'], 
                    json_encode(array(
                            'code' => $stuff['Stuff']['code'], 
                            'name' => $stuff['Stuff']['name'],
                            'price' => $stuff['Stuff']['price'],
                        )
                    ),
                    $stuff['Stuff']['code']
            );
        }
        echo $this->Html->tag('td', $link);
        
        // name     
        echo $this->Html->tag('td', $stuff['Stuff']['name']);
        
        echo $this->Html->tag('td', $this->Html->link($stuff['Category']['name'],array('action' => 'index','category' => $stuff['Category']['id'])));
        
        $published = '';
        if ($stuff['Stuff']['published']) {
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
        
        echo $this->Html->tag('td', number_format($stuff['Stuff']['count']));
        
        echo $this->Html->tag('td', $this->Html->price($stuff['Stuff']['price']));
        
        $image = '';
        if(! empty($stuff['Stuff']['thumbnail_file_name'])){
            $image = $this->AdminForm->_createIframe(
                $this->Upload->image($stuff, 'Stuff.thumbnail', array('style' => 'thumb')), 
                $this->Upload->url($stuff, 'Stuff.thumbnail', array('urlize' => false)), 
                array('escape' => false)
            );
        }
        echo $this->Html->tag('td', $image);
                
        // end TR tag
        echo $this->Html->useTag('tagend','tr');
        
    }//end foreach Ln 82
    echo $this->Html->useTag('tagend','table');//end table tag
    echo $this->AdminForm->endFormTag();// end form tag
}//end if Ln 56
echo $this->Filter->limitAndPaginate();// limitation and pagination
?>