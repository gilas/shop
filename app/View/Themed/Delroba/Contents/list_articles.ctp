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
<div class="box">
    <div class="header">
        <a href="<?php echo $this->Html->url(array('action' => 'view',$content['Content']['id'].'-'.$content['Content']['slug'])) ?>"><h3><?php echo $content['Content']['title']; ?></h3></a>
        <span class="article-meta"><?php echo Jalali::niceShort($content['Content']['created']); ?></span>
    </div>
    <div class="content">
        <p><?php echo $content['Content']['intro']; ?></p>
        <?php if(!empty($content['Content']['content'])): ?>
        <div class="read-more">
            <a class="btn" href="<?php echo  $this->Html->url(array('action' => 'view',$content['Content']['id'].'-'.$content['Content']['slug'])) ?>">ادامه مطلب</a>
        </div>
        <?php endif;?>
    </div>
</div>
<?php endforeach;?>

<?php 
$url = $this->Filter->getParam();
// set to past action, so we can paginate link to it
$url['action'] = $pastAction;
$this->Paginator->options(array(
    'url' => $url,
));

?>
<div class="pagination">
    <?php echo $this->Filter->paginator(array('url' => $url)); ?>
</div>
