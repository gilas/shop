<?php
$this->Validator->addRule('Sms');
$this->Validator->validate(); 
echo $this->Form->create('Sms', array(
    'inputDefaults' => array(
        'error' => array(
            'attributes' => array(
                'class' => 'alert-input-error',
                'id' => 'msg'
            )
        ),
    )
));
?>
<div id="toolbar-menu" class="row">
    <div class="title">ارسال پیامک</div>
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
echo $this->Form->input('title', array('label' => 'عنوان مطلب'));
echo $this->Form->input('slug', array('label' => 'نام مستعار'));
echo $this->Form->input('content_category_id', array('label' => 'مجموعه','empty' => '--- انتخاب مجموعه ---' ,'value' => @$this->request->named['content_category_id'], ));
echo $this->Form->input('intro', array('label' => 'متن','id' => 'tinyElm1', 'class' => 'tinymce'));
echo $this->Form->end();
?>
