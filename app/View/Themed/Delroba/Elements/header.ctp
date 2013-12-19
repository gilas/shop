<div class="c-8">
    <h2 style="color: #FFFFFF;"><?php echo SettingsController::read('Site.Name'); ?></h2>
    <?php echo $this->element('breadcrumb'); ?>
</div>
<div class="c-4">
    <form method="get" id="searchform" action="">
        <fieldset>
            <input name="s" id="s" size="15" type="text"/>        
            <input src="<?php echo $this->Html->url('/theme/Delroba/img/submit-search.png'); ?>" value="Search" id="searchsubmit" type="image"/>
        </fieldset>
    </form>
</div>