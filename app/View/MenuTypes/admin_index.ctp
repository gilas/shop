<?php
// Add
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-plus icon-white')),array('action' => 'add','normalLink' => true ),array('class' => 'btn btn-success','escape' => false, 'rel' => 'tooltip','data-original-title' => 'افزودن','tooltip-place' => 'bottom'));
// Delete
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-trash icon-white')),array('action' => 'delete','confirm' => 'آیا مطمئن هستید ؟'),array('class' => 'btn btn-danger','escape' => false, 'rel' => 'tooltip','data-original-title' => 'حذف','tooltip-place' => 'bottom'));
// Edit
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-pencil icon-white')),array('action' => 'edit','method' => 'get','firstChild' => true),array('class' => 'btn btn-info','escape' => false, 'rel' => 'tooltip','data-original-title' => 'ویرایش','tooltip-place' => 'bottom'));
//Show toolbar
$this->AdminForm->showToolbar('لیست نوع منو ها');
if (!empty($menuTypes)) {
    // start form tag
    echo $this->AdminForm->startFormTag();
    ?>
    
    <table class="table table-bordered table-striped">

        <tr>
            <th><?php echo $this->AdminForm->selectAll() ?></th>
            <th>ردیف</th>
            <th>نوع</th>
            <th>عنوان</th>
            <th id="grid-align">گزینه های منو</th>
        </tr>
        <?php
        $index = $this->Filter->paginParams['limit'] * ($this->Filter->paginParams['page'] - 1);
        foreach ($menuTypes as $menuType):?>
        <tr>
            <td id="grid-align"><?php echo  $this->AdminForm->checkbox($menuType['MenuType']['id']) ?></td>
            <td><?php echo ++$index; ?></td>
            <td><?php echo $this->Html->link($menuType['MenuType']['type'],array('action' => 'edit',$menuType['MenuType']['id'])); ?></td>
            <td><?php echo $menuType['MenuType']['title']; ?></td>
            <td id="grid-align">
            <?php 
            echo $this->Html->link(
                $menuType['MenuType']['childCount'], 
                array('controller' => 'menus', 'action' => 'index', 'menu_type_id' => $menuType['MenuType']['id']), 
                array('class' => 'btn')
            ); 
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
