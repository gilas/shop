<?php
$this->Validator->addRule('GalleryCategory');
$this->Validator->validate(); 
echo $this->Form->create('GalleryCategory', array(
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
    <div class="title">ویرایش مجموعه گالری</div>
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
echo $this->Form->input('parent_id', array('label' => 'مجموعه مرجع', 'empty' => '--- بدون مرجع ---'));
echo $this->Form->input('name', array('label' => 'نام مجموعه'));
echo $this->Form->input('folder_name', array('label' => 'نام پوشه برای ذخیره تصاویر'));
?>
<div class="input control-group">
    <label class="control-label">منتشر شده</label>
    <div class="controls">
        <label class="btn-group radio inline no-padding">
            <input id="GalleryCategoryPublished1" type="radio" name="data[GalleryCategory][published]" value="1" <?php if ($this->Form->value('GalleryCategory.published') == 1) echo 'checked="checked"' ?> />
            <label class="first-child" for="GalleryCategoryPublished1">بله</label>
            <input id="GalleryCategoryPublished0"  type="radio" name="data[GalleryCategory][published]" value="0" <?php if ($this->Form->value('GalleryCategory.published') == 0) echo 'checked="checked"' ?> />
            <label for="GalleryCategoryPublished0">خیر</label>
        </label>
    </div>
</div>
<?php
echo $this->Form->end();
?>
