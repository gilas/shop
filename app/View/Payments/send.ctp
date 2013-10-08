<?php
//$this->Html->script('jquery.datepicker',false);
//$this->Html->css('jquery.datepicker',null,array('inline' => false));
?>
<h2>صفحه پرداخت</h2>
<ul>
    <li><label class="label_info">بخش مربوطه :    </label><?php echo $section ?></li>
    <li><label class="label_info">مبلغ پرداختی :  </label><?php echo $this->Html->price($price) ?></li>
    <li><label class="label_info">5 درصد مالیات : </label><?php echo $this->Html->price($tax) ?></li>
    <li style="font-weight: bold;"><label class="label_info">جمع کل :        </label><?php echo $this->Html->price($priceWithTax) ?></li>
    <!-- 
    <li>شماره کارت : 6037691072028962 به نام حسین زنگنه نیازآبادی</li>
    <li>شماره حساب : حساب جاری سپهر  0103791746001 بانک صادرات</li>
    -->
</ul>

<div class="summary">
    <div class="head">
        <div class="head_right"></div>
        <div class="head_left">پرداخت الکترونیکی</div>
    </div>
    <div class="contain">
        <?php echo $this->Html->defaultLink($this->Html->image('banks/eghtesad.png'),array('controller' => 'payments','action' => 'onlineSend', 'enbank'),array('escape' => false)) ?>
        <?php echo $this->Html->defaultLink($this->Html->image('banks/postbank.png'),array('controller' => 'payments','action' => 'onlineSend', 'postbank'),array('escape' => false)) ?>
        <?php echo $this->Html->defaultLink($this->Html->image('banks/tejarat.png'),array('controller' => 'payments','action' => 'onlineSend', 'tejaratbank'),array('escape' => false)) ?>
    </div>
</div>
<!--
<div class="summary">
    <div class="head">
        <div class="head_right"></div>
        <div class="head_left">کارت به کارت</div>
    </div>
    <div class="contain">
        <form method="post" action="">
            <input type="hidden" name="type" value="کارت" />
            <div class="input">
                <label>4 رقم آخر شماره کارت</label>
                <input type="text" name="ref_num" />
            </div>
            <div class="input">
                <label>تاریخ واریز</label>
                <input id="datepicker1" name="pay_date" type="text" />
            </div>
            <input type="submit" value="ثبت" />
        </form>
    </div>
</div>
<div class="summary">
    <div class="head">
        <div class="head_right"></div>
        <div class="head_left">واریز نقدی</div>
    </div>
    <div class="contain">
        <form method="post">
            <input type="hidden" name="type" value="نقدی" />
            <div class="input">
                <label>شماره فیش</label>
                <input type="text" name="ref_num" />
            </div>
            <div class="input">
                <label>تاریخ واریز</label>
                <input id="datepicker2" name="pay_date" type="text" />
            </div>
            <input type="submit" value="ثبت" />
        </form>
    </div>
</div>
<script>
    $(function(){
        $('#datepicker1').datepicker({
            defaultDate: new JalaliDate(<?php //Jalali::date('Y,m,d'); ?>),
            showButtonPanel: true,
            dateFormat: 'yy-mm-dd'
        }); 
        $('#datepicker2').datepicker({
            defaultDate: new JalaliDate(<?php //Jalali::date('Y,m,d'); ?>),
            showButtonPanel: true,
            dateFormat: 'yy-mm-dd'
        }); 
    })
</script>
-->
<style>
.label_info{
    display: inline-block;
    width:100px;
}
</style>