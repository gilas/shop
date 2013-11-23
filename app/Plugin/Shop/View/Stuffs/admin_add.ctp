<?php
$this->Html->addCrumb($parentTitle, array('action' => 'index'));
$this->Html->addCrumb($title);
$this->Html->script('price', false);
$this->Validator->addRule(array('Shop.Stuff'));
$this->Validator->validate(); 
echo $this->Form->create('Stuff', array(
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
<ul class="nav nav-tabs" id="myTab">
<li class="active"><a href="#stuff">مشخصات کالا</a></li>
<li><a href="#gallery">گالری تصاویر</a></li>
</ul>
 
<div class="tab-content">
<div class="tab-pane active" id="stuff">
    <div class="row row-pad">
        <?php
            echo $this->Form->input('code', array('label' => 'کد کالا', 'div' => 'span4 input text'));
            echo $this->Form->input('name', array('label' => 'نام کالا', 'div' => 'span4 input text'));
            echo $this->Form->input('category_id', array('label' => 'مجموعه', 'div' => 'span4 input text'));
        ?>
    </div>
    <div class="row row-pad">
        <?php
            echo $this->Form->input('thumbnail', array('label' => 'تصویر', 'div' => 'span4 input text', 'type' => 'file'));
            echo $this->Form->input('count', array('label' => 'تعداد موجود', 'div' => 'span4 input text', 'class' => 'price'));
            echo $this->Form->input('price', array('label' => 'قیمت کالا (ریال)', 'class' => 'price', 'div' => 'span4 input text'));
        ?>
    </div>
    <div class="row row-pad">
        <?php
            echo $this->Form->input('discount', array('label' => 'درصد تخفیف', 'div' => 'span4 input text'));
            echo $this->Form->input('type', array('label' => 'نوع کالا', 'div' => 'span4 input text','empty' => false, 'options' => $types));
            echo $this->Form->input('tax_id', array('label' => 'مالیات کالا', 'div' => 'span4 input text real_options'));
            echo $this->Form->input('download_file', array('label' => 'فایل دانلود', 'type' => 'file', 'div' => 'span4 input text vitual_options'));
        ?>
    </div>
    <div class="row row-pad real_options">
        <?php
            echo $this->Form->input('deport_id', array('label' => 'روش حمل کالا', 'div' => 'span4 input text'));
            echo $this->Form->input('weight', array('label' => 'وزن کالا (گرم)', 'div' => 'span4 input text'));
            echo $this->Form->input('dimension', array('label' => 'ابعاد (طول × عرض × ارتفاع)', 'div' => 'span4 input text'));
        ?>
    </div>
    <div class="row row-pad">
        <?php
            echo $this->Form->input('attachments', array('label' => 'فایل های ضمیمه','type' => 'file', 'div' => 'span4 input text'));
            echo $this->Form->input('order', array('label' => 'نوع سفارش', 'div' => 'span4 input text','empty' => false, 'options' => $orders));
        ?>
        <div class="input span3 control-group">
            <label class="control-label">منتشر شده</label>
            <div class="controls">
                <label class="btn-group radio inline no-padding">
                    <input id="StuffPublished1" type="radio" name="data[Stuff][published]" value="1" <?php if ($this->Form->value('Stuff.published') == 1) echo 'checked="checked"' ?> />
                    <label class="first-child" for="StuffPublished1">بله</label>
                    <input id="StuffPublished0"  type="radio" name="data[Stuff][published]" value="0" <?php if ($this->Form->value('Stuff.published') == 0) echo 'checked="checked"' ?> />
                    <label for="StuffPublished0">خیر</label>
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
</div>
<div class="tab-pane" id="gallery">
    <div class="row row-pad">
        <div class="span4">
            <?php //TODO: Upload Gallery image ?>
            <a class="btn btn-primary"><i class="icon-upload icon-white"></i></a>
        </div>
    </div>
    <div id="galleryList"></div>
</div>
</div>
<?php
echo $this->Form->end(); 
?>
<script>
    $(function(){
        $('#myTab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        })
        $('#StuffType').change(function(){
            if($(this).val() == 1){
                $('.real_options').show();
                $('.vitual_options').hide();
            }else{
                $('.vitual_options').show();
                $('.real_options').hide();
            }
        })
        $('#StuffType').trigger('change');
    })
</script>