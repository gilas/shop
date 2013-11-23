<div class="module">
    <div class="module-title">لیست مجموعه ها</div>
    <?php echo $this->element('category_lists', array(), array('plugin' => 'Shop')); ?>
</div>
<div class="module">
    <div class="module-title">سبد خرید</div>
    <?php echo $this->element('cart', array(), array('plugin' => 'Shop')); ?>
</div>