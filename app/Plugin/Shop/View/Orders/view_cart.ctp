<?php
$this->Html->addCrumb('مشاهده سبد خرید');
$this->Html->script('price', false);
?>
<div class="row" id="toolbar-menu">
    <div class="title">سبد خرید</div>
    <ul id="toolbar">
        <li>
            <?php 
            echo $this->Form->postLink('<i class="icon-plus icon-white"></i> ثبت سفارش', array('controller' => 'Orders', 'action' => 'submitCart'), array('class' => 'btn btn-success', 'escape' => false));
            ?>
        </li>
        <li>
            <?php 
            echo $this->Form->postLink('<i class="icon-trash icon-white"></i> خالی کردن سبد', array('controller' => 'Orders', 'action' => 'emptyCart'), array('class' => 'btn btn-danger', 'escape' => false));
            ?>
        </li>
    </ul>
</div>
<?php
if(empty($stuffs)){
    echo 'سبد خرید خالی می باشد';
    return;
}
?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ردیف</th>
            <th>نام کالا (کد کالا)</th>
            <th>فی (ریال)</th>
            <th style="width: 130px;">تعداد</th>
            <th>مبلغ (ریال)</th>
            <th>حذف</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $i = 0; 
        $total = 0;
        foreach($stuffs as $stuff): 
        $i++; 
        ?>
        <?php
        $count = $this->Session->read('Cart.item.'. $stuff['Stuff']['id']);
        $price = $stuff['Stuff']['price'];
        if(!empty($stuff['Stuff']['discount'])){
            $price = $stuff['Stuff']['PriceWithDiscount'];
        }
        $total += $price * $count;
        ?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $stuff['Stuff']['name'] . ' (' . $stuff['Stuff']['code'] . ')'; ?></td>
            <td class="stuff-price"><?php echo number_format($price); ?></td>
            <td style="text-align: center;">
                <input style="width:98px; margin:0;" class="stuff-count" type="text" name="stuff<?php echo microtime(); ?>" rel="<?php echo $stuff['Stuff']['id'] ?>" value="<?php echo $count; ?>" />
                <a class="btn btn-info changeCount"><i class="icon-arrow-left icon-white"></i></a>
            </td>
            <td class="stuff-total"><?php echo number_format($price * $count); ?></td>
            <td>
            <?php
            echo $this->Form->postLink('حذف', array('controller' => 'Orders', 'action' => 'deleteFromCart', $stuff['Stuff']['id']), array('class' => 'btn btn-danger'), 'آیا مطمئن هستید؟');
            ?>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php
        $coupon_text = '';
        $coupon_value = $this->Session->read('Cart.coupon.discount_value');
        
        if($coupon_value){
            $coupon_text = '(<i>'. $coupon_value.'</i> ریال)';
        }
        
        if($this->Session->check('Cart.coupon.discount_value')){
            if($this->Session->read('Cart.coupon.discount_type') == 1){
                $coupon_text = '(<i>'.$coupon_value.'</i> %)';
                $coupon_value = $total * $this->Session->read('Cart.coupon.discount_value') / 100;
                $total -= $coupon_value;
                
            }else{
                $total -=$this->Session->read('Cart.coupon.discount_value');
            }
        }
        ?>
        <tr>
            <td colspan="3" style="text-align: left;" id="couponValue">کوپن <?php echo $coupon_text; ?><span style="display: none;"><?php echo $this->Session->read('Cart.coupon.discount_type'); ?></span></td>
            <td style="text-align: center;">
                <input style="width:98px; margin:0;" id="coupon-number" type="text" name="coupon<?php echo microtime(); ?>" value="<?php echo $this->Session->read('Cart.coupon.serial'); ?>" />
                <a class="btn btn-info checkCoupon"><i class="icon-refresh icon-white"></i></a>
            </td>
            <td id="couponPrice" style="color: green;"><?php echo number_format($coupon_value); ?></td>
            <td>
            <?php
            echo $this->Form->postLink('حذف', array('controller' => 'Orders', 'action' => 'deleteCoupon'), array('class' => 'btn btn-danger'), 'آیا مطمئن هستید؟');
            ?>
            </td>
        </tr>
        <?php
        $total += $this->Session->read('Cart.deport.price');
        ?>
        <tr>
            <td colspan="3" style="text-align: left;">روش ارسال</td>
            <td>
                <select id="deportOption" style="width: 98px;">
                    <option price="0" value="0"></option>
                    <?php foreach($deports as $deport): ?>
                    <option <?php if($deport['Deport']['id'] == $this->Session->read('Cart.deport.id')){echo 'selected="selected"';} ?> price="<?php echo $deport['Deport']['price'] ?>" value="<?php echo $deport['Deport']['id'] ?>"><?php echo $deport['Deport']['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <a class="btn btn-info" id="setDeport"><i class="icon-arrow-left icon-white"></i></a>
            </td>
            <td id="deportPrice"><?php echo number_format($this->Session->read('Cart.deport.price')); ?></td>
            <td></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4" style="text-align: left;">جمع کل (ریال)</th>
            <th id="total"><?php echo $this->Html->price($total, false); ?></th>
            <th></th>
        </tr>
    </tfoot>
</table>

<script>
    $(function(){
        $('.stuff-count').change(function(){
            $(this).css('background-color', '#FFD6D6');
        })
        $('.changeCount').click(function(){
            $count = $(this).parents('tr').find('.stuff-count');
            id = $count.attr('rel');
            count = $count.val();
            if( count < 1){
                return false;
            }
            
            $.ajax({
                url:"<?php echo $this->Html->url(array('controller' => 'Orders', 'action' => 'addToCart')) ?>", 
                type:'POST',
                data:'data[stuff_id]=' + id + '&data[count]=' + count
            })
            .done(function(data) { 
                closeModal(); 
                cnt = parseInt(data)
                if(! isNaN(cnt)){
                    price = removePrice($count.parents('tr').find('.stuff-price').text());
                    $total = $count.parents('tr').find('.stuff-total');
                    preTotal = removePrice($total.text());
                    newTotal = parseInt(count) * parseInt(price);
                    $total.text(getPrice(newTotal));
                    total = removePrice($('#total').text());
                    total = parseInt(total) - parseInt(preTotal) + newTotal;
                    $('#total').text(getPrice(total));
                    calCoupon()
                    alert("تعداد کالا ویرایش گردید.");
                    $count.css('background-color', '#D9FFD9');
                    return;
                }
                alertError(data);
                
            })
        })
        
        $('#setDeport').click(function(){
            val = $('#deportOption').val();
            price = 0;
            $('#deportOption option').each(function(){
                $this = $(this)
                //select empty option
                if($this.val() == val){
                    price = $(this).attr('price');
                }
            })
            
            $.ajax({
                url:"<?php echo $this->Html->url(array('controller' => 'Orders', 'action' => 'setDeport')) ?>", 
                type:'POST',
                data:'data[deport_id]=' + val
            })
            .done(function(data) { 
                closeModal(); 
                if(data){
                    alert("روش ارسال کالا تنظیم گردید.");
                    $('#deportOption').css('background-color', '#D9FFD9');
                    prePrice = removePrice($('#deportPrice').text());
                    $('#deportPrice').text(getPrice(price));
                    total = removePrice($('#total').text());
                    total = parseInt(total) - parseInt(prePrice) + parseInt(price);
                    $('#total').text(getPrice(total));
                    return;
                }
                alertError(data);
                
            })
        })
        $('#deportOption').change(function(){
            $(this).css('background-color', '#FFD6D6');
        })
        
        $('#coupon-number').change(function(){
            $(this).css('background-color', '#FFD6D6');
        })
        
        $('.checkCoupon').click(function(){
            $number = $(this).parents('tr').find('#coupon-number');
            number = $number.val();
            $.ajax({
                url:"<?php echo $this->Html->url(array('controller' => 'Orders', 'action' => 'addCoupon')) ?>", 
                type:'POST',
                data:'data[coupon]=' + number
            })
            .done(function(data) { 
                closeModal(); 
                d = $.parseJSON(data)
                couponPrice = parseInt(d.value)
                if(! isNaN(couponPrice)){
                    alert("کوپن ثبت گردید.");
                    $number.css('background-color', '#D9FFD9');
                    calCoupon(d.type, couponPrice);
                    return;
                }
                alertError(data);
                
            })
        })
        
        function calCoupon(type, couponPrice){
            if(type == undefined){
                type = parseInt($('#couponValue span').text())
                couponPrice = parseInt(removePrice($('#couponValue i').text()))
            }
            value = couponPrice;
            prePrice = parseInt(removePrice($('#couponPrice').text()));
            deportPrice = parseInt(removePrice($('#deportPrice').text()));
            total = parseInt(removePrice($('#total').text()));
            if(type == 1){
                couponPrice = (total + prePrice - deportPrice) * couponPrice / 100;
                $('#couponValue').html('کوپن (<i>' + value + '</i> %)<span style="display: none;">1</span>')
            }else{
                $('#couponValue').html('کوپن (<i>' + couponPrice + '</i> ریال)<span style="display: none;">1</span>')
            }
            $('#couponPrice').text(getPrice(couponPrice));
            total = parseInt(total) + parseInt(prePrice) - parseInt(couponPrice);
            $('#total').text(getPrice(total));
        }
    })
</script>