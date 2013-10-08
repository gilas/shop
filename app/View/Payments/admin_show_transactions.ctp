<?php
if(empty($transaction)) {
    echo 'هیچ تراکنشی انجام نشده است';
    //return;
}
?>
<div class="box">
    <div class="header"> <h3>لیست تراکنش ها</h3></div>
    <div class="content no-padding">
        <table class="users">
            <tr>
                <th>ردیف</th>
                <th>شماره پیگیری</th>
                <th>شماره درخواست</th>
                <th>وضعیت</th>
                <th>پرداخت</th>
                <th>مقدار پرداختی</th>
            </tr>
            <?php $i =0; foreach($transaction as $tran): ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td><?php echo $tran['EnPayment']['ref_num']; ?></td>
                <td><?php echo $tran['EnPayment']['res_num']; ?></td>
                <td><?php echo $tran['EnPayment']['state']; ?></td>
                <td><?php echo $tran['EnPayment']['price']; ?></td>
                <td><?php echo $tran['EnPayment']['verify']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>