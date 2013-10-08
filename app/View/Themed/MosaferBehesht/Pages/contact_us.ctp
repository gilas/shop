<?php
$this->Html->addCrumb('ارتباط با ما');
?>
<div class="grid_6">
<table>
    <tr>
        <td style="width:100px">آدرس : </td>
        <td>مشهد، ابتدای خیابان طبرسی نبش طبرسی 3، ستاد ساماندهی امور زائرین</td>
    </tr>
    <tr>
        <td>سامانه تلفن گویا : </td>
        <td>05118467980</td>
    </tr>
    <tr>
        <td>تلفن : </td>
        <td>05113691080-4 ، 05118467980-4</td>
    </tr>
    <tr>
        <td>فاکس : </td>
        <td>05118464994</td>
    </tr>
    <tr>
        <td>سامانه پیامکی : </td>
        <td>10000915</td>
    </tr>
    <tr>
        <td>صندوق پستی :</td>
        <td>91375-1999</td>
    </tr>
    <tr>
        <td> مدیر اجرایی: </td>
        <td>09155115234  (  آقای حسین زنگنه )</td>
    </tr>
</table>
</div>
<form action="<?php echo $this->Html->url() ?>" method="post">
    <div class="grid_6">
        <div class="box">
            <div class="header"><h3>ارسال پیام</h3></div>
            <div class="content">
                <table class="users">
                    <tr>
                        <td>نام و نام خانوادگی : </td>
                        <td><input type="text" name="data[name]" value="<?php echo $this->request->data('name'); ?>"/></td>
                    </tr>
                    <tr>
                        <td>پست الکترونیک : </td>
                        <td><input type="text" name="data[email]" value="<?php echo $this->request->data('email'); ?>"/></td>
                    </tr>
                    <tr>
                        <td>پیام : </td>
                        <td><textarea style="height:150px"  name="data[message]"><?php echo $this->request->data('message'); ?></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="checkbox" name="data[forward]" />
                            ارسال یک نسخه به شما
                        </td>
                    </tr>
                </table>
            </div>
            <div class="actions">
                <div class="actions-left"><input type="submit" value="ارسال"/></div>
            </div>
        </div>
    </div>
</form>