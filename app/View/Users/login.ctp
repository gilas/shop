<?php
echo $this->Form->create('User', array('action' => 'login'));
echo $this->Form->input('username', array('label' => 'نام کاربری'));
echo $this->Form->input('password', array('label' => 'کلمه عبور'));
echo $this->Form->end(array('class' => 'btn btn-primary', 'label' => 'ورود به سیستم'));
?>