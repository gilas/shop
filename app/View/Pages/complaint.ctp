<?php $this->Html->addCrumb('شکایت') ?>
<?php echo $this->Html->link('ثبت شکایت',array('controller' => 'Complaints', 'action' => 'register'),array('class' => 'button green small')); ?>
<?php echo $this->Html->link('پیگیری شکایت',array('controller' => 'Complaints', 'action' => 'viewComplaint'),array('class' => 'button green small')); ?>