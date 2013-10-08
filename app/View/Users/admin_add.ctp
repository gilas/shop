<?php
$this->Html->addCrumb('مدیریت کاربران', array('action' => 'index'));
$this->Html->addCrumb('ایجاد کاربر');
$this->Validator->addRule('User');
$this->Validator->addCustomRule('User.password-2','equalTo','#User.password','تکرار رمز عبور با خود رمز عبور برابر نیست');
$this->Validator->validate(); 
echo $this->Form->create('User', array(
    'inputDefaults' => array(
        'error' => array(
            'attributes' => array(
                'class' => 'alert-input-error',
                'id' => 'msg'
            )
        ),
    )
));
?>
<div id="toolbar-menu" class="row">
    <div class="title">افزودن کاربر</div>
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
<?php 
    echo $this->Form->input('User.name',array('label' => array('class' => 'control-label', 'text' => 'نام و نام خانوادگی')));
    echo $this->Form->input('User.username',array('label' => array('class' => 'control-label', 'text' => 'نام کاربری')));
    echo $this->Form->input('User.password',array('type' => 'password','label' => array('class' => 'control-label', 'text' => 'رمز عبور')));
    echo $this->Form->input('User.password-2',array('type' => 'password','label' => array('class' => 'control-label', 'text' => 'تکرار رمز عبور')));
    echo $this->Form->input('User.email',array('label' => array('class' => 'control-label', 'text' => 'پست الکترونیک')));
    echo $this->Form->input('User.role_id',array('label' => array('class' => 'control-label', 'text' => 'نقش')));
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
<?php echo $this->Form->end(); ?>