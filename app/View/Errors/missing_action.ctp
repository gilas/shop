<h4>عدم تعریف متد ()<?php echo $action ?> در کنترلر <?php echo $controller ?></h4>
<div class="debug">
	<strong class="debug-label">Error: </strong>
    <span class="debug-message">The action <strong><?php echo $controller ?>::<?php echo $action ?>()</strong> is not defined in controller <?php echo $controller ?></span>
    <div class="clearfix"></div>
	<strong class="debug-label">File: </strong>
    <span class="debug-message"><?php echo APP_DIR . DS . 'Controller' . DS . $controller . '.php'; ?></span>
</div>