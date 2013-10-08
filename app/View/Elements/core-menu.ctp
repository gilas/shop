<ul class="nav">
    <li class="dropdown">
        <a class="dropdown-toggle brand" data-toggle="dropdown" href="#">
            <?php echo $this->Html->image('logo-small.png'); ?>
        </a>
        <ul class="dropdown-menu">
            <li><?php echo $this->Html->link('داشبورد', array('controller' => 'dashboards','plugin' => false, 'action' => 'index', 'admin' => TRUE)); ?></li>
            <li><?php echo $this->Html->link('تنظیمات', array('controller' => 'settings','plugin' => false, 'action' => 'index', 'admin' => TRUE)); ?></li>
            <li class="divider"></li>
            <li class="dropdown-submenu">
                <a class="dropdown-toggle" data-toggle="dropdown">کاربران</a>
                <ul class="dropdown-menu">
                    <li class="dropdown-submenu">
                        <?php echo $this->Html->link('مدیریت کاربران', array('controller' => 'Users','plugin' => false, 'action' => 'index', 'admin' => TRUE)); ?>
                        <ul class="dropdown-menu">
                            <li><?php echo $this->Html->link('ایجاد کاربر', array('controller' => 'Users','plugin' => false, 'action' => 'add', 'admin' => TRUE)); ?></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <?php echo $this->Html->link('مدیریت نقش ها', array('controller' => 'Roles','plugin' => false, 'action' => 'index', 'admin' => TRUE)); ?>
                        <ul class="dropdown-menu">
                            <li><?php echo $this->Html->link('ایجاد نقش', array('controller' => 'Roles','plugin' => false, 'action' => 'add', 'admin' => TRUE)); ?></li>
                        </ul>
                    </li>
                    <li class="divider"></li>
                    <li><?php echo $this->Html->link('سطح دسترسی', array('controller' => 'AclPermissions','plugin' => false, 'action' => 'index', 'admin' => TRUE)); ?></li>
                </ul>
            </li>
            <li class="dropdown-submenu">
                <a class="dropdown-toggle" data-toggle="dropdown">مطالب</a>
                <ul class="dropdown-menu">
                    <li class="dropdown-submenu">
                        <?php echo $this->Html->link('مدیریت مطالب', array('controller' => 'Contents','plugin' => false, 'action' => 'index', 'admin' => TRUE)); ?>
                        <ul class="dropdown-menu">
                            <li><?php echo $this->Html->link('ایجاد مطلب', array('controller' => 'Contents','plugin' => false, 'action' => 'add', 'admin' => TRUE)); ?></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <?php echo $this->Html->link('مدیریت مجموعه مطالب', array('controller' => 'content_categories','plugin' => false, 'action' => 'index', 'admin' => TRUE), array('class' => 'active')); ?>
                        <ul class="dropdown-menu">
                            <li><?php echo $this->Html->link('ایجاد مجموعه', array('controller' => 'content_categories','plugin' => false, 'action' => 'add', 'admin' => TRUE), array('class' => 'active')); ?></li>
                        </ul>
                    </li>
                    <li><?php echo $this->Html->link('نظرات', array('controller' => 'comments','plugin' => false, 'action' => 'index', 'admin' => TRUE)); ?></li>
                </ul>
            </li>
            <li class="dropdown-submenu">
                <a class="dropdown-toggle" data-toggle="dropdown">منو</a>
                <ul class="dropdown-menu">                    
                    <li class="dropdown-submenu">
                        <?php echo $this->Html->link('مدیریت منو', array('controller' => 'menus','plugin' => false, 'action' => 'index', 'admin' => TRUE)); ?>
                        <ul class="dropdown-menu">
                            <li><?php echo $this->Html->link('ایجاد آیتم منو', array('controller' => 'menus','plugin' => false, 'action' => 'add', 'admin' => TRUE), array('class' => 'active')); ?></li>
                        </ul>
                    </li>
                    <li class="divider"></li>
                    <li class="dropdown-submenu">
                        <?php echo $this->Html->link('مدیریت نوع منو', array('controller' => 'MenuTypes','plugin' => false, 'action' => 'index', 'admin' => TRUE)); ?>
                        <ul class="dropdown-menu">
                            <li><?php echo $this->Html->link('ایجاد نوع منو', array('controller' => 'MenuTypes','plugin' => false, 'action' => 'add', 'admin' => TRUE)); ?></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="dropdown-submenu">
                <a class="dropdown-toggle" data-toggle="dropdown">تصاویر</a>
                <ul class="dropdown-menu">
                    <li class="dropdown-submenu">
                        <?php echo $this->Html->link('مدیریت تصاویر', array('controller' => 'GalleryItems','plugin' => false, 'action' => 'index', 'admin' => TRUE), array('class' => 'active')); ?>
                        <ul class="dropdown-menu">
                            <li><?php echo $this->Html->link('ایجاد تصویر', array('controller' => 'GalleryItems','plugin' => false, 'action' => 'add', 'admin' => TRUE), array('class' => 'active')); ?></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <?php echo $this->Html->link('مدیریت گالری تصاویر', array('controller' => 'gallery_categories','plugin' => false, 'action' => 'index', 'admin' => TRUE), array('class' => 'active')); ?>
                        <ul class="dropdown-menu">
                            <li><?php echo $this->Html->link('ایجاد گالری تصاویر', array('controller' => 'gallery_categories','plugin' => false, 'action' => 'add', 'admin' => TRUE), array('class' => 'active')); ?></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><?php echo $this->Html->link('اسلایدر', array('controller' => 'SliderItems','plugin' => false, 'action' => 'index', 'admin' => TRUE)); ?></li>
            <li><?php echo $this->Html->link('تماس ها', array('controller' => 'contact_details','plugin' => false, 'action' => 'index', 'admin' => TRUE)); ?></li>
        </ul>
    </li>
</ul>