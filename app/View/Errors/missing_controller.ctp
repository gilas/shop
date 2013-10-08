<h4>عدم تعریف کنترلر <?php echo $class ?></h4>
<div class="debug">
	<strong class="debug-label">Error: </strong>
    <span class="debug-message"><strong><?php echo $class ?></strong> could not be found.</span>
    <div class="clearfix"></div>
	<strong class="debug-label">File: </strong>
    <span class="debug-message"><?php echo APP_DIR . DS . 'Controller' . DS . $class . '.php'; ?></span>
</div>