<?php
echo $this->Form->create('Comment');
echo $this->Form->input('name', array('label' => 'نام'));
echo $this->Form->input('email', array('label' => 'پست الکترونیک'));
echo $this->Form->input('website', array('label' => 'وبسایت'));
$this->TinyMCE->editor('simple');
echo $this->Form->input('content', array('label' => 'متن', 'class' => 'tinymce'));
?>
<br/>
<input type="submit" value="ذخیره" class="btn btn-success" />
<?php
echo $this->Form->end();
?>
<div class="alert alert-info" id="msg">
    <strong>ارسال شده </strong>
    در  
    <?php echo Jalali::niceShort($this->request->data['Comment']['created']); ?>
</div>