<?php
// Add
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-plus icon-white')),array('action' => 'add','normalLink' => true ),array('class' => 'btn btn-success','escape' => false, 'rel' => 'tooltip','data-original-title' => 'افزودن','tooltip-place' => 'bottom'));
// Delete
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-trash icon-white')),array('action' => 'delete','confirm' => 'آیا مطمئن هستید ؟'),array('class' => 'btn btn-danger','escape' => false, 'rel' => 'tooltip','data-original-title' => 'حذف','tooltip-place' => 'bottom'));
// Edit
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-pencil icon-white')),array('action' => 'edit','method' => 'get','firstChild' => true),array('class' => 'btn btn-info','escape' => false, 'rel' => 'tooltip','data-original-title' => 'ویرایش','tooltip-place' => 'bottom'));

$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-check icon-white')),'',array('class' => 'btn btn-info','escape' => false,'isParent' => 'publish', 'rel' => 'tooltip','data-original-title' => 'انتشار','tooltip-place' => 'top'));
    // Publish
    $this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-ok')). ' انتشار',array('action' => 'publish'),array('escape' => false, 'parent' => 'publish'));
    // unPublish
    $this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-remove')).' عدم انتشار',array('action' => 'unPublish'),array('escape' => false, 'parent' => 'publish'));
    
//Show toolbar
$this->AdminForm->showToolbar('لیست مجموعه ها');
if (!empty($galleryCategories)) {
    echo $this->AdminForm->startFormTag();
    ?>
    <table class="table table-bordered table-striped">

        <tr>
            <th><?php echo $this->AdminForm->selectAll() ?></th>
            <th>ردیف</th>
            <th>نام</th>
            <th>تعداد تصاویر</th>
            <th>منتشر شده</th>
        </tr>
        <?php
        //current index
        $index = $this->Filter->paginParams['limit'] * ($this->Filter->paginParams['page'] - 1);
        foreach ($galleryCategories as $galleryCategory):
            ?>
            <tr>
                <td id="grid-align"><?php echo  $this->AdminForm->checkbox($galleryCategory['GalleryCategory']['id']); ?></td>
                <td><?php echo ++$index; ?></td>
                <td><?php echo $this->Html->link($galleryCategory['GalleryCategory']['name'],array('action' => 'edit',$galleryCategory['GalleryCategory']['id'])); ?></td>
                <td id="grid-align">
                <?php 
                echo $this->Html->link(
                    $galleryCategory['GalleryCategory']['imageCount'], 
                    array('controller' => 'galleryItems', 'action' => 'index', 'category_id' => $galleryCategory['GalleryCategory']['id']), 
                    array('class' => 'btn')
                ); 
                ?>
                </td>
                <td id="grid-align">
                <?php
                if ($galleryCategory['GalleryCategory']['published']) {
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