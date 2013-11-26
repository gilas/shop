<h4>خطای پایگاه داده</h4>
<div class="debug">
	<strong class="debug-label">Error: </strong>
    <span class="debug-message">Database Error</span>
    <br />
    <strong class="debug-label">Error Code: </strong>
    <span class="debug-message"><?php echo $error->getCode(); ?></span>
    <?php if(Configure::read('debug') > 1): ?>
    <br />
    <strong class="debug-label">Message: </strong>
    <span class="debug-message"><?php echo $error->getMessage(); ?></span>
    <br />
    <strong class="debug-label">Query: </strong>
    <span class="debug-message"><?php echo $error->queryString; ?></span>
    
    <?php endif; ?>
</div>