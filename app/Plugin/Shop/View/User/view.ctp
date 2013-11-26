<?php
$this->Html->addCrumb('اطلاعات کاربری');
?>
<fieldset>
    <legend>اطلاعات کاربری</legend>
    <table class="table table-list">
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
    </table>
</fieldset>