<?php
$this->Html->script('fancybox', false);
$this->Html->css('fancybox', null, array('inline' => false));
?>
<div class="grid-wrapper">
    <ul class="gallery">
<?php foreach($images as $image): ?>
        <li><?php 
            echo $this->Html->link(
                $this->Upload->image($image, 'GalleryItem.image',array('style' => 'thumb')),
                $this->Upload->url($image, 'GalleryItem.image', array('urlize' => false)),
                array('escape' => false,'class' => 'fancybox', 'data-fancybox-group' => $image['GalleryCategory']['name'],'title' => $image['GalleryItem']['description'])
            );
        ?></li>
<?php endforeach; ?>
    </ul>
</div>
<script>
    $(function(){
        $('.fancybox').fancybox();
    })
</script>