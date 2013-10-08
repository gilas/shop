<?php
// Add
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-plus icon-white')),array('action' => 'add','category_id' => @$this->request->named['category_id'],'normalLink' => true ),array('class' => 'btn btn-success','escape' => false, 'rel' => 'tooltip','data-original-title' => 'افزودن','tooltip-place' => 'bottom'));
// Delete
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-trash icon-white')),array('action' => 'delete','confirm' => 'آیا مطمئن هستید ؟'),array('class' => 'btn btn-danger','escape' => false, 'rel' => 'tooltip','data-original-title' => 'حذف','tooltip-place' => 'bottom'));
// Edit
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-pencil icon-white')),array('action' => 'edit','method' => 'get','firstChild' => true),array('class' => 'btn btn-info','escape' => false, 'rel' => 'tooltip','data-original-title' => 'ویرایش','tooltip-place' => 'bottom'));
//Show toolbar
$this->AdminForm->showToolbar('لیست وب لینک ها');
if (!empty($weblinks)) {
    // start form tag
    echo $this->AdminForm->startFormTag();
    ?>
    <table class="table table-bordered table-striped">

        <tr>
            <th><?php echo $this->AdminForm->selectAll() ?></th>
            <th>ردیف</th>
            <th>عنوان</th>
            <th>مجموعه</th>
            <th>آدرس وب</th>
            <th>منتشر شده</th>
        </tr>
        <?php
        //current index
        $index = $this->Filter->paginParams['limit'] * ($this->Filter->paginParams['page'] - 1);
        foreach ($weblinks as $weblink):
        ?>
        <tr>
            <td id="grid-align"><?php echo $this->AdminForm->checkbox($weblink['Weblink']['id']); ?></td>
            <td><?php echo ++$index; ?></td>
            <td><?php echo $this->Html->link($weblink['Weblink']['title'],array('action' => 'edit',$weblink['Weblink']['id'])); ?></td>
            <td id="grid-align"><?php echo $this->Html->link($weblink['WeblinkCategory']['name'],array('controller' => 'weblinkCategories','action' => 'edit',$weblink['WeblinkCategory']['id'])); ?></td>
            <td class="dir-left"><?php echo $this->Html->link($weblink['Weblink']['address'], $weblink['Weblink']['address'], array('target' => '_blank')); ?></td>
            <td id="grid-align">
            <?php
            if ($weblink['Weblink']['published']) {
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
        <?php endforeach;?>
    </table>
    <?php 
    echo $this->AdminForm->endFormTag();// end form tag
}
?>
<?php echo $this->Filter->limitAndPaginate(); ?>
