<?php
// Add
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-plus icon-white')),array('action' => 'add','normalLink' => true ),array('class' => 'btn btn-success','escape' => false, 'rel' => 'tooltip','data-original-title' => 'افزودن','tooltip-place' => 'bottom'));
// Delete
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-trash icon-white')),array('action' => 'delete','confirm' => 'آیا مطمئن هستید ؟'),array('class' => 'btn btn-danger','escape' => false, 'rel' => 'tooltip','data-original-title' => 'حذف','tooltip-place' => 'bottom'));
// Edit
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-pencil icon-white')),array('action' => 'edit','method' => 'get','firstChild' => true),array('class' => 'btn btn-info','escape' => false, 'rel' => 'tooltip','data-original-title' => 'ویرایش','tooltip-place' => 'bottom'));
//Show toolbar
$this->AdminForm->showToolbar('لیست اطلاعات تماس');
if (!empty($contactDetails)) {
    // start form tag
    echo $this->AdminForm->startFormTag();
    ?>
    <table class="table table-bordered table-striped">

        <tr>
            <th><?php echo $this->AdminForm->selectAll(); ?></th>
            <th>ردیف</th>
            <th>عنوان</th>
            <th>مدیریت</th>
            <th>تلفن 1</th>
            <th>تلفن 2</th>
            <th>فکس</th>
            <th>پیام کوتاه</th>
        </tr>
        <?php
        //current index
         $index = $this->Filter->paginParams['limit'] * ($this->Filter->paginParams['page'] - 1);
        foreach ($contactDetails as $contactDetail):
        ?>
        <tr>
            <td id="grid-align"><?php echo $this->AdminForm->checkbox($contactDetail['ContactDetail']['id']); ?></td>
            <td><?php echo ++$index; ?></td>
            <td><?php echo $this->Html->link($contactDetail['ContactDetail']['title'],array('action' => 'edit',$contactDetail['ContactDetail']['id'])); ?></td>
            <td><?php echo $contactDetail['ContactDetail']['manager']; ?></td>
            <td><?php echo $contactDetail['ContactDetail']['telephone_1']; ?></td>
            <td><?php echo $contactDetail['ContactDetail']['telephone_2']; ?></td>
            <td><?php echo $contactDetail['ContactDetail']['fax']; ?></td>
            <td><?php echo $contactDetail['ContactDetail']['mobile']; ?></td>
            <td><?php echo $contactDetail['ContactDetail']['sms_center']; ?></td>
        </tr>
        <?php endforeach;?>
    </table>
    <?php
}
?>
<?php echo $this->Filter->limitAndPaginate(); ?>
