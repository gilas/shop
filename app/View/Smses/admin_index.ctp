<?php
// Add
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-plus icon-white')),array('action' => 'send','normalLink' => true ),array('class' => 'btn btn-success','escape' => false, 'rel' => 'tooltip','data-original-title' => 'افزودن','tooltip-place' => 'bottom'));
// Delete
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-trash icon-white')),array('action' => 'delete','confirm' => 'آیا مطمئن هستید ؟'),array('class' => 'btn btn-danger','escape' => false, 'rel' => 'tooltip','data-original-title' => 'مشاهده','tooltip-place' => 'bottom'));
// Settings
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-wrench icon-white')),array('action' => 'settings', 'layout' => 'iframe'),array('class' => 'btn btn-warning','escape' => false, 'rel' => 'tooltip','data-original-title' => 'تنظیمات','tooltip-place' => 'bottom'));
//Show toolbar
$this->AdminForm->showToolbar('لیست پیامک ها');

if (!empty($smses)) {
    // start form tag
    echo $this->AdminForm->startFormTag();
    ?>
    <table class="table table-bordered table-striped">

        <tr>
            <th><?php echo $this->AdminForm->selectAll(); ?></th>
            <th>ردیف</th>
            <th><?php echo $this->Paginator->sort('Sms.from','فرستنده') ?></th>
            <th><?php echo $this->Paginator->sort('Sms.to','گیرنده') ?></th>
            <th><?php echo $this->Paginator->sort('Sms.message','پیام') ?></th>
            <th><?php echo $this->Paginator->sort('Sms.created','تاریخ ارسال') ?></th>
        </tr>
        <?php
        //current index
        $index = $this->Filter->paginParams['limit'] * ($this->Filter->paginParams['page'] - 1);
        
        foreach ($smses as $sms):
            ?>
            <tr>
                <td id="grid-align"><?php echo $this->AdminForm->checkbox($content['Content']['id']) ?></td>
                <td><?php echo ++$index; ?></td>
                <td><?php echo $sms['Sms']['from']; ?></td>
                <td><?php echo $sms['Sms']['to']; ?></td>
                <td><?php echo $this->Html->link($sms['Sms']['message'],array('action' => 'view', $sms['Sms']['id'])); ?></td>
                <td><?php echo Jalali::niceShort($sms['Sms']['created']); ?></td>
            </tr>
            <?php
        endforeach;
        ?>
    </table>
    <?php
    echo $this->AdminForm->endFormTag();// end form tag
}
?>
<?php echo $this->Filter->limitAndPaginate(); ?>