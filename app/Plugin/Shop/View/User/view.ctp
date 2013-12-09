<?php
$this->Html->addCrumb('اطلاعات کاربری');
?>
<fieldset>
    <legend>اطلاعات کاربری</legend>
    <?php echo $this->Html->link('ویرایش اطلاعات', array('action' => 'edit'), array('class' => 'btn btn-success')); ?>
    <table class="table table-list" style="margin-top: 20px;">
        <tr>
            <th>نام و نام خانوادگی</th>
            <td><?php echo $user['User']['name']; ?></td>
        </tr>
        <tr>
            <th>گروه کاربری</th>
            <td><?php echo $user['Group']['name'].' ('.$this->Html->percent($user['Group']['discount']).' تخفیف)'; ?></td>
        </tr>
        <tr>
            <th>شماره همراه</th>
            <td><?php echo $user['ShopUser']['mobile']; ?></td>
        </tr>
        <tr>
            <th>شماره تلفن</th>
            <td><?php echo $user['ShopUser']['phone']; ?></td>
        </tr>
        <tr>
            <th>آدرس</th>
            <td><?php echo $user['ShopUser']['address']; ?></td>
        </tr>
        <tr>
            <th>پست الکترونیک</th>
            <td><?php echo $user['User']['email']; ?></td>
        </tr>
    </table>
</fieldset>