<?php
// Add
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-plus icon-white')),array('action' => 'add','content_category_id' => @$this->request->named['content_category_id'],'normalLink' => true ),array('class' => 'btn btn-success','escape' => false, 'rel' => 'tooltip','data-original-title' => 'افزودن','tooltip-place' => 'bottom'));
// Delete
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-trash icon-white')),array('action' => 'delete','confirm' => 'آیا مطمئن هستید ؟'),array('class' => 'btn btn-danger','escape' => false, 'rel' => 'tooltip','data-original-title' => 'حذف','tooltip-place' => 'bottom'));

//Show toolbar
$this->AdminForm->showToolbar('لیست پیام ها');

//Filtering
// we use action in options for rewriting action attr without querystring
echo $this->Filter->create('Pm',array('action' => 'index'));
echo $this->Filter->input('content',array('label' => 'قسمتی از پیام'));
echo $this->Filter->input('folder',array(
    'label' => 'پوشه',
    'options' => array(
        '' => '',
        '1' => 'صندوق ورودی',
        '2' => 'صندوق خروجی',
        '3' => 'ذخیره شده',
    ))
);
echo $this->Filter->end();

if (!empty($pms)) {
    // start form tag
    echo $this->AdminForm->startFormTag('Pm');
    ?>
    <table class="table table-bordered table-striped">

        <tr>
            <th><?php echo $this->AdminForm->selectAll(); ?></th>
            <th>ردیف</th>
            <th><?php 
            switch($selectedFolder){
                case 'inbox':  echo 'فرستنده'; break;
                case 'outbox': echo 'گیرنده';  break;
            }
            ?></th>
            <th>عنوان</th>
            <th>قسمتی از پیام</th>
            <th>تاریخ ارسال</th>
            <th>وضعیت</th>
        </tr>
        <?php
        //current index
        $index = $this->Filter->paginParams['limit'] * ($this->Filter->paginParams['page'] - 1);
        
        foreach ($pms as $pm):
            ?>
            <tr>
                <td id="grid-align"><?php echo $this->AdminForm->checkbox($pm['Reader']['id']) ?></td>
                <td><?php echo ++$index; ?></td>
                <td>
                    <?php
                    switch($selectedFolder){
                        case 'inbox':  
                            if($pm['Reader']['new']){
                                echo $this->Html->image('icon-pack/mail-unread.png', array('class' => 'msg-icon'));    
                            }else{
                                echo $this->Html->image('icon-pack/mail-open.png', array('class' => 'msg-icon'));   
                            } 
                            echo $pm['Message']['Sender']['SenderInfo']['name'] . (($pm['Message']['childCount'] > 1)?' ('.$pm['Message']['childCount'].')':''); 
                            break;
                        case 'outbox':
                            $recipients = array();
                            foreach($pm['Message']['Recipients'] as $recipient){
                                $recipients[] =  $recipient['Recipient']['name'];
                            }
                            echo  String::truncate(implode(', ',$recipients), 30)  . (($pm['Message']['childCount'] > 1)?' ('.$pm['Message']['childCount'].')':'');
                            break;
                    }
                    ?>
                </td>
                <td><?php 
                $link = array('action' => 'read', $pm['Reader']['id']);
                if($selectedFolder == 'draft'){
                    $link = array('action' => 'add', $pm['Message']['id']);
                }
                echo $this->Html->link($pm['Message']['subject'], $link); 
                ?></td>
                <td><?php 
                    echo String::truncate(
                        // strip of tags
                        preg_replace('/(<\/?)(\w+)([^>]*>)/e', '',$pm['Message']['message']),
                        50); 
                ?></td>
                <td><?php echo Jalali::niceShort($pm['Message']['created']); ?></td>
                <td><?php echo ($pm['Reader']['read_date'] == 0)?'خوانده نشده':Jalali::niceShort($pm['Reader']['read_date']); ?></td>
            </tr>
            <?php endforeach;?>
    </table>
    <?php
    echo $this->AdminForm->endFormTag();// end form tag
}
?>
<?php echo $this->Filter->limitAndPaginate(); ?>