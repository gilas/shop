<?php
if( $this->Session->check('Auth.User')):
?>
<div class="toolbar_small"> 
    <div class="toolbutton"> 
    <?php if($countNewMessage) echo $html->tag('span',$countNewMessage) ?>
        <img width="16" height="16" alt="mail" src="<?php echo $html->url('/img/new/icons/mail.png') ?>"/> 
    </div> 
    <div class="toolbox" style="display: none; "> 
        <span class="arrow"></span> 
        <h3>پیام های خوانده نشده</h3> 
        <?php if(!empty($recentlyMessages)): ?>
        <ul class="mail"> 
            <?php  foreach($recentlyMessages as $msg):?>
            <li <?php if(! $msg['Reader']['new']) echo 'class="read"' ?>> 
                <a href="<?php echo $html->url(array('controller' => 'pm','action'=>'read',$msg['Reader']['id'])) ?>"> 
                    <strong><?php echo $msg['Message']['subject'] ?></strong>
                    <small> از طرف :  <?php echo @$msg['Sender']['full_name'] ?></small>
                    <small class="time"><?php echo $jalali->niceShort($msg['Message']['created']); ?></small> 
                </a> 
            </li>
            <?php endforeach; ?>  
        </ul>
        <?php else: echo 'هیچ پیامی دریافت نشده است'; endif; ?> 
        <a href="<?php echo $html->url(array('controller' => 'pm','action'=>'inbox')); ?>" class="inbox">صندوق ورودی »</a> 
    </div> 
</div> 

<?php
endif;
?>