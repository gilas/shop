<div class="module">
    <div class="module-title">لیست مجموعه ها</div>
    <div class="module-body">
        <?php echo $this->element('category_lists', array(), array('plugin' => 'Shop')); ?>
    </div>
</div>
<div class="module">
    <div class="module-title">سبد خرید</div>
    <div class="module-body">
        <?php echo $this->element('cart', array(), array('plugin' => 'Shop')); ?>
    </div>
</div>
<?php if(AuthComponent::user() == null): ?>
<div class="module">
    <div class="module-title">ورود کاربران</div>
    <div class="module-body">
        <form method="post" action="<?php echo $this->Html->url(array('controller' => 'User', 'action' =>'login', 'plugin' => 'Shop')) ?>">
            <div class="row">
                <div class="span2">
                    <label>نام کاربری</label>
                    <input type="text" name="data[User][username]" style="width: auto;" />
                </div>
                <div class="span2">
                    <label>رمز عبور</label>
                    <input type="password" name="data[User][password]" style="width: auto;" />
                </div>
                <div class="span2">
                    <input type="submit" value="ورود"  />
                    <?php echo $this->Html->link('ثبت نام', array('controller' => 'User', 'action' => 'register', 'plugin' => 'Shop')); ?>
                </div>
            </div>
        </form>
    </div>
</div>
<?php else: ?>
<div class="module">
    <div class="module-title">فروشگاه</div>
    <div class="module-body">
        <?php echo $this->Html->link('فاکتورها', array('controller' => 'Orders', 'action' => 'index', 'plugin' => 'Shop'), array('style' => 'display:block;')); ?>
    </div>
</div>
<div class="module">
    <div class="module-title">اطلاعات کاربری</div>
    <div class="module-body">
        <span style="display: block;"><?php echo AuthComponent::user('name'); ?></span>
        <?php echo $this->Html->link('مشاهده اطلاعات کاربری', array('controller' => 'User', 'action' => 'view', 'plugin' => 'Shop'), array('style' => 'display:block;')); ?>
        <?php echo $this->Html->link('خروج', array('controller' => 'Users', 'action' => 'logout', 'plugin' => false), array('style' => 'display:block;')); ?>
    </div>
</div>
<?php endif; ?>