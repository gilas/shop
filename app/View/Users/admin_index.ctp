<?php
$this->Html->addCrumb('مدیریت کاربران');
// Add
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-plus icon-white')),array('action' => 'add','normalLink' => true ),array('class' => 'btn btn-success','escape' => false, 'rel' => 'tooltip','data-original-title' => 'افزودن','tooltip-place' => 'bottom'));
// Delete
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-trash icon-white')),array('action' => 'delete','confirm' => 'آیا مطمئن هستید ؟'),array('class' => 'btn btn-danger','escape' => false, 'rel' => 'tooltip','data-original-title' => 'حذف','tooltip-place' => 'bottom'));
// Edit
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-pencil icon-white')),array('action' => 'edit','method' => 'get','firstChild' => true),array('class' => 'btn btn-info','escape' => false, 'rel' => 'tooltip','data-original-title' => 'ویرایش','tooltip-place' => 'bottom'));
// Active
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-ok icon-white')),array('action' => 'active'),array('class' => 'btn btn-info','escape' => false, 'rel' => 'tooltip','data-original-title' => 'فعال کردن','tooltip-place' => 'bottom'));
// Inactive
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-remove icon-white')),array('action' => 'inactive'),array('class' => 'btn btn-info','escape' => false, 'rel' => 'tooltip','data-original-title' => 'غیرفعال کردن','tooltip-place' => 'bottom'));
// Settings
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-wrench icon-white')),array('action' => 'settings', 'layout' => 'iframe'),array('class' => 'btn btn-warning','escape' => false, 'rel' => 'tooltip','data-original-title' => 'تنظیمات','tooltip-place' => 'bottom'));
//Show toolbar
$this->AdminForm->showToolbar('مدیریت کاربران');

//Filtering
// we use action in options for rewriting action attr without querystring
echo $this->Filter->create('User',array('action' => 'index'));
echo $this->Filter->input('username',array('label' => 'نام کاربری'));
echo $this->Filter->input('active',array(
    'label' => 'وضعیت',
    'options' => array('' => '','1' => 'فعال', '0' => 'غیرفعال'))
);
echo $this->Filter->input('role_id',array(
    'label' => 'نقش',
    'options' => $roles,
    'empty' => ''
    )
);
echo $this->Filter->end();
if (!empty($users)) {
// start form tag
echo $this->AdminForm->startFormTag();
?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="checkbox-column"><?php echo $this->AdminForm->selectAll(); ?></th>
                <th>ردیف</th>
                <th><?php echo $this->Paginator->sort('User.name','نام و نام خانوادگی') ?></th>
                <th><?php echo $this->Paginator->sort('User.username','نام کاربری') ?></th>
                <th><?php echo $this->Paginator->sort('User.email','پست الکترونیک') ?></th>
                <th><?php echo $this->Paginator->sort('Role.title','نقش') ?></th>
                <th><?php echo $this->Paginator->sort('User.active','وضعیت') ?></th>
                <th><?php echo $this->Paginator->sort('User.registered_date','تاریخ عضویت') ?></th>
                <th><?php echo $this->Paginator->sort('User.last_logged_in ','آخرین تاریخ ورود') ?></th>
                <th><?php echo $this->Paginator->sort('User.id','شناسه کاربری') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php
        //current index
        $index = $this->Filter->paginParams['limit'] * ($this->Filter->paginParams['page'] - 1);
        foreach ($users as $user):
        ?>
            <tr>
                <td  id="grid-align"><?php echo $this->AdminForm->checkbox($user['User']['id']) ?></td>
                <td><?php echo ++$index; ?></td>
                <td><?php echo $this->Html->link($user['User']['name'],array('action' => 'edit', $user['User']['id'])); ?></td>
                <td><?php echo $user['User']['username']; ?></td>
                <td class="dir-left"><?php echo $user['User']['email']; ?></td>
                <td><?php echo $this->Html->link($user['Role']['title'],array('controller' => 'Users', 'action' => 'index','role_id' => $user['Role']['id'])); ?></td>
                <td>
                <?php
                if ($user['User']['active']) {
                    // Active
                    echo $this->AdminForm->item(
                        $this->Html->image('tick.png'),//title
                        array('action' => 'inactive'),// url
                        array('escape' => false, 'class' => 'btn active btn-small')//option
                    );
                } else {
                    // Inactive
                    echo $this->AdminForm->item(
                        $this->Html->image('publish_x.png'),
                        array('action' => 'active'),
                        array('escape' => false, 'class' => 'btn btn-small')//option
                    );
                }
                ?>
                </td>
                <td><?php echo Jalali::niceShort($user['User']['registered_date']); ?></td>
                <td><?php echo Jalali::niceShort($user['User']['last_logged_in']); ?></td>
                <td><?php echo $user['User']['id']; ?></td>
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