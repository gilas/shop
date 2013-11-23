<?php
$this->Html->addCrumb($parentTitle, array('action' => 'index'));
$this->Html->addCrumb($title);
$this->Html->script('price', false);
$this->Validator->addRule(array('Shop.Deport'));
$this->Validator->validate(); 
echo $this->Form->create('Deport', array(
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
    <div class="title"><?php echo $title; ?></div>
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
        echo $this->Form->input('name', array('label' => 'طریقه ارسال', 'div' => 'span4 input text'));
        echo $this->Form->input('price', array('label' => 'هزینه ارسال', 'div' => 'span4 input-append text', 'class' => 'price', 'after' => '<span class="add-on">ریال</span>'));
    ?>
</div>
<?php
echo $this->Form->end(); 
?>