<?php
if(SettingsController::read('Content.show_category_in_breadcrumb')){
	if(! empty($categories)){
		foreach ($categories as $category) {
		    $this->Html->addCrumb($category['ContentCategory']['name'], array(
		        'controller' => 'Contents',
		        'action' => 'category',
		        $category['ContentCategory']['id'] . '-' . $category['ContentCategory']['name'],
		    ));
		}
	}
}

$this->Html->addCrumb($content['Content']['title']);
$this->set('title_for_layout',$content['Content']['title']);
?>
<div class="box">
    <div class="header">
        <a href="<?php echo $this->Html->url(array('action' => 'view',$content['Content']['id'].'-'.$content['Content']['slug'])) ?>"><h3><?php echo $content['Content']['title']; ?></h3></a>
        <span class="article-meta"><?php echo Jalali::niceShort($content['Content']['created']); ?></span>
    </div>
    <div class="content">
        <p><?php echo $content['Content']['intro'] . $content['Content']['content']; ?></p>
    </div>
</div>
<?php if (!empty($comments)): ?>
<h5 class="caption">نظرات</h5>
    <div id="comments">
        <?php foreach ($comments as $comment): ?>
            <blockquote  id="comment-<?php echo $comment['Comment']['id'] ?>">
                <?php echo $comment['Comment']['content'] ?>
            </blockquote>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


<?php if ($content['Content']['allow_comment']): ?>
<h5 class="caption">ارسال نظر</h5>
    <div id="commentform">
        <?php
        echo $this->Form->create('Comment');
        echo $this->Form->input('name', array('label' => 'نام'));
        echo $this->Form->input('email', array('label' => 'پست الکترونیک'));
        echo $this->Form->input('website', array('label' => 'وبسایت'));
        echo $this->Form->input('content', array('label' => 'متن'));
        echo $this->Form->end('ارسال');
        ?>
    </div>
<?php endif; ?>