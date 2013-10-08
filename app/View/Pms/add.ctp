<?php
$this->Html->script('select', false);
$this->Html->css('select', null, array('inline' => false));
$this->Validator->addRule('Message');
$this->Validator->validate(); 
echo $this->Form->create('Message', array(
    'inputDefaults' => array(
        'error' => array(
            'attributes' => array(
                'class' => 'alert-input-error',
                'id' => 'msg'
            )
        ),
    ),
));
?>
<input id="PmMethod" type="hidden" name="data[Message][method]" />
<div id="toolbar-menu" class="row">
    <div class="title">ارسال پیام</div>
    <ul id="toolbar">
        <li>
            <a onclick="$('#PmMethod').val('send');$(this).parents('form').submit();" class="btn btn-success" tooltip-place="bottom" data-original-title="ارسال" rel="tooltip" >
                <i class="icon-ok icon-white"></i><input name="send" type="submit" style="display: none;" />
            </a>
        </li>
        <li>
            <a onclick="$('#PmMethod').val('save');$(this).parents('form').submit();" class="btn btn-info" tooltip-place="bottom" data-original-title="ذخیره" rel="tooltip" >
                <i class="icon-file icon-white"></i><input name="save" type="submit" style="display: none;" />
            </a>
        </li>
        <li>
            <a href="<?php echo $this->Html->url(array('action' => 'index')); ?>" class="btn btn-danger" tooltip-place="bottom" data-original-title="انصراف" rel="tooltip" >
                <i class="icon-remove icon-white"></i>
            </a>
        </li>
    </ul>
</div>
<div class="input text">
    <label for="MessageRecipients">گیرنده</label>
    <?php
    if(count($users) == 1){
        echo $users[0]['user_name'];
        echo $this->Form->hidden('Message.Recipients.0.user',array('value'=>$users[0]['user_id']));
        echo $this->Form->hidden('Message.Recipients.0.parent_id',array('value'=>$users[0]['parent_id']));
        
    }else{
        $options = '';
        foreach($users as $user){
            $options .= $this->Html->tag('option',$user['user_name'],array('value' => $user['user_id']));
            echo $this->Form->hidden('Message.Recipients.'.$user['user_id'].'.user',array('value'=>$user['user_id']));
            echo $this->Form->hidden('Message.Recipients.'.$user['user_id'].'.parent_id',array('value'=>$user['parent_id']));
        }
        echo $this->Html->tag('select',$options,array('name' => 'data[Message][Recipients][id][0]','style' => 'width:500px', 'id' => 'recipients'));
        echo $this->Form->hidden('Message.isList',array('value'=>true));
    }
    ?>
</div>
<?php
echo $this->Form->input('subject', array('label' => 'عنوان'));
$this->TinyMCE->editor('simple');
echo $this->Form->input('message', array('label' => 'متن', 'class' => 'tinymce'));
echo $this->Form->end();
?>
<script>
    $('#recipients').chosen();
</script>