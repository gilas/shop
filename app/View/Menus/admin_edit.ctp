<?php
$this->Validator->addRule(array('Menu' => array('title', 'link')));
$this->Validator->validate(); 
$this->Html->script('modal',false);
$this->Html->css('modal',null,array('inline' => false));
echo $this->Form->create('Menu', array(
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
    )
));
?>
<div id="toolbar-menu" class="row">
    <div class="title">ویرایش گزینه منو</div>
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
$parentsOption = array();
foreach($parents as $parent){
    $char = '';
    for($i =0; $i< $parent['Menu']['level']; $i ++){
        $char .= '- ';
    }
    $parentsOption[] = array(
        'name' => $char . $parent['Menu']['title'],
        'value' => $parent['Menu']['id'],
        'position' => $parent['Menu']['menu_type_id'],
    );
}
$parents = $parentsOption;
unset($parentsOption);

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
echo $this->Form->input('menu_type_id', array(
    'label' => 'موقعیت منو',
    'id' => 'position',
    'value' => @$this->request->named['menu_type_id'] ,
    'empty' => false,
    )
);
echo $this->Form->input('parent_id', array(
    'label' => 'گزینه پدر', 
    'id' => 'parentMenu',
    'options' => $parents,
    )
);
echo $this->Form->input('title', array('label' => 'عنوان'));
echo $this->Form->input('link', array(
    'label' => 'نشانی اینترنتی', 
    'after' => $this->Html->tag('a','انتخاب گزینه',array('class' => 'btn','id' => 'chooseItem','style' => 'display:none')),
    )
);
?>
<div class="input control-group">
    <label class="control-label">منتشر شده</label>
    <div class="controls">
        <label class="btn-group radio inline no-padding">
            <input id="MenuPublished1" type="radio" name="data[Menu][published]" value="1" <?php if ($this->Form->value('Menu.published') == 1) echo 'checked="checked"' ?> />
            <label class="first-child" for="MenuPublished1">بله</label>
            <input id="MenuPublished0"  type="radio" name="data[Menu][published]" value="0" <?php if ($this->Form->value('Menu.published') == 0) echo 'checked="checked"' ?> />
            <label for="MenuPublished0">خیر</label>
        </label>
    </div>
</div>
<?php echo $this->Form->end(); ?>

<script>
    $(function(){
        var linkType = '';
        var changeLinkStatus = function(){
            linkType = $('#linkType').children(':selected').attr('path')
            // no External, home, seperator
            if(linkType && linkType != '/' && linkType != '#'){
                $('#chooseItem').show()
                $('#MenuLink').attr('readonly','readonly')
            }else{
                $('#chooseItem').hide()
                
                if(! linkType){
                    //is external
                    $('#MenuLink').removeAttr('readonly')
                }else{
                    //is home, seperator
                    $('#MenuLink').attr('readonly','readonly')
                    $('#MenuLink').val(linkType)
                }
            }
        }
        
        $('#linkType').change(function(){
            $('#MenuLink').val('')
            changeLinkStatus()
        })
        
        $('#linkType').load(function(){
            changeLinkStatus()
        })
        
        $('#linkType').trigger('load')
        
        $('#chooseItem').click(function(){
            url = '<?php echo $this->Html->url(array('controller' => '#Controller', 'action' => 'getLinkItem')) ?>/elmID:MenuLink';
            url = url.replace(/#Controller/g,linkType)
            $.get(url,function(data){
                $.modal(data,{overlayClose:true,minWidth:500});
            })
        })
        $('#position').change(function(){
            position = $(this).attr('value')
            $('#parentMenu option').each(function(){
                $this = $(this)
                // hide all
                $this.hide().attr('disabled','disabled')
                //show related position
                if($this.attr('position') == position){
                    $this.show().removeAttr('disabled')
                }
                //select empty option
                if($this.val() == 0){
                    $this.attr('selected','selected');
                    $this.show().removeAttr('disabled')
                }
            })
        })
        $('#position').load(function(){
            position = $(this).attr('value')
            $('#parentMenu option').each(function(){
                $this = $(this)
                // hide all
                $this.hide().attr('disabled','disabled')
                //show related position
                if($this.attr('position') == position){
                    $this.show().removeAttr('disabled')
                }
                if($this.val() == 0){
                    $this.show().removeAttr('disabled')
                }
            })
        })
        $('#position').trigger('load')
    })
</script>
