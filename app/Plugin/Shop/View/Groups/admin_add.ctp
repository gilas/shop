<?php
$this->Html->addCrumb($parentTitle, array('action' => 'index'));
$this->Html->addCrumb($title);
$this->Validator->addRule(array('Shop.Group'));
$this->Validator->validate(); 
echo $this->Form->create('Group', array(
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
        echo $this->Form->input('name', array('label' => 'عنوان', 'div' => 'span4 input text'));
        echo $this->Form->input('discount', array('label' => 'درصد تخفیف', 'div' => 'span4 input-append text', 'class' => 'price', 'after' => '<span class="add-on">%</span>'));
    ?>
</div>
<?php
echo $this->Form->end(); 
?>