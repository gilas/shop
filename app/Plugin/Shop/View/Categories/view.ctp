<?php
$category = array_pop($categoryParents);
if(!empty($categoryParents)){
    foreach($categoryParents as $parent){
        $this->Html->addCrumb($parent['Category']['name'], array('controller' => 'Categories', 'action' => 'view', $parent['Category']['id']));
    }
}
$this->Html->addCrumb($category['Category']['name']);
?>
<?php if(!empty($categoryChildren)): ?>
<h2 class="page-header">زیر مجموعه ها</h2>
<div class="categories">
    <?php
    foreach($categoryChildren as $child){
        echo $this->Html->link($child['Category']['name'], array('action' => 'view', $child['Category']['id']), array('class' => 'category'));
    }
    ?>
</div>
<?php endif; ?>

<h2 class="page-header">کالا های مرتبط</h2>
<?php
if(empty($stuffs)){
    echo 'هیچ کالایی یافت نشد';
    return;
}
?>
<div class="stuffs">
    <?php foreach($stuffs as $stuff): ?>
        <?php  echo $this->Html->link($stuff['Stuff']['name'], array('controller' => 'Stuffs', 'action' => 'view', $stuff['Stuff']['id']), array('class' => 'stuff')); ?>
    <?php endforeach; ?>
</div>