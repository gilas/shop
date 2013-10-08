<?php
$this->Html->addCrumb('مدیریت اسلایدر', array('action' => 'index'));
$this->Html->addCrumb('ویرایش تصویر');
$this->Validator->addRule(array('SliderItem' => array('title', 'name', 'link')));
$this->Validator->validate();
$this->Html->script('modal',false);
$this->Html->css('modal',null,array('inline' => false));
echo $this->Form->create('SliderItem', array(
    'inputDefaults' => array(
        'error' => array(
            'attributes' => array(
                'class' => 'alert-input-error',
                'id' => 'msg'
            )
        ),
    ),
    'type' => 'file'
));
?>
<div id="toolbar-menu" class="row">
    <div class="title">ویرایش تصویر</div>
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
// Create best format for this array in select option
if($linkTypes){
    $newArray = array();
    foreach($linkTypes as $linkType){
        $newArray[] = array(
            'name' => $linkType['LinkType']['name'],
            'value' => $linkType['LinkType']['id'],
            'path' => $linkType['LinkType']['path'],
        );
    }
    $linkTypes = $newArray;
    unset($newArray);
}
echo $this->Form->input('link_type_id', array(
    'label' => 'نوع گزینه',
    'id' => 'linkType',
    'options' => $linkTypes,
    'empty' => false,
    )
);
echo $this->Form->input('link', array(
    'label' => 'نشانی اینترنتی',
    'after' => $this->Html->tag('a','انتخاب گزینه',array('class' => 'btn','id' => 'chooseItem')),
));
echo $this->Form->input('title', array('label' => 'عنوان'));
echo $this->Form->input('description', array('label' => 'توضیحات', 'type' => 'textarea'));
echo $this->Form->input('image', array('label' => 'انتخاب تصویر','type' => 'file'));
?>
<div class="input control-group">
    <label class="control-label">منتشر شده</label>
    <div class="controls">
        <label class="btn-group radio inline no-padding">
            <input id="SliderItemPublished1" type="radio" name="data[SliderItem][published]" value="1" <?php if ($this->Form->value('SliderItem.published') == 1) echo 'checked="checked"' ?> />
            <label class="first-child" for="SliderItemPublished1">بله</label>
            <input id="SliderItemPublished0"  type="radio" name="data[SliderItem][published]" value="0" <?php if ($this->Form->value('SliderItem.published') == 0) echo 'checked="checked"' ?> />
            <label for="SliderItemPublished0">خیر</label>
        </label>
    </div>
</div>
<?php
echo $this->Form->end();
?>
<script>
    $(function(){
        var linkType = '';
        var changeLinkStatus = function(){
            linkType = $('#linkType').children(':selected').attr('path')
            // no External, home, seperator
            if(linkType && linkType != '/' && linkType != '#'){
                $('#chooseItem').show()
                $('#SliderItemLink').attr('readonly','readonly')
            }else{
                $('#chooseItem').hide()

                if(! linkType){
                    //is external
                    $('#SliderItemLink').removeAttr('readonly')
                }else{
                    //is home, seperator
                    $('#SliderItemLink').attr('readonly','readonly')
                    $('#SliderItemLink').val(linkType)
                }
            }
        }

        $('#linkType').change(function(){
            $('#SliderItemLink').val('')
            changeLinkStatus()

        })

        $('#linkType').load(function(){
            changeLinkStatus()
        })

        $('#linkType').trigger('load')

        $('#chooseItem').click(function(){
            url = '<?php echo $this->Html->url(array('controller' => '#Controller', 'action' => 'getLinkItem')) ?>/elmID:SliderItemLink';
            url = url.replace(/#Controller/g,linkType)
            $.get(url,function(data){
                $.modal(data,{overlayClose:true,minWidth:500});
            })
        })
    })
</script>