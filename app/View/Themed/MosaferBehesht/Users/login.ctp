<?php
$this->Html->addCrumb('ورود کاربران');
?>
<div class="grid_6">
<div class="box">
    <div class="content no-header">
    <h2></h2>
    ورود کاربران
    </div>
</div>

</div>
<div class="grid_6">
<form method="post">
<div class="box">
    <div class="content no-header">
    <h2>ورود کاربران</h2>
    <table width="100%">
        <tr>
            <td>نام کاربری : </td>
            <td><input type="text" name="data[User][username]" <?php if(isset($this->Form->params['form']['username'])) echo "value=\"{$this->Form->params['form']['username']}\""; ?> /></td>
        </tr>
        <tr>
            <td>رمز عبور : </td>
            <td><input type="password" name="data[User][password]" /></td>
        </tr>
        <tr>
            <td align="left" colspan="2"><input type="submit" value="ورود" /></td>
        </tr>
        <tr>
            <td colspan="2">
            <p>در صورتی که  ثبت نام نکرده اید. بر روی لینک زیر کلیک کنید</p>
            <?php echo $this->Html->link('ثبت نام',array('controller' =>'users','action'=>'register'),array('class'=>'btn')); ?></td>
        </tr>
    </table>
    </div>
</div>
</form>
</div>
<div class="clear"></div>