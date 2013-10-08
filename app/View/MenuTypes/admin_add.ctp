<?php
$this->Validator->addRule('MenuType');
$this->Validator->validate(); 
echo $this->Form->create('MenuType', array(
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
    <div class="title">افزودن نوع منو</div>
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
<?php
echo $this->Form->input('type', array('label' => 'نوع'));
echo $this->Form->input('title', array('label' => 'عنوان'));
echo $this->Form->input('description', array('label' => 'توضیحات'));
echo $this->Form->end();
?>