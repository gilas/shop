<?php
$this->Html->addCrumb($parentTitle, array('action' => 'index'));
$this->Html->addCrumb($title);
$this->Validator->addRule(array('User', 'Shop.ShopUser'));
$this->Validator->addCustomRule('User.password-2','equalTo','#User.password','تکرار رمز عبور با خود رمز عبور برابر نیست');
$this->Validator->validate(); 
echo $this->Form->create('Stuff', array(
    'inputDefaults' => array(
        'error' => array(
            'attributes' => array(
                'class' => 'alert-input-error',
                'id' => 'msg'
            )
        ),
        'empty' => array(
            0 => '--- انتخاب کنید ---'
        )
    )
));
?>
<div id="toolbar-menu" class="row">
    <div class="title"><?php echo $title; ?></div>
    <ul id="toolbar">
        <li>
            <a onclick="$(this).parents('form').submit();" class="btn btn-success" tooltip-place="bottom" data-original-title="ذخیره" rel="tooltip" >
                <i class="icon-ok icon-white"></i><input type="submit" style="display: none;" />
            </a>
        </li>
        <li>
            <a href="<?php echo $this->Html->url(array('action' => 'index')); ?>" class="btn btn-danger" tooltip-place="bottom" data-original-title="انصراف" rel="tooltip" >
                <i class="icon-remove icon-white"></i>
            </a>
        </li>
    </ul>
</div>
<div class="row row-pad">
    <?php
        echo $this->Form->input('User.name', array('label' => 'نام و نام خانوادگی', 'div' => 'span4 input text'));
        echo $this->Form->input('ShopUser.phone', array('label' => 'شماره تلفن', 'div' => 'span4 input text'));
		echo $this->Form->input('ShopUser.mobile', array('label' => 'شماره همراه', 'div' => 'span4 input text'));
    ?>
</div>
<div class="row row-pad">
    <?php
        echo $this->Form->input('ShopUser.city', array('label' => 'استان/شهر', 'div' => 'span4 input text', 'options' => $this->Html->getCityList($states)));
        echo $this->Form->input('ShopUser.code_posti', array('label' => 'کد پستی', 'div' => 'span4 input text'));
		echo $this->Form->input('ShopUser.address', array('label' => 'آدرس دقیق پستی', 'div' => 'span4 input text'));
    ?>
</div>
<div class="row row-pad">
    <?php
        echo $this->Form->input('User.username', array('label' => 'نام کاربری', 'div' => 'span4 input text'));
        echo $this->Form->input('User.password', array('label' => 'رمز عبور', 'div' => 'span4 input text'));
		echo $this->Form->input('User.password-2', array('type' => 'password', 'label' => 'تکرار رمز عبور', 'div' => 'span4 input text'));
    ?>
</div>
<div class="row row-pad">
    <?php
        echo $this->Form->input('User.email', array('label' => 'پست الکترونیک', 'div' => 'span4 input text'));
        echo $this->Form->input('User.role_id', array('label' => 'نقش', 'div' => 'span4 input text'));
    ?>
    <div class="input control-group">
	    <label class="control-label">وضعیت</label>
	    <div class="controls">
	        <label class="btn-group radio inline no-padding">
	            <input id="Useractive1" type="radio" name="data[User][active]" value="1" <?php if ($this->Form->value('User.active') == 1) echo 'checked="checked"' ?> />
	            <label class="first-child" for="Useractive1">بله</label>
	            <input id="Useractive0"  type="radio" name="data[User][active]" value="0" <?php if ($this->Form->value('User.active') == 0) echo 'checked="checked"' ?> />
	            <label for="Useractive0">خیر</label>
	        </label>
	    </div>
	</div>
</div>
<?php echo $this->Form->end(); ?>