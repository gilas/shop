<?php
$this->Html->addCrumb($parentTitle, array('action' => 'index'));
$this->Html->addCrumb($title);
$this->Validator->addRule(array('Shop.Category'));
$this->Validator->validate(); 
echo $this->Form->create('Category', array(
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
    ),
    'type' => 'file'
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
        echo $this->Form->input('parent_id', array('label' => 'مجموعه پدر', 'div' => 'span4 input text'));
        echo $this->Form->input('thumbnail', array('label' => 'تصویر', 'type' => 'file', 'div' => 'span4 input text'));
    ?>
</div>
<div class="row row-pad">
    <div class="input span3 control-group">
        <label class="control-label">منتشر شده</label>
        <div class="controls">
            <label class="btn-group radio inline no-padding">
                <input id="CategoryPublished1" type="radio" name="data[Category][published]" value="1" <?php if ($this->Form->value('Category.published') == 1) echo 'checked="checked"' ?> />
                <label class="first-child" for="CategoryPublished1">بله</label>
                <input id="CategoryPublished0"  type="radio" name="data[Category][published]" value="0" <?php if ($this->Form->value('Category.published') == 0) echo 'checked="checked"' ?> />
                <label for="CategoryPublished0">خیر</label>
            </label>
        </div>
    </div>
</div>
<div class="row row-pad">
    <?php
        $this->TinyMCE->editor('advanced');
        echo $this->Form->input('desc', array('label' => 'توضیحات', 'div' => 'span4 input text', 'class' => 'tinymce', 'style' => 'width: 1028px; height: 344px;'));
    ?>
</div>
<?php
echo $this->Form->end(); 
?>