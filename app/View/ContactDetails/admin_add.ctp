<?php
$this->Validator->addRule('ContactDetail');
$this->Validator->validate(); 
echo $this->Form->create('ContactDetail', array(
    'inputDefaults' => array(
        'error' => array(
            'attributes' => array(
                'class' => 'alert alert-error',
                'id' => 'msg'
            )
        )
    )
));
?>
<div id="toolbar-menu" class="row">
    <div class="title">افزودن اطلاعات تماس</div>
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
echo $this->Form->input('title', array('label' => 'عنوان'));
echo $this->Form->input('manager', array('label' => 'مدیریت'));
echo $this->Form->input('telephone_1', array('label' => 'تلفن 1'));
echo $this->Form->input('telephone_2', array('label' => 'تلفن 2'));
echo $this->Form->input('fax', array('label' => 'فکس'));
echo $this->Form->input('mobile', array('label' => 'موبایل'));
echo $this->Form->input('email', array('label' => 'پست الکترونیک'));
echo $this->Form->input('sms_center', array('label' => 'پیام کوتاه'));
echo $this->Form->end();
?>