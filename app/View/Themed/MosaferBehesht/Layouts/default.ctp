<!DOCTYPE HTML>
<!--[if lt IE 7]><html class="no-js ie6 oldie" lang=en><![endif]--> <!--[if IE 7]><html class="no-js ie7 oldie" lang=en><![endif]--> <!--[if IE 8]><html class="no-js ie8 oldie" lang=en><![endif]--> <!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <html>
        <head>
            <meta charset="UTF-8" />
            <?php
            echo $this->Html->meta('icon');
            echo $this->Html->meta('keywords', SettingsController::read('Site.Keywords'));
            echo $this->Html->meta('description', SettingsController::read('Site.Description'));
            echo $this->fetch('meta');
            echo $this->Html->css('bootstrap.min');
            echo $this->Html->css('bootstrap-responsive.min');
            echo $this->Html->css('template');
            echo $this->Html->css(array('style','menu'));
            echo $this->Html->css('fancybox');
            echo $this->Html->css('box');
            echo $this->fetch('css');
            echo $this->Html->script(array('modernizr', 'jquery', 'jquery-ui',));
            echo $this->Html->script('bootstrap');
            echo $this->Html->script('init');
            echo $this->Html->script('box');
            echo $this->Html->script('fancybox');
            
            ?>
            <!--[if lt IE 9]><?php echo $this->Html->script(array('IE8', 'ie')); ?><![endif]-->
            <?php
            echo $this->Html->script(array('toolbar','tab','checkbox_radio'));
            echo $this->fetch('script');
            ?>
            <title><?php echo $title_for_layout; ?></title>
        </head>
        <body>
            <?php //echo $this->element('voter'); ?>
        	<div id="body" class="container_12">
                <div id="toolbar-header">
                    <div class="right">
                        <?php echo $this->element('profile'); ?>
                        <?php //echo $this->element('messages'); ?>
                    </div>
                    <div class="left">
                        <?php echo Jalali::date('l d F Y'); ?>
                    </div>
                </div>
                <div id="header"></div>
                <div class="user-bar"><?php echo $this->element('firstBar'); ?></div>
                <div id="center">
                    <div id="right-content"><?php echo $this->element('right'); ?></div>
                    <div id="content">
                        <?php echo $this->element('breadcrumb'); ?>
                        <?php echo $this->Session->flash('auth'); ?>
                        <?php echo $this->Session->flash(); ?>
                        <?php echo $this->element('slider'); ?>
                        <?php echo $this->fetch('content'); ?>
                    </div>
                </div>
                <div id="footer"><?php echo $this->element('footer');?></div>
            </div>
        </body>
    </html>
    <?php //echo $this->element('sql_dump'); ?>
<?php //echo $this->element('sql_dump'); ?>
<script>
    $(function(){
        $('.alert.success[static!=true]').animate({
						top: 0
					},8000, function() {
					   $this = $(this);
						$.browser.msie ? $this.css("display", "none") : $this.fadeOut("slow",function(){
						  $this.remove();
						});

					});
        $(".tabbed").each(function(){$(this).createTabs()})
    })
</script>