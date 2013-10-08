<?php
// Add
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-plus icon-white')),array('action' => 'add','category_id' => @$this->request->named['category_id'],'normalLink' => true ),array('class' => 'btn btn-success','escape' => false, 'rel' => 'tooltip','data-original-title' => 'افزودن','tooltip-place' => 'bottom'));
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
$this->AdminForm->showToolbar('لیست تصاویر گالری');

//Filtering
// we use action in options for rewriting action attr without querystring
echo $this->Filter->create('GalleryItem',array('action' => 'index'));
echo $this->Filter->input('title',array('label' => 'عنوان'));
echo $this->Filter->input('published',array(
    'label' => 'وضعیت',
    'options' => array('' => '','0' => 'منتشر نشده', '1' => 'منتشر شده'))
);
echo $this->Filter->input('category_id',array(
    'label' => 'گالری',
    'options' => $galleryCategories,
    'empty' => ''
    )
);
echo $this->Filter->end();

if (!empty($galleryItems)) {
    echo $this->AdminForm->startFormTag();
    ?>
    <table class="table table-bordered table-striped">

        <tr>
            <th><?php echo $this->AdminForm->selectAll() ?></th>
            <th>ردیف</th>
            <th>بندانگشتی</th>
            <th>عنوان</th>
            <th>گالری</th>
            <th>آپلود کننده</th>
            <th>منتشر شده</th>
            <th class="ordering-col">ترتیب</th>
        </tr>
        <?php
        //current index
        $index = $this->Filter->paginParams['limit'] * ($this->Filter->paginParams['page'] - 1);
        foreach ($galleryItems as $galleryItem) :
            ?>
            <tr>
                <td id="grid-align"><?php echo  $this->AdminForm->checkbox($galleryItem['GalleryItem']['id']); ?></td>
                <td><?php echo ++$index; ?></td>
                <td><?php echo $this->Upload->image($galleryItem, 'GalleryItem.image', array('style' => 'thumb')); ?></td>
                <td><?php echo $this->Html->link($galleryItem['GalleryItem']['title'],array('action' => 'edit', $galleryItem['GalleryItem']['id'])) ?></td>
                <td><?php echo $this->Html->link($galleryItem['GalleryCategory']['name'],array('controller' => 'GalleryCategories', 'action' => 'edit', $galleryItem['GalleryCategory']['id'])) ?></td>
                <td><?php echo $galleryItem['User']['name']; ?></td>
                <td>
                <?php
                if ($galleryItem['GalleryItem']['published']) {
                    // Published
                    echo $this->AdminForm->item(
                        $this->Html->image('tick.png'),//title
                        array('action' => 'unPublish'),// url
                        array('escape' => false, 'class' => 'btn active btn-small')//option
                    );
                } else {
                    // Non Published
                    echo $this->AdminForm->item(
                        $this->Html->image('publish_x.png'),
                        array('action' => 'publish'),
                        array('escape' => false, 'class' => 'btn btn-small')//option
                    );
                }
                ?>
                </td>
                <td>
                <?php
                // order up
                if(!empty($galleryItem['GalleryItem']['hasLeft'])){
                   echo $this->AdminForm->item(
                        $this->Html->tag('i','',array('class' => 'icon-arrow-up icon-white')),
                        array('action' => 'move','type' => 'Up'),
                        array('class' => 'btn btn-info','style' => 'float:right','escape' => false)
                    );
                } 
                
                // order down
                if(!empty($galleryItem['GalleryItem']['hasRight'])){ 
                    echo $this->AdminForm->item(
                        $this->Html->tag('i','',array('class' => 'icon-arrow-down icon-white')),
                        array('action' => 'move','type' => 'Down'),
                        array('class' => 'btn btn-info','style' => 'float:left','escape' => false)
                    );
                }
                ?>
                </td>
            </tr>
            <?php
        endforeach;
        ?>
    </table>
    <?php 
    echo $this->AdminForm->endFormTag();// end form tag
}
?>
<?php echo $this->Filter->limitAndPaginate(); ?>