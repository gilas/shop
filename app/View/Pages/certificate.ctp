<?php $this->Html->addCrumb('پروانه کسب الکترونیک') ?>
<?php echo $this->Html->link('ثبت درخواست پروانه',array('controller' => 'Certificates', 'action' => 'register'),array('class' => 'button green small')); ?>
<?php echo $this->Html->link('رهگیری درخواست',array('controller' => 'Certificates', 'action' => 'view'),array('class' => 'button green small')); ?>