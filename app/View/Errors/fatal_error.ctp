<h4>خطای سیستمی</h4>
<div class="debug">
	<strong class="debug-label">Error: </strong>
    <span class="debug-message"><?php echo h($error->getMessage()); ?></span>
    <div class="clearfix"></div>
	<strong class="debug-label">File: </strong>
    <span class="debug-message"><?php echo h($error->getFile()); ?></span>
    <div class="clearfix"></div>
	<strong class="debug-label">Line: </strong>
    <span class="debug-message"><?php echo h($error->getLine()); ?></span>
    <?php echo $this->element('exception_stack_trace'); ?>
</div>
