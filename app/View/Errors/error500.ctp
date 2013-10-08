<?php
if($name == 'An Internal Error Has Occurred.'){
    $name = 'خطای داخلی';
}
$title_for_layout = $name;
?>
<h4><?php echo $name; ?></h4>
<div class="debug">
	<strong class="debug-label">Error: </strong>
    <span class="debug-message">Internal Server Error</span>
    <?php echo $this->element('exception_stack_trace'); ?>
</div>
