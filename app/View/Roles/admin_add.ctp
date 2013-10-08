<?php
$this->Html->addCrumb('مدیریت نقش ها', array('action' => 'index'));
$this->Html->addCrumb($title_for_layout);
$this->Validator->addRule('Role');
$this->Validator->validate(); 
echo $this->Form->create('Role',array(
    'inputDefaults' => array(
        'error' => array(
            'attributes' => array(
                'class' => 'alert-input-error',
                'id' => 'msg'
            )
        ),
    ),
));
?>
<div id="toolbar-menu" class="row">
    <div class="title"><?php echo $title_for_layout; ?></div>
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
echo $this->Form->input('title', array('label' => 'عنوان فارسی'));
echo $this->Form->input('name', array('label' => 'عنوان لاتین'));
echo $this->Form->end();
?>