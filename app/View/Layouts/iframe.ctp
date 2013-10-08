<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php
            echo 'مدیریت وبسایت';
            echo ' - ';
            echo $title_for_layout;
            ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('bootstrap.min');
        echo $this->Html->css('bootstrap-responsive.min');
        echo $this->Html->css('template');
        echo $this->Html->css('box');
        echo $this->Html->script('jquery');
        echo $this->Html->script('bootstrap');
        echo $this->Html->script('init');
        echo $this->Html->script('box');
        
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body style="padding-top: 0;">
        <div class="container">
            <div id="top">
                <div id="flash_message"><?php echo $this->Session->flash('auth'); ?></div>
                <div id="flash_message"><?php echo $this->Session->flash('flash', array('element' => 'message')); ?></div>
            </div>
            <div id="content"><?php echo $this->fetch('content'); ?></div>
        </div>
    </body>
</html>