<?php
$this->Html->addCrumb('ویرایش اطلاعات کاربری');
?>
<fieldset>
    <legend>ویرایش اطلاعات کاربری</legend>
    <?php echo $this->Form->create('User'); ?>
    <table class="table table-list">
        <tr>
            <th>نام و نام خانوادگی</th>
            <td><?php echo $this->Form->input('name', array('type' => 'text', 'value' => $user['User']['name'], 'div' => false, 'label' => false)); ?></td>
        </tr>
        <tr>
            <th>شماره همراه</th>
            <td><?php echo $this->Form->input('mobile', array('type' => 'text', 'value' => $user['ShopUser']['mobile'], 'div' => false, 'label' => false)); ?></td>
        </tr>
        <tr>
            <th>شماره تلفن</th>
            <td><?php echo $this->Form->input('phone', array('type' => 'text', 'value' => $user['ShopUser']['phone'], 'div' => false, 'label' => false)); ?></td>
        </tr>
        <tr>
            <th>آدرس</th>
            <td><?php echo $this->Form->input('address', array('type' => 'text', 'value' => $user['ShopUser']['address'], 'div' => false, 'label' => false)); ?></td>
        </tr>
        <tr>
            <th>پست الکترونیک</th>
            <td><?php echo $this->Form->input('email', array('type' => 'text', 'value' => $user['User']['email'], 'div' => false, 'label' => false)); ?></td>
        </tr>
        <tr>
            <th>روز عبور</th>
            <td><?php echo $this->Form->input('password', array('type' => 'password', 'div' => false, 'label' => false)); ?></td>
        </tr>
         <tr>
            <th>تکرار روز عبور</th>
            <td><?php echo $this->Form->input('password1', array('type' => 'password', 'div' => false, 'label' => false)); ?></td>
        </tr>
        <tr>
            <td colspan="2">
                <?php echo $this->Form->submit('ذخیره', array('div' => false, 'class' => 'btn btn-success')) ?>
                <?php echo $this->Html->link('بازگشت',array('action' => 'view') ,array('class' => 'btn')) ?>
            </td>
        </tr>
    </table>
    <?php echo $this->Form->end(); ?>
</fieldset>