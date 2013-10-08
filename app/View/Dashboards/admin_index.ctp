<div class="page-header">
    <h1>درخواست</h1>
</div>
<div class="row">
    <div class="span2 well" style="padding: 4px;">
        <?php echo $this->Html->image('icon-pack/48x48/File.png'); ?>
        <?php echo $this->Html->link('درخواست ها', array('controller' => 'Requests', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'Req')); ?>
        <?php
        $count = $this->requestAction(array('controller' => 'Requests', 'action' => 'getCountRequest','status' => 0, 'admin' => false, 'plugin' => 'Req'));
        if($count){
            echo $this->Html->link($count,  array('controller' => 'Requests', 'action' => 'index','status' => 0, 'admin' => TRUE, 'plugin' => 'Req'), array('class' => 'count') );
        }
        ?>
    </div>
    <div class="span2 well" style="padding: 4px;">
        <?php echo $this->Html->image('icon-pack/48x48/File.png'); ?>
        <?php echo $this->Html->link('واحدهای اقامتی', array('controller' => 'Places', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'Req')); ?>
    </div>
</div>
<div class="page-header">
    <h1>واحد مالی</h1>
</div>
<div class="row">
    <div class="span2 well" style="padding: 4px;">
        <?php echo $this->Html->image('icon-pack/48x48/Users.png'); ?>
        <?php echo $this->Html->link('مشتریان', array('controller' => 'Customers', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'Fin')); ?>
    </div>
        <div class="span2 well" style="padding: 4px;">
        <?php echo $this->Html->image('icon-pack/48x48/File.png'); ?>
        <?php echo $this->Html->link('تراکنش ها', array('controller' => 'FinPayments', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'Fin')); ?>
    </div>
</div>