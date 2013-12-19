<?php
foreach($categoryParents as $parent){
    $this->Html->addCrumb($parent['Category']['name'], array('controller' => 'Categories', 'action' => 'view', $parent['Category']['id']));
}

if(empty($stuff)){
    echo 'کالا یافت نشد';
    return;
}
$this->Html->addCrumb($stuff['Stuff']['name']);
?>
<h2 class="page-header">مشخصات کالا</h2>
<div class="stuff" style="display: block;">
    <table class="stuff-detail">
        <tr>
            <td style="width: 100px;">عنوان کالا</td>
            <td style="width: 300px;"><?php echo $stuff['Stuff']['name']; ?></td>
            <td rowspan="6"><?php
            $image = '';
            if(! empty($stuff['Stuff']['thumbnail_file_name'])){
                $image = $this->AdminForm->_createIframe(
                    $this->Upload->image($stuff, 'Stuff.thumbnail', array('style' => 'thumb')), 
                    $this->Upload->url($stuff, 'Stuff.thumbnail', array('urlize' => false)), 
                    array('escape' => false)
                );
            }
            echo $image;
            ?></td>
        </tr>
        <tr>
            <td>کد کالا</td>
            <td><?php echo $stuff['Stuff']['code']; ?></td>
        </tr>
        <tr>
            <td>قیمت کالا</td>
            <td>
                <?php
                if(empty($stuff['Stuff']['discount'])){
                    echo $this->Html->price($stuff['Stuff']['price']);
                }else{
                    echo '<span class="old-price">'. $this->Html->price($stuff['Stuff']['price']) .'</span>';
                    echo '<span class="new-price">'. $this->Html->price($stuff['Stuff']['PriceWithDiscount']) .'</span>';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php  echo $this->Html->link('افزودن به سبد خرید', '#addToCart', array('class' => 'btn', 'id' => 'cartModal')); ?>
            </td>
        </tr>
    </table>
</div>

<div id="addToCart" style="display: none;">
<h5>افزودن به سبد</h5>
<hr />
<form onsubmit="submitForm(this);return false;">
    <input name="data[stuff_id]" id="stuff_id" type="hidden" value="<?php echo $stuff['Stuff']['id']; ?>"/>
    <div class="input">
        <label>تعداد</label>
        <input type="text" name="data[count]" />
    </div>
    <div style="text-align: left;"><input type="submit" value="افزودن به سبد خرید" class="btn" /></div>
</form>
</div>

<?php $this->Html->script('fancybox', false); ?>
<?php $this->Html->css('fancybox', null, array('inline' => false)); ?>
<script>
$(function(){
    $("#cartModal").fancybox({
		'titlePosition'		: 'inside',
		'transitionIn'		: 'none',
		'transitionOut'		: 'none'
	});
})
function submitForm(obj){
    var jqxhr = $.ajax({
            url:"<?php echo $this->Html->url(array('controller' => 'Orders', 'action' => 'addToCart')) ?>", 
            type:'POST',
            data:$(obj).serializeArray()
        })
        .done(function(data) { 
            closeModal(); 
            count = parseInt(data)
            if(! isNaN(count)){
                alert("کالا به سبد خرید افزوده شد.");
                $('#cartCount').text(count)
                return;
            }
            alertError(data);
            
        })
        .fail(function(data) { closeModal(); alertError("اشکال در افزودن کالا به سبد خرید"); })
        .always(function() { return true; });
}
</script>