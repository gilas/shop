<?php
//$this->Html->script('jquery.datepicker',false);
//$this->Html->css('jquery.datepicker',null,array('inline' => false));
?>
<h2>صفحه پرداخت</h2>
<ul>
    <li><label class="label_info">بخش مربوطه :    </label><?php echo $section ?></li>
    <li style="font-weight: bold;"><label class="label_info">مبلغ پرداختی :        </label><?php echo $this->Html->price($priceWithTax) ?></li>
</ul>

<div class="summary">
    <div class="head">
        <div class="head_right"></div>
        <div class="head_left">پرداخت الکترونیکی</div>
    </div>
    <div class="contain">
        <?php echo $this->Html->defaultLink($this->Html->image('banks/eghtesad.png'),array('controller' => 'payments','action' => 'onlineSend', 'enbank'),array('escape' => false)) ?>
        <?php echo $this->Html->defaultLink($this->Html->image('banks/tejarat.png'),array('controller' => 'payments','action' => 'onlineSend', 'tejaratbank'),array('escape' => false)) ?>
        <?php if(SettingsController::read('Payment.showTest')){echo $this->Html->defaultLink('Test',array('controller' => 'payments','action' => 'onlineSend', 'test')); } ?>
    </div>
</div>
<style>
.label_info{
    display: inline-block;
    width:100px;
}
</style>