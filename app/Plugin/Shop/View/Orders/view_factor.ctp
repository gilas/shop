<?php
$this->Html->addCrumb('لیست فاکتور ها', array('action' => 'index'));
$this->Html->addCrumb('مشاهده فاکتور');
?>
<div class="row" id="toolbar-menu">
    <div class="title">فاکتور فروش</div>
    <ul id="toolbar">
        <?php if($factor['FactorHead']['status'] == 0): ?>
        <li>
            <?php 
            echo $this->Form->postLink('<i class="icon-shopping-cart icon-white"></i> پرداخت', array('controller' => 'Orders', 'action' => 'sendPayment', $factor['FactorHead']['id']), array('class' => 'btn btn-success', 'escape' => false));
            ?>
        </li>
        <?php endif; ?>
        <li>
            <?php 
            echo $this->Form->postLink('<i class="icon-print icon-white"></i> پرینت فاکتور', '#', array('class' => 'btn btn-info', 'escape' => false));
            ?>
        </li>
    </ul>
</div>

<table style="width: 100%;">
    <tr>
        <td>
            <table style="width: 100%;height: 100px;" >
                <tr>
                    <td style="width: 160px;">شماره : <b><?php echo $factor['FactorHead']['number']; ?></b></td>
                    <td style="text-align: center;font-size: 15px; font-weight: bold;">فاکتور فروش</td>
                    <td style="width: 160px;">تاریخ صدور : <b><?php echo $factor['FactorHead']['date']; ?></b></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 200px;">صورتحساب : <b><?php echo $factor['ShopUser']['User']['name']; ?></b></td>
                    <td>آدرس : <b><?php echo $factor['ShopUser']['address']; ?></b></td>
                    <td style="width: 170px;">همراه : <b><?php echo $factor['ShopUser']['mobile']; ?></b></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table class="table table-bordered" style="width: 100%;">
                <tr>
                    <th>شماره</th>
                    <th>شرح کالا</th>
                    <th>تعداد</th>
                    <th>قیمت واحد</th>
                    <th>مبلغ</th>
                </tr>
                <?php 
                $index = 0; 
                $totalTax = 0;
                foreach($factor['Items'] as $item):
                if(!empty($item['Stuff']['Tax']['percent'])){
                    $totalTax += $item['total_price'] * $item['Stuff']['Tax']['percent'] / 100;
                }
                ?>
                <tr>
                    <td><?php echo ++$index; ?></td>
                    <td><?php echo $item['Stuff']['name'] . ' ('.$item['Stuff']['code'].')'; ?></td>
                    <td><?php echo number_format($item['count']); ?></td>
                    <td><?php echo number_format($item['price']); ?></td>
                    <td id="grid-align"><?php echo number_format($item['total_price']); ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" style="text-align: left;">جمع کل</td>
                    <td id="grid-align"><?php echo number_format($factor['FactorHead']['total_price']); ?></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: left;">تخفیف کوپن</td>
                    <td id="grid-align" dir="ltr"><?php
                        echo '- ';
                        if($factor['Coupon']['discount_type'] == 1){
                            echo number_format($factor['Coupon']['discount_value'] * $factor['FactorHead']['total_price'] / 100);
                        } else{
                            echo number_format($factor['Coupon']['discount_value']);
                        } 
                    ?></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: left;">روش حمل کالا (<?php echo $factor['Deport']['name'] ?>)</td>
                    <td id="grid-align"><?php echo number_format($factor['Deport']['price']); ?></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: left;">مالیات</td>
                    <td id="grid-align"><?php echo number_format($totalTax); ?></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: left;">جمع نهایی</td>
                    <td id="grid-align"><?php echo number_format($factor['FactorHead']['final_price']).' ریال'; ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php if($factor['FactorHead']['status'] > 0):?>
<table class="users">
    <tr>
        <th>نحوه پرداخت</th>
        <th>مبلغ پرداختی</th>
        <th>تاریخ پرداخت</th>
        <th>وضعیت</th>
    </tr>
    <tr>
        <td><?php echo $payInfo['type'] ?></td>
        <td><?php echo $this->Html->price($payInfo['price']); ?></td>
        <td><?php echo Jalali::niceShort($payInfo['pay_date']); ?></td>
        <td><?php echo $payInfo['formattedStatus'] ?></td>
    </tr>
</table>
<?php endif; ?>