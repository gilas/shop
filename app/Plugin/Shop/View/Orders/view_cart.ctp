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
            <th>مالیات (ریال)</th>
            <th>حذف</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $i = 0; 
        $total = 0;
        $totalTax = 0;
        foreach($stuffs as $stuff){
            $i++;
            $count = $this->Session->read('Cart.item.'. $stuff['Stuff']['id']);
            $price = $stuff['Stuff']['price'];
            if(!empty($stuff['Stuff']['discount'])){
                $price = $stuff['Stuff']['PriceWithDiscount'];
            }
            $total += $price * $count;
            echo '<tr>';
                printf('<td>%s</td>', $i);
                printf('<td>%s (%s)</td>', $stuff['Stuff']['name'], $stuff['Stuff']['code']);
                printf('<td class="stuff-price">%s</td>', number_format($price));
                printf('
                <td style="text-align: center;">
                    <input style="width:66px; margin:0;" class="stuff-count" type="text" name="stuff%s" rel="%s" value="%s" />
                    <a class="btn btn-info changeCount"><i class="icon-arrow-left icon-white"></i></a>
                </td>
                ', microtime(), $stuff['Stuff']['id'], $count);
                $t = $price * $count;
                printf('<td class="stuff-total">%s</td>', number_format($t));
                $totalTax += $tax = $stuff['Tax']['percent'] * $t / 100;
                printf('<td class="stuff-tax"><span>%s</span><i style="display:none">%s</i></td>', number_format($tax), $stuff['Tax']['percent']);
                printf('<td>%s</td>', $this->Form->postLink('حذف', array('controller' => 'Orders', 'action' => 'deleteFromCart', $stuff['Stuff']['id']), array('class' => 'btn btn-danger'), 'آیا مطمئن هستید؟'));
        }
        ?>
        <tr>
            <td colspan="4" style="text-align: left;">جمع اقلام</td>
            <td id="total-of-stuffs"><?php echo number_format($total); ?></td>
            <td id="total-of-taxes"><?php echo number_format($totalTax); ?></td>
            <td></td>
        </tr>
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
                <input style="width:66px; margin:0;" id="coupon-number" type="text" name="coupon<?php echo microtime(); ?>" value="<?php echo $this->Session->read('Cart.coupon.serial'); ?>" />
                <a class="btn btn-info checkCoupon"><i class="icon-refresh icon-white"></i></a>
            </td>
            <td id="couponPrice" style="color: green;"><?php echo number_format($coupon_value); ?></td>
            <td></td>
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
                <select id="deportOption" style="width: 83px;">
                    <option price="0" value="0"></option>
                    <?php foreach($deports as $deport): ?>
                    <option <?php if($deport['Deport']['id'] == $this->Session->read('Cart.deport.id')){echo 'selected="selected"';} ?> price="<?php echo $deport['Deport']['price'] ?>" value="<?php echo $deport['Deport']['id'] ?>"><?php echo $deport['Deport']['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <a class="btn btn-info" id="setDeport"><i class="icon-arrow-left icon-white"></i></a>
            </td>
            <td id="deportPrice"><?php echo number_format($this->Session->read('Cart.deport.price')); ?></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4" style="text-align: left;">جمع کل (ریال)</th>
            <th id="total"><?php echo $this->Html->price($total + $totalTax, false); ?></th>
            <th></th>
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
                    calStuff($count.parents('tr'));
                    calCoupon()
                    calTotal()
                    alert("تعداد کالا ویرایش گردید.");
                    $count.css('background-color', '#D9FFD9');
                    return;
                }
                alertError(data);
                
            })
        })
        function calStuff($stuff){
            count   = $stuff.find('.stuff-count').val();
            price   = removePrice($stuff.find('.stuff-price').text());
            $total  = $stuff.find('.stuff-total');
            $tax    = $stuff.find('.stuff-tax span');
            taxPercent    =  $stuff.find('.stuff-tax i').text();
            total   = parseInt(count) * parseInt(price);
            $total.text(getPrice(total));
            if(taxPercent != ''){
                tax = total * taxPercent / 100;
                $tax.text(getPrice(tax));
            }
            calTotalStuffsAndTax();
        }
        function calTotalStuffsAndTax(){
            total = 0;
            $('.stuff-total').each(function(i, obj){
                total += parseInt(removePrice($(obj).text()));
            })
            $('#total-of-stuffs').text(getPrice(total));
            tax = 0;
             $('.stuff-tax span').each(function(i, obj){
                tax += parseInt(removePrice($(obj).text()));
            })
            $('#total-of-taxes').text(getPrice(tax));
        }
        function calTotal(){
            total  = parseInt(removePrice($('#total-of-stuffs').text()));
            tax    = parseInt(removePrice($('#total-of-taxes').text()));
            coupon = parseInt(removePrice($('#couponPrice').text()));
            deport = parseInt(removePrice($('#deportPrice').text()));
            $('#total').text(getPrice(total + tax - coupon + deport));
        }
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
                    $('#deportPrice').text(getPrice(price));
                    calTotal();
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
                if(isNaN(type)){
                    return false;
                }
            }
            value = couponPrice;
            total = parseInt(removePrice($('#total-of-stuffs').text()));
            if(type == 1){
                couponPrice = total  * couponPrice / 100;
                $('#couponValue').html('کوپن (<i>' + value + '</i> %)<span style="display: none;">1</span>')
            }else{
                $('#couponValue').html('کوپن (<i>' + couponPrice + '</i> ریال)<span style="display: none;">1</span>')
            }
            $('#couponPrice').text(getPrice(couponPrice));
            calTotal();
        }
    })
</script>