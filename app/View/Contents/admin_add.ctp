<?php
$this->Validator->addRule('Content');
$this->Validator->validate(); 
echo $this->Form->create('Content', array(
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
<div class="row">
<?php
echo $this->Form->input('title', array('label' => 'عنوان مطلب', 'div' => 'input span3'));
echo $this->Form->input('slug', array('label' => 'نام مستعار', 'div' => 'input span3'));
echo $this->Form->input('content_category_id', array('label' => 'مجموعه', 'div' => 'input span3','empty' => '--- انتخاب مجموعه ---' ,'value' => @$this->request->named['content_category_id'], ));
?>
</div>
<div class="row">
    <div class="input span3 control-group">
        <label class="control-label">منتشر شده</label>
        <div class="controls">
            <label class="btn-group radio inline no-padding">
                <input id="ContentPublished1" type="radio" name="data[Content][published]" value="1" <?php if ($this->Form->value('Content.published') == 1) echo 'checked="checked"' ?> />
                <label class="first-child" for="ContentPublished1">بله</label>
                <input id="ContentPublished0"  type="radio" name="data[Content][published]" value="0" <?php if ($this->Form->value('Content.published') == 0) echo 'checked="checked"' ?> />
                <label for="ContentPublished0">خیر</label>
            </label>
        </div>
    </div>
    <div class="input span3 control-group">
        <label class="control-label">صفحه نخست</label>
        <div class="controls">
            <label class="btn-group radio inline no-padding">
                <input id="ContentFrontpage1" type="radio" name="data[Content][frontpage]" value="1" <?php if ($this->Form->value('Content.frontpage') == 1) echo 'checked="checked"' ?> />
                <label class="first-child" for="ContentFrontpage1">بله</label>
                <input id="ContentFrontpage0"  type="radio" name="data[Content][frontpage]" value="0" <?php if ($this->Form->value('Content.frontpage') == 0) echo 'checked="checked"' ?> />
                <label for="ContentFrontpage0">خیر</label>
            </label>
        </div>
    </div>
    <div class="input span3 control-group">
        <label class="control-label">نظردهی به مطلب</label>
        <div class="controls">
            <label class="btn-group radio inline no-padding">
                <input id="Contentallow_comment1" type="radio" name="data[Content][allow_comment]" value="1" <?php if ($this->Form->value('Content.allow_comment') == 1) echo 'checked="checked"' ?> />
                <label class="first-child" for="Contentallow_comment1">بله</label>
                <input id="Contentallow_comment0"  type="radio" name="data[Content][allow_comment]" value="0" <?php if ($this->Form->value('Content.allow_comment') == 0) echo 'checked="checked"' ?> />
                <label for="Contentallow_comment0">خیر</label>
            </label>
        </div>
    </div>
    <div class="input span3 control-group">
        <label class="control-label">منتشر شده</label>
        <div class="controls">
            <label class="btn-group radio inline no-padding">
                <input id="Contentpublished_comment1" type="radio" name="data[Content][published_comment]" value="1" <?php if ($this->Form->value('Content.published_comment') == 1) echo 'checked="checked"' ?> />
                <label class="first-child" for="Contentpublished_comment1">نمایش بلادرنگ</label>
                <input id="Contentpublished_comment0"  type="radio" name="data[Content][published_comment]" value="0" <?php if ($this->Form->value('Content.published_comment') == 0) echo 'checked="checked"' ?> />
                <label for="Contentpublished_comment0">نمایش پس از تایید</label>
            </label>
        </div>
    </div>
</div>
<div class="row">
<?php
$this->TinyMCE->editor('advanced');
echo $this->Form->input('intro', array('label' => 'متن','id' => 'tinyElm1', 'class' => 'tinymce', 'div' => 'input span12'));
?>
</div>
<a onclick="insertReadmore();return false;" class="btn btn-primary" style="margin-top: 10px;">ادامه مطلب</a>
<?php
echo $this->Form->end();
?>
<script>
    function insertReadmore() {
            var content = $('#tinyElm1').html();
            if (content.match(/<hr\s+id=("|')system-readmore("|')\s*\/*>/i)) {
                    alert('چنین لینکی تنها یکبار مجوز درج دارد.');
                    return false;
            } else {
                if(content == ''){
                    alert('متنی باید وارد شود تا ادامه مطلب درج گردد');
                    return;
                }
                $('#tinyElm1').tinymce().execCommand('mceInsertContent',false,'<hr id="system-readmore" />');
            }
    }
</script>