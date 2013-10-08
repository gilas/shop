<?php
$this->Html->script('select', false);
$this->Html->css('select', null, array('inline' => false));
?>
<div class="pm-box <?php if(!empty($conversations)) echo 'pm-summary' ?>">
    <div class="pm-header">
        <div class="pm-subject">
            <?php echo $message['Message']['subject'] ?>
        </div>
        <div class="pm-date"><?php echo Jalali::niceShort($message['Message']['created']); ?></div>
        <div class="pm-sender">
            <?php echo $message['Message']['Sender']['SenderInfo']['name']; ?>
            <span class="pm-info dropdown">
                <b class="caret dropdown-toggle" data-toggle="dropdown"></b>
                <div class="dropdown-menu">
                    <div>
                        <label>فرستنده</label>
                        <span><?php echo $message['Message']['Sender']['SenderInfo']['name']; ?></span>
                    </div>
                    <div>
                        <label>گیرنده</label>
                        <span><?php 
                        $recipients = array();
                        foreach($message['Message']['Recipients'] as $recipient){
                            $recipients[] =  $recipient['Recipient']['name'];
                        }
                        echo  String::truncate(implode(', ',$recipients), 30);
                        ?></span>
                    </div>
                    <div>
                        <label>تاریخ ارسال</label>
                        <span><?php echo Jalali::niceShort($message['Message']['created']); ?></span>
                    </div>
                  </div>
            </span>
        </div>
    </div>
    <div class="pm-message"><?php echo $message['Message']['message']; ?></div>
    <div class="pm-attach"><?php         
        if($message['Message']['files']){
            $message['Message']['files'] = unserialize($message['Message']['files']);
            echo 'ضمیمه :'. $this->Html->link($message['Message']['files']['name'],'/pm/download/'.$message['Reader']['id']);
        } 
    ?></div>
</div>
<?php if(!empty($conversations)): ?>
    <?php $i = count($conversations); // show every pm before end as summary ?>
    <?php foreach($conversations as $conversation): ?>
    <?php $i--; ?>
    <div class="pm-box  <?php if($i != 0) echo 'pm-summary' ?>">
        <div class="pm-header">
            <div class="pm-subject">
                <?php echo $conversation['Message']['subject'] ?>
            </div>
            <div class="pm-date"><?php echo Jalali::niceShort($conversation['Message']['created']); ?></div>
            <div class="pm-sender">
                <?php echo $conversation['Message']['Sender']['SenderInfo']['name']; ?>
                <span class="pm-info dropdown">
                    <b class="caret dropdown-toggle" data-toggle="dropdown"></b>
                    <div class="dropdown-menu">
                        <div>
                            <label>فرستنده</label>
                            <span><?php echo $conversation['Message']['Sender']['SenderInfo']['name']; ?></span>
                        </div>
                        <div>
                            <label>گیرنده</label>
                            <span><?php 
                            $recipients = array();
                            foreach($conversation['Message']['Recipients'] as $recipient){
                                $recipients[] =  $recipient['Recipient']['name'];
                            }
                            echo  String::truncate(implode(', ',$recipients), 30);
                            ?></span>
                        </div>
                        <div>
                            <label>تاریخ ارسال</label>
                            <span><?php echo Jalali::niceShort($conversation['Message']['created']); ?></span>
                        </div>
                      </div>
                </span>
            </div>
        </div>
        <div class="pm-message"><?php echo $conversation['Message']['message']; ?></div>
        <div class="pm-attach"><?php         
            if($conversation['Message']['files']){
                $conversation['Message']['files'] = unserialize($conversation['Message']['files']);
                echo 'ضمیمه :'. $this->Html->link($conversation['Message']['files']['name'],'/pm/download/'.$conversation['Reader']['id']);
            } 
        ?></div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>
<div class="tabs-1 widget">
    <ul class="tabs">
        <li class="active"><a href="#reply" data-toggle="tab">پاسخ</a></li>
    </ul>
	<div class="tab_container">
		<div id="reply" class="tab_content">
            <?php
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
            echo $this->Form->hidden('Message.parent_id',array('value'=>$message['Reader']['id']));
            echo $this->Form->input('subject', array('label' => 'عنوان'));
            $this->TinyMCE->editor('simple');
            echo $this->Form->input('message', array('label' => 'متن', 'class' => 'tinymce'));
            echo $this->Form->end();
            ?>
        </div>
	</div>
</div>
<script>
    $(function(){
        $('.pm-summary').click(function(){
            $(this).removeClass('pm-summary');
        })
    })
    $('#recipients').chosen();
</script>