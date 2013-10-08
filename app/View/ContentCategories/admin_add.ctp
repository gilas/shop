<?php
$this->Validator->addRule('ContentCategory');
$this->Validator->validate();
echo $this->Form->create('ContentCategory', array(
    'inputDefaults' => array(
        'error' => array(
            'attributes' => array(
                'class' => 'alert-input-error',
                'id' => 'msg'
            )
        ),
        'empty' => '--- بدون مرجع ---'
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
<div class="row">
<?php
echo $this->Form->input('parent_id', array('label' => 'مجموعه مرجع', 'div' => 'input span3'));
echo $this->Form->input('name', array('label' => 'نام مجموعه', 'div' => 'input span3'));
?>
    <div class="input span3 control-group">
        <label class="control-label">منتشر شده</label>
        <div class="controls">
            <label class="btn-group radio inline no-padding">
                <input id="ContentCategoryPublished1" type="radio" name="data[ContentCategory][published]" value="1" <?php if ($this->Form->value('ContentCategory.published') == 1) echo 'checked="checked"' ?> />
                <label class="first-child" for="ContentCategoryPublished1">بله</label>
                <input id="ContentCategoryPublished0"  type="radio" name="data[ContentCategory][published]" value="0" <?php if ($this->Form->value('ContentCategory.published') == 0) echo 'checked="checked"' ?> />
                <label for="ContentCategoryPublished0">خیر</label>
            </label>
        </div>
    </div>
</div>
<?php
$this->TinyMCE->editor('advanced');
echo $this->Form->input('descriptions', array('label' => 'توضیحات', 'id' => 'tinyElm1', 'class' => 'tinymce'));
echo $this->Form->end();
?>

