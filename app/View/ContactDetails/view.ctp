<?php
$this->set('title_for_layout', $contactDetail['ContactDetail']['title']);
$this->Html->addCrumb($contactDetail['ContactDetail']['title']);
?>
<span><?php echo $contactDetail['ContactDetail']['title']; ?></span>
<div class="information">
    <label>مدیریت :</label>
    <span><?php echo $contactDetail['ContactDetail']['manager']; ?></span>
</div>
<div class="information">
    <label>تلفن 1 :</label>
    <span><?php echo $contactDetail['ContactDetail']['telephone_1']; ?></span>
</div>
<div class="information">
    <label>تلفن 2 :</label>
    <span><?php echo $contactDetail['ContactDetail']['telephone_2']; ?></span>
</div>
<div class="information">
    <label>فکس :</label>
    <span><?php echo $contactDetail['ContactDetail']['fax']; ?></span>
</div>
<div class="information">
    <label>همراه :</label>
    <span><?php echo $contactDetail['ContactDetail']['mobile']; ?></span>
</div>
<div class="information">
    <label>سامانه پیام کوتاه :</label>
    <span><?php echo $contactDetail['ContactDetail']['sms_center']; ?></span>
</div>
<div id="contactform">
    <h5 class="caption">ارسال پیام</h5>
    <?php
    echo $this->Form->create('ContactDetail');
    echo $this->Form->input('name',array('label'=>'نام'));
    echo $this->Form->input('email',array('label'=>'پست الکترونیک'));
    echo $this->Form->input('content',array('label'=>'متن','cols'=>'30','rows'=>'15'));
    echo $this->Form->end('ارسال');
    ?>
</div>