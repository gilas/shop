<?php
$this->Html->css('gallery',null,array('inline' => false));
$items = array();
foreach ($galleryCategories as $galleryCategory) {
    if(!empty($galleryCategory['GalleryItem'])){
    	$items[] = $this->Html->link(
    	    $this->Html->tag(
    	           'span',
    	           $this->Upload->image($galleryCategory, 'GalleryItem.image', array('style' => 'thumb')),
    	           array('class' => 'stack twisted')
            ).
            $this->Html->tag('label',$galleryCategory['GalleryCategory']['name'].' ('.$galleryCategory['count'].')',array('class' => 'caption')),
            array('controller' => 'galleryItems','action' => 'getItems', $galleryCategory['GalleryCategory']['id']),
            array('escape' => false)
        );
    }
}
echo $this->Html->nestedList($items, array('class' => 'gallery'));
?>