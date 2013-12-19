<?php
echo $this->Form->create();
echo $this->Form->input('name');
if(SettingsController::read('User.showCaptcha')){
    echo $this->Form->input('captcha', array('after' => $this->Captcha->showCaptcha() ));
}

echo $this->Form->end('ارسال');
?>