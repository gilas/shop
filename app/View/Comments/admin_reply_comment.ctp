<?php //debug($this->request); ?>
<div class="alert alert-info fade in" id="msg">
    <a data-dismiss="alert" class="close">&times;</a>
    <strong><?php echo $comment['Comment']['name']; ?> : </strong>
    <?php echo $comment['Comment']['content']; ?>
</div>

<?php
echo $this->Form->create('Comment');
echo $this->Form->input('content', array('label' => 'متن پاسخ'));
?>
<input type="submit" value="ذخیره" class="btn btn-success" />
<?php
echo $this->Form->end();
?>
