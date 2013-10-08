<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('back-end/bootstrap/bootstrap-rtl.min');
        echo $this->Html->css('back-end/bootstrap/bootstrap-responsive-rtl.min');
        echo $this->Html->css('back-end/bootstrap/comment');
        echo $this->Html->script('jquery');
        echo $this->Html->script('back-end/bootstrap/bootstrap');


        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body>
        <div class="comment-container">
            <div id="top">
                <div id="msg"><?php echo $this->Session->flash(); ?></div>
            </div>
            <div id="content"><?php echo $this->fetch('content'); ?></div>
        </div>
    </body>
</html>