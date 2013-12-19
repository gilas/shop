<?php
$this->set('title_for_layout',  SettingsController::read('Site.Name'));
echo $this->requestAction(array('controller' => 'Contents', 'action' => 'home'),array('return'));
?>