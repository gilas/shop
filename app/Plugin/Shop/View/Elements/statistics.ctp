<?php
$orderStats = $this->requestAction(array('controller' => 'Orders', 'action' => 'getStatistics', 'plugin' => 'Shop'));
$userStats = $this->requestAction(array('controller' => 'User', 'action' => 'getStatistics', 'plugin' => 'Shop'));
?>
<div class="row">
    <div class="span3 box">
        <div class="box-header"><h2>سفارشات</h2></div>
        <div class="box-body">
            <div class="box-item">
                <span>تعداد سفارش های تایید نشده</span>
                <i><?php echo $this->Html->link($orderStats['newOrders'] . ' سفارش', array('controller' => 'Orders', 'action' => 'index', 'plugin' => 'Shop', 'type' => 2, 'status' => 1)); ?></i>
            </div>
            <div class="box-item">
                <span>بیشترین کالای فروش یافته</span><i><a><?php echo $orderStats['favoriteStuff']['name'] . ' (' .$orderStats['favoriteStuff']['count'].' مورد)'; ?></a></i>
            </div>
            <div class="box-item">
                <span>تعداد سفارش های امروز</span><i><?php echo $this->Html->link($orderStats['todayOrders'] . ' سفارش', array('controller' => 'Orders', 'action' => 'index', 'plugin' => 'Shop', 'type' => 2, 'status' => 1, 'date' => Jalali::date('Y-m-d'))); ?></i>
            </div>
            
        </div>
        <div class="box-footer"></div>
    </div>
    <div class="span3 box">
        <div class="box-header"><h2>سفارش های جدید</h2></div>
        <div class="box-body">
            <div class="box-item head">
                <span>شماره سفارش</span><i>مبلغ سفارش</i>
            </div>
            <?php if(!empty($orderStats['newestFactors'])): ?>
                <?php foreach($orderStats['newestFactors'] as $newFactor): ?>
                <div class="box-item">
                    <span><?php echo $this->Html->link($newFactor['FactorHead']['number'], array('controller' => 'Orders', 'action' => 'details', 'plugin' => 'Shop',  $newFactor['FactorHead']['id'])) ?></span>
                    <i><?php echo $this->Html->price($newFactor['FactorHead']['final_price']); ?></i>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="box-item">
                    <span>سفارشی یافت نشد</span>
                </div>
            <?php endif; ?>
        </div>
        <div class="box-footer"><?php echo $this->Html->link('بیشتر', array('controller' => 'Orders', 'action' => 'index', 'plugin' => 'Shop', 'type' => 2, 'status' => 0)); ?></div>
    </div>
</div>
<div class="row">
    <div class="span3 box">
        <div class="box-header"><h2>کاربران جدید</h2></div>
        <div class="box-body">
            <div class="box-item head">
                <span>نام کاربر</span><i>تاریخ عضویت</i>
            </div>
            <?php if(!empty($userStats['newUsers'])): ?>
                <?php foreach($userStats['newUsers'] as $newUser): ?>
                <div class="box-item">
                    <span><?php echo $this->Html->link($newUser['User']['name'], array('controller' => 'User', 'action' => 'details', 'plugin' => 'Shop',  $newUser['ShopUser']['id'])) ?></span>
                    <i><?php echo Jalali::niceShort($newUser['User']['registered_date']); ?></i>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="box-item">
                    <span>کاربری یافت نشد</span>
                </div>
            <?php endif; ?>
        </div>
        <div class="box-footer"><?php echo $this->Html->link('بیشتر', array('controller' => 'User', 'action' => 'index', 'plugin' => 'Shop')); ?></div>
    </div>
</div>