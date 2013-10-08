<?php
$this->Html->addCrumb('مدیریت نقش ها');
// Add
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-plus icon-white')),array('action' => 'add','normalLink' => true ),array('class' => 'btn btn-success','escape' => false, 'rel' => 'tooltip','data-original-title' => 'افزودن','tooltip-place' => 'bottom'));
// Delete
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-trash icon-white')),array('action' => 'delete','confirm' => 'آیا مطمئن هستید ؟'),array('class' => 'btn btn-danger','escape' => false, 'rel' => 'tooltip','data-original-title' => 'حذف','tooltip-place' => 'bottom'));
// Edit
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-pencil icon-white')),array('action' => 'edit','method' => 'get','firstChild' => true),array('class' => 'btn btn-info','escape' => false, 'rel' => 'tooltip','data-original-title' => 'ویرایش','tooltip-place' => 'bottom'));
//Show toolbar
$this->AdminForm->showToolbar('مدیریت نقش ها');

if (!empty($roles)) {
// start form tag
echo $this->AdminForm->startFormTag();
?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="checkbox-column"><?php echo $this->AdminForm->selectAll(); ?></th>
                <th>ردیف</th>
                <th><?php echo $this->Paginator->sort('Role.title','عنوان') ?></th>
                <th>تعداد کاربران</th>
            </tr>
        </thead>
        <tbody>
        <?php
        //current index
        $index = $this->Filter->paginParams['limit'] * ($this->Filter->paginParams['page'] - 1);
        foreach ($roles as $role):
        ?>
            <tr>
                <td  id="grid-align"><?php echo $this->AdminForm->checkbox($role['Role']['id']) ?></td>
                <td id="grid-align"><?php echo ++$index; ?></td>
                <td><?php echo $this->Html->link($role['Role']['title'],array('action' => 'edit', $role['Role']['id'])); ?></td>
                <td>
                <?php 
                echo $this->Html->link(
                    $role['User']['count'], 
                    ($role['User']['count'])?array('controller' => 'Users', 'action' => 'index', 'role_id' => $role['Role']['id']):'#', 
                    array('class' => 'btn')
                ); 
                ?>
                </td>
            </tr>
            <?php
        endforeach;
        ?>
        </tbody>
    </table>
<?php
    echo $this->AdminForm->endFormTag();// end form tag
}
?>
<?php echo $this->Filter->limitAndPaginate(); ?>