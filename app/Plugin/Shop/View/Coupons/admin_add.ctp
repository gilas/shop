<?php
$this->Html->addCrumb($parentTitle, array('action' => 'index'));
$this->Html->addCrumb($title);
$this->Html->script('price', false);
$this->Validator->addRule(array('Shop.Coupon'));
$this->Validator->validate(); 
echo $this->Form->create('Coupon', array(
    'inputDefaults' => array(
        'error' => array(
            'attributes' => array(
                'class' => 'alert-input-error',
                'id' => 'msg'
            )
        ),
        'empty' => array(
            0 => '--- انتخاب کنید ---'
        )
    )
));
?>
<div id="toolbar-menu" class="row">
    <div class="title"><?php echo $title ?></div>
    <ul id="toolbar">
        <li>
            <a onclick="$(this).parents('form').submit();" class="btn btn-success" tooltip-place="bottom" data-original-title="ذخیره" rel="tooltip" >
                <i class="icon-ok icon-white"></i><input type="submit" style="display: none;" />
            </a>
        </li>
        <li>
            <a href="<?php echo $this->Html->url(array('action' => 'index')); ?>" class="btn btn-danger" tooltip-place="bottom" data-original-title="انصراف" rel="tooltip" >
                <i class="icon-remove icon-white"></i>
            </a>
        </li>
    </ul>
</div>
<div class="row row-pad">
    <?php
        echo $this->Form->input('type', array('label' => 'نوع کوپن', 'div' => 'span4 input text', 'options' => $namedType));
        echo $this->Form->input('discount_type', array('label' => 'نوع ارزش', 'div' => 'span4 input text', 'options' => $namedDiscountType));
        echo $this->Form->input('discount_value', array('label' => 'ارزش', 'div' => 'span4 input text', 'class' => 'price'));
    ?>
</div>
<div class="row row-pad">
    <?php
        echo $this->Form->input('count', array('label' => 'تعداد تولید', 'div' => 'span4 input text'));
        echo $this->Form->input('prefix', array('label' => 'پیشوند', 'div' => 'span4 input text'));
    ?>
</div>
<?php
echo $this->Form->end(); 
?>