<?php
if($name == 'Not Found'){
    $name = 'آدرس درخواستی یافت نشد';
}
$title_for_layout = $name;
?>
<h4><?php echo $name; ?></h4>
<div class="debug">
	<strong class="debug-label">Error: </strong>
    <span class="debug-message">404 Not Found</span>
    <div class="clearfix"></div>
	<strong class="debug-label">URL: </strong>
    <span class="debug-message"><?php echo $url; ?></span>
</div>
