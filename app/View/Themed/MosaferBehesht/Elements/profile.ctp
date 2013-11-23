<?php
switch(AuthComponent::user('Role.name')){
    case 'Register':
        echo $this->Menu->getMenu('3', array('id' => 'toolbar', 'class' => 'profile-toolbar'), 'current' ,array('id' => 'menu'));
        break;
	case 'Admin':
	case 'SuperAdmin':
		echo '
		<div id="toolbar" class="profile-toolbar">
			<ul id="menu">
				<li><a href="'.$this->Html->url(array('controller' => 'Dashboards', 'action' => 'index', 'admin' => true, 'plugin' => false)).'">داشبورد</a></li>
				<li><a href="'.$this->Html->url(array('controller' => 'Users', 'action' => 'logout')).'">خروج</a></li>
			</ul>
		</div>
		';
		break;
}
?>