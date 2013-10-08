<?php
echo $this->element('admin/scripts');
$this->Html->addCrumb('مدیریت پرداخت');
?>
<div class="toolbar-box">
    <div class="tool-head"><h2>مدیریت پرداخت</h2></div>
</div>
<table cellpadding="0" cellspacing="0" class="users">
    <thead>
    	<tr>
            <th><input type="checkbox" onclick="checkAll(this,<?php echo count($payments); ?>)" /></th>
			<th><?php echo $this->Paginator->sort('id','ردیف');?></th>
			<th><?php echo $this->Paginator->sort('Person.id','پرداخت کننده');?></th>
            <th><?php echo $this->Paginator->sort('Payment.price','مبلغ');?></th>
            <th><?php echo $this->Paginator->sort('Payment.type','نوع پرداخت');?></th>
            <th><?php echo $this->Paginator->sort('Payment.ref_num','شناسه پرداخت');?></th>
            <th><?php echo $this->Paginator->sort('Payment.status','وضعیت');?></th>
			<th><?php echo $this->Paginator->sort('Payment.pay_date','تاریخ پرداخت');?></th>
            <th>عملیات</th>
    	</tr>
    </thead>
	<?php
	foreach ($payments as $key => $payment): ?>
	<tr>
        <td class="has-cb"><input id="cb<?php echo $key ?>" type="checkbox" value="<?php echo $payment['Payment']['id']; ?>" /></td>
		<td><?php echo $key+1; ?>&nbsp;</td>
        <td><?php echo $this->Html->link(h($payment['Person']['last_name']), array('controller' => 'users', 'action' => 'view', $payment['Person']['user_id'])); ?>&nbsp;</td>
        <td><?php echo $this->Html->price($payment['Payment']['price'])?>&nbsp;</td>
        <td><?php echo $payment['Payment']['type']?>&nbsp;</td>
        <td><?php echo $payment['Payment']['ref_num']?>&nbsp;</td>
		<td><?php echo $payment['Payment']['namedStatus']; ?>&nbsp;</td>
        <td><?php echo $payment['Payment']['pay_date']; ?>&nbsp;</td>
        <td><?php 
            $status = $payment['Payment']['status'];
            
            //only show when status is in 0 or -1
            if($status == 0 || $status == -1){
                echo $this->Form->postLink('تایید',
                    array('action' => 'changeStatus','status' => 1, 'pay_id' => $payment['Payment']['id']),
                    array('class' => 'btn','style' => 'margin:10px')
                ); 
            }
            
            //only show when status is in 0 or 1
            if($status == 0 || $status == 1){
                echo $this->Form->postLink('عدم تائید',
                    array('action' => 'changeStatus','status' => -1, 'pay_id' => $payment['Payment']['id']),
                    array('class' => 'btn red')
                );
            }
        ?>
        </td>
	</tr>
<?php endforeach; ?>
</table>
<?php echo $this->Filter->limitAndPaginate();  ?>