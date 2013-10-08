<?php
if(isset($categories)){
    $lastCategory = array_pop($categories);
    foreach($categories as $category){
        $this->Html->addCrumb($category['ContentCategory']['name'],array(
            'controller' => 'Contents',
            'action' => 'category',
            $category['ContentCategory']['id'].'-'.$category['ContentCategory']['name'],
        ));
    }
    $this->Html->addCrumb($lastCategory['ContentCategory']['name']);
}
if(empty($contents)){
    echo 'هیچ مطلبی یافت نشد';
    return;
}
foreach($contents as $content):
?>
<div class="clearfix">
    <div class="title-with-icon clearfix">
        <a href="<?php echo $this->Html->url(array('action' => 'view',$content['Content']['id'].'-'.$content['Content']['slug'])) ?>"><h5><?php echo $content['Content']['title']; ?></h5></a>
        <span class="article-meta"><?php echo Jalali::niceShort($content['Content']['created']); ?></span>
    </div>
    
    <p><?php echo $content['Content']['intro']; ?></p>
    <?php if(!empty($content['Content']['content'])): ?>
    <div class="alignleft">
        <a class="button green small" href="<?php echo  $this->Html->url(array('action' => 'view',$content['Content']['id'].'-'.$content['Content']['slug'])) ?>">ادامه مطلب</a>
    </div>
    <?php endif;?>
</div>
<?php endforeach;?>
<div class="content-divider"></div>

<?php 
$url = $this->Filter->getParam();
// set to past action, so we can paginate link to it
$url['action'] = $pastAction;
$this->Paginator->options(array(
    'url' => $url,
));

?>
<div class="pagenavi">
	<span class="pages"><?php echo $this->Paginator->counter('صفحه {:page} از {:pages}') ?></span>
    <?php echo $this->Paginator->numbers(array('class' => 'page','separator' => ' ')); ?>
</div>
