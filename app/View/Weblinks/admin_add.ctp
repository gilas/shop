<?php
$this->Validator->addRule(array('Weblink'=>array('weblink_category_id', 'title')));
$this->Validator->validate(); 
echo $this->Form->create('Weblink', array(
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
echo $this->Form->input('weblink_category_id', array(
    'label' => 'مجموعه', 
    'value' => @$this->request->named['category_id'],
    'empty' => '--- انتخاب مجموعه ---'
    )
);
echo $this->Form->input('title', array('label' => 'عنوان'));
echo $this->Form->input('description', array('label' => 'توضیحات'));
echo $this->Form->input('address', array('label' => 'آدرس وب'));
?>
<div class="input control-group">
    <label class="control-label">منتشر شده</label>
    <div class="controls">
        <label class="btn-group radio inline no-padding">
            <input id="WeblinkPublished1" type="radio" name="data[Weblink][published]" value="1" <?php if ($this->Form->value('Weblink.published') == 1) echo 'checked="checked"' ?> />
            <label class="first-child" for="WeblinkPublished1">بله</label>
            <input id="WeblinkPublished0"  type="radio" name="data[Weblink][published]" value="0" <?php if ($this->Form->value('Weblink.published') == 0) echo 'checked="checked"' ?> />
            <label for="WeblinkPublished0">خیر</label>
        </label>
    </div>
</div>
<?php echo $this->Form->end(); ?>