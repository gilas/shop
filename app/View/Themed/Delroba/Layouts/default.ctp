<!DOCTYPE HTML>
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
        echo $this->Html->css(array('main','purple', 'mosaic1'));
        echo $this->Html->css('fancybox');
        echo $this->Html->css('box');
        echo $this->fetch('css');
        echo $this->Html->script(array('modernizr', 'jquery', 'jquery-ui',));
        echo $this->Html->script('bootstrap');
        echo $this->Html->script('init');
        echo $this->Html->script('box');
        echo $this->Html->script('fancybox');
        
        ?>
        <!--[if IE 7]><?php echo $this->Html->css('ie7'); ?><![endif]-->
        <?php
        echo $this->Html->script(array('jquery.metadata','jquery.easing.1.3','jquery.cycle.min', 'main', 'comment-reply'));
        echo $this->fetch('script');
        ?>
        <title><?php echo $title_for_layout; ?></title>
    </head>
    <body class="home page page-id-27 page-child parent-pageid-25 page-template page-template-home-coin-slider-php">
        <div id="metadata" class="metadata { general_enable_font_replacement: '1',home_cycle_timeout: '4000',home_cycle_speed: '1000',home_cycle_pause: '1',portfolio_enable_delay: '1' }"></div>

        <div id="page">
        	<div id="header">
                <?php echo $this->element('logo'); ?>
                <?php echo $this->element('menu'); ?>
                <?php echo $this->element('feeds'); ?>				
        	</div><!-- END: #header -->
        
        	<div id="content">		
                <div class="hd">
             		<div class="grid">
                        <?php echo $this->element('header'); ?>	
            		</div>		
            	</div>
        	<div class="bd">
                <div class="grid">
                    <div class="c-4 sidebar"><?php echo $this->element('right'); ?></div>	
                    <div class="c-8">
                        <?php echo $this->Session->flash('auth'); ?>
                        <?php echo $this->Session->flash(); ?>
                        <?php echo $this->fetch('content'); ?>                    
                    </div>		
                </div>
        	</div>
        
  		    <div class="ft special">
        		<div class="shadow"></div>
        		<div class="wrapper">
                    <?php echo $this->Filter->limitAndPaginate();  ?>
        			<div style="clear: both;">&nbsp;</div>		
                </div>
                
        		<div class="helper1"></div>
                
        	</div>	
        	</div><!-- END: #content -->
        	<div id="footer">	
                <?php //echo $this->element('footer'); ?>				
        	</div><!-- END: #footer -->
        </div><!-- END: #page -->
    </body>
</html>
<?php //echo $this->element('sql_dump'); ?>