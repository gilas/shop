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
        <?php
        $newRequests = null;
        $count = $this->requestAction(array('controller' => 'Requests', 'action' => 'getCountRequest','status' => 0, 'admin' => false, 'plugin' => 'Req'));
        if($count){
            $newRequests =  $this->Html->tag('span', $count, array('class' => 'count'));
        }
        ?>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown">درخواست ها <?php echo $newRequests ?></a>
            <ul class="dropdown-menu">
                <li><?php echo $this->Html->link('درخواست ها', array('controller' => 'Requests', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'Req'), array('escape' => false)); ?></li>
                <li><?php echo $this->Html->link('واحدهای اقامتی', array('controller' => 'Places', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'Req')); ?></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown">واحد مالی</a>
            <ul class="dropdown-menu">
                <li><?php echo $this->Html->link('مشتریان', array('controller' => 'Customers', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'Fin')); ?></li>
                <li><?php echo $this->Html->link('تراکنش ها', array('controller' => 'FinPayments', 'action' => 'index', 'admin' => TRUE, 'plugin' => 'Fin')); ?></li>
            </ul>
        </li>
    </ul>
</div><!--/.nav-collapse -->