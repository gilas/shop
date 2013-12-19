<?php
$this->Html->addCrumb('لیست اعضا',array('controller' => 'Certificates','action' => 'index'));
$this->Html->addCrumb('درباره اعضا');
?>
<div class="profile-logo">
    <?php echo $this->Html->image('profile/logo/logo.png', array('style' => 'width:100px;height:100px;')); ?>
</div>
<div class="profile-menu">
    <ul class="menu">
        <li class="<?php if(@$requestedURL['controller'] == 'Contents' and @$requestedURL['action'] == 'viewArticles') echo 'active'; ?>">
            <?php echo $this->Html->link('خانه','/~'.$this->request['username']); ?>
        </li>
        <li class="<?php if(@$requestedURL['controller'] == 'Contents' and @$requestedURL['action'] == 'category') echo 'active'; ?>">
            <?php echo $this->Html->link('لیست مجموعه ها','#'); ?>
            <?php if($categories): ?>
            <ul>
                <?php foreach($categories as $category): ?>
                <li class="<?php if(@$requestedURL['controller'] == 'Contents' and @$requestedURL['action'] == 'category' and in_array($category['ContentCategory']['id'], $requestedURL)) echo 'active'; ?>">
                    <?php echo $this->Profile->link($category['ContentCategory']['name'],array('controller' => 'Contents', 'action' => 'category', $category['ContentCategory']['id'])); ?>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </li>
        <li class="<?php if(@$requestedURL['controller'] == 'Complaints' and @$requestedURL['action'] == 'register') echo 'active'; ?>">
            <?php echo $this->Profile->link('ثبت شکایت',array('controller' => 'Complaints', 'action' => 'register')); ?>
        </li>
        <li class="<?php if(@$requestedURL == 'about') echo 'active'; ?>">
            <?php echo $this->Profile->link('درباره','/about'); ?>
        </li>
    </ul>
</div>
<hr/>
<div class="profile-info">
    <div class="profile-pic">
        <?php echo $this->Html->image('profile/manager/sample.jpg', array('style' => 'width:100px;height:133px')); ?>
    </div>
    <div class="profile-info-item">
        <label>نام و نام خانوادگی :</label>
        <span><?php echo $info['UserInformation']['first_name'].' '.$info['UserInformation']['last_name']; ?></span>
    </div>
    <div class="profile-info-item">
        <label>رسته :</label>
        <span><?php echo $info['Raste']['name']; ?></span>
    </div>
    <div class="profile-info-item">
        <label>درجه :</label>
        <span><?php echo $info['Degree']['name']; ?></span>
    </div>
    <div class="profile-info-item">
        <label>تلفن :</label>
        <span><?php echo $info['UserInformation']['market_telephone']; ?></span>
    </div>
    <div class="profile-info-item">
        <label>وبسایت :</label>
        <span><?php echo @$info['UserInformation']['website']; ?></span>
    </div>
    <div class="profile-info-item">
        <label>پست الکترونیک :</label>
        <span><?php echo @$info['UserInformation']['email']; ?></span>
    </div>
    <div class="profile-info-item" style="width: 80%;">
        <label>آدرس واحد صنفی :</label>
        <span><?php echo $info['UserInformation']['market_address']; ?></span>
    </div>
</div>
<hr class="line" />
<?php echo $content; ?>