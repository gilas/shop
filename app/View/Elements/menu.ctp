<button data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar" type="button">
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
</button> 
<div class="nav-collapse collapse">
    <ul class="nav">
        <?php
          $newMessage = null;
          $count = $this->requestAction(array('controller' => 'Pms', 'action' => 'countNewMessages', 'admin' => false, 'plugin' => false));
          if($count){
              $newMessage = $this->Html->tag('span', $count, array('class' => 'count'));
          }
        ?>
        <li><?php echo $this->Html->link('پیام نگار'.$newMessage, array('controller' => 'Pms','plugin' => false, 'action' => 'index', 'admin' => true), array('escape' => false)); ?></li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown">کالا </a>
            <ul class="dropdown-menu">
                <li><?php echo $this->Html->link('مجموعه', array('controller' => 'Categories', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'Shop'), array('escape' => false)); ?></li>
                <li><?php echo $this->Html->link('کالا', array('controller' => 'Stuffs', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'Shop'), array('escape' => false)); ?></li>
            </ul>
        </li>
        <li class="dropdown">
            <?php
              $newOrders = null;
              $count = $this->requestAction(array('controller' => 'Orders', 'action' => 'getSellOrders', 'admin' => true, 'plugin' => 'Shop', 'status' => 0, 'type' => 'count'));
              if($count){
                  $newOrders = $this->Html->tag('span', $count, array('class' => 'count'));
              }
            ?>
            <a class="dropdown-toggle" data-toggle="dropdown">سفارشات <?php echo $newOrders; ?></a>
            <ul class="dropdown-menu">
                <li><?php echo $this->Html->link('سفارش خرید', array('controller' => 'Orders', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'Shop', 'type' => 1), array('escape' => false)); ?></li>
                
                <li><?php echo $this->Html->link('سفارش فروش', array('controller' => 'Orders', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'Shop', 'type' => 2), array('escape' => false)); ?></li>
            </ul>
        </li>
        <li><?php echo $this->Html->link('مالیات', array('controller' => 'Taxes', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'Shop'), array('escape' => false)); ?></li>
        <li><?php echo $this->Html->link('روش ارسال کالا', array('controller' => 'Deports', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'Shop'), array('escape' => false)); ?></li>
        <li><?php echo $this->Html->link('کوپن تخفیف', array('controller' => 'Coupons', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'Shop'), array('escape' => false)); ?></li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown">مدیریت مشتریان</a>
            <ul class="dropdown-menu">
                <li><?php echo $this->Html->link('گروه مشتریان', array('controller' => 'Groups', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'Shop'), array('escape' => false)); ?></li>
                <li><?php echo $this->Html->link('مشتریان', array('controller' => 'User', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'Shop'), array('escape' => false)); ?></li>
            </ul>
        </li>
    </ul>
</div><!--/.nav-collapse -->