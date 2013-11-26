<?php
$this->Html->addCrumb('لیست فاکتور ها', array('action' => 'index'));
$this->Html->addCrumb('مشاهده فاکتور');
?>
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
                <?php $index = 0; foreach($factor['Items'] as $item): ?>
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
                    <td id="grid-align" dir="ltr"><?php echo '-' . number_format($factor['Coupon']['discount_value']); ?></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: left;">روش حمل کالا (<?php echo $factor['Deport']['name'] ?>)</td>
                    <td id="grid-align"><?php echo number_format($factor['Deport']['price']); ?></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: left;">مالیات (<?php echo $factor['Tax']['percent'] ?> %)</td>
                    <td id="grid-align"><?php echo number_format($factor['FactorHead']['final_price'] * $factor['Tax']['percent'] / 100); ?></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: left;">جمع نهایی</td>
                    <td id="grid-align"><?php echo number_format($factor['FactorHead']['final_price']).' ریال'; ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php
//debug($factor);
?>