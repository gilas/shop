<?php
$this->Html->addCrumb($parentTitle, array('action' => 'index'));
$this->Html->addCrumb($title);
$this->Html->script('jquery.datepicker', false);
$this->Html->script('price', false);
$this->Html->css('jquery.datepicker', null, array('inline' => false));
$this->Validator->addRule(array('Shop.FactorHead', 'Shop.FactorItem'));
$this->Validator->validate(); 
echo $this->Form->create('FactorHead', array(
    'inputDefaults' => array(
        'error' => array(
            'attributes' => array(
                'class' => 'alert-input-error',
                'id' => 'msg'
            )
        ),
        'empty' => array(
            0 => '--- انتخاب کنید ---'
        )
    ),
    'url' => array('plugin' => 'Shop','controller' => 'Orders','action' => 'add', 'type' => $type),
));
?>
<div id="toolbar-menu" class="row">
    <div class="title"><?php echo $title; ?></div>
    <ul id="toolbar">
        <li>
            <a onclick="$(this).parents('form').submit();" class="btn btn-success" tooltip-place="bottom" data-original-title="ذخیره" rel="tooltip" >
                <i class="icon-ok icon-white"></i><input type="submit" style="display: none;" />
            </a>
        </li>
        <li>
            <a href="<?php echo $this->Html->url(array('action' => 'index')); ?>" class="btn btn-danger" tooltip-place="bottom" data-original-title="انصراف" rel="tooltip" >
                <i class="icon-remove icon-white"></i>
            </a>
        </li>
    </ul>
</div>
<div class="row row-pad">
    <?php
        echo $this->Form->input('user', 
            array(
                'id' => 'userField',
                'readonly' => true,
                'label' => ($type == 1)?'نام فروشنده':'نام خریدار', 
                'div' => 'span4 input-append text', 
                'after' => $this->Html->tag(
                        'span', 
                        $this->AdminForm->_createIframe('...', array('controller' => 'User', 'action' => 'index', 'plugin' => 'Shop','type' => $type, 'layout' => 'iframe', 'row' => 0),array('escape' => false)),
                        array('class' => 'add-on')
                  ) 
            )
        );
        echo $this->Form->input('user_id', array('type' => 'hidden','id' => 'userId', ));
        echo $this->Form->input('date', array('id' => 'date','label' => 'تاریخ سفارش', 'div' => 'span4 input text'));
        echo $this->Form->input('number', array('label' => 'شماره سفارش', 'div' => 'span4 input text'));
    ?>
</div>
<div class="row">
    <div class="span10 offset1">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th class="row-column">ردیف</th>
                <th style="width: 300px;">شرح</th>
                <th style="width: 160px;">فی</th>
                <th style="width: 160px;">تعداد</th>
                <th>جمع</th>
                <th style="width: 70px;">حذف</th>
            </tr>
        </thead>
            <tr id="sample" style="display: none;">
                <td id="grid-align" class="row-count">0</td>
                <td id="grid-align"><?php 
                echo $this->Form->input('Item.0.name', 
                    array(
                        'label' => false, 
                        'disabled' => 'disabled',
                        'readonly' => true,
                        'div' => 'span4 input-append text', 
                        'after' => $this->Html->tag(
                                'span', 
                                $this->AdminForm->_createIframe('...', array('controller' => 'Stuffs', 'action' => 'index', 'plugin' => 'Shop', 'layout' => 'iframe', 'row' => 0),array('escape' => false)),
                                array('class' => 'add-on')
                          ) 
                    )
                );
                echo $this->Form->input('Item.0.code', array('type' => 'hidden','disabled' => 'disabled', ));
                ?></td>
                <td id="price"><?php 
                if($type == 1){
                    echo $this->Form->input('Item.0.price', 
                        array(
                            'label' => false, 
                            'div' => false, 
                            'style' => 'width:50px',
                            'class' => 'price',
                            'value' => 1,
                            'disabled' => 'disabled',
                            'onkeyup' => 'calRow($(this).parents(\'tr\').find(\'.row-count\').text())',
                        )
                    );
                }else{
                    echo '';
                }
                ?></td>
                <td id="grid-align"><?php 
                echo $this->Form->input('Item.0.count', 
                    array(
                        'label' => false, 
                        'div' => false, 
                        'style' => 'width:50px',
                        'class' => 'price',
                        'value' => 1,
                        'disabled' => 'disabled',
                        'onkeyup' => 'calRow($(this).parents(\'tr\').find(\'.row-count\').text())',
                    )
                );
                ?></td>
                <td id="total"></td>
                <td><a class="btn btn-danger" onclick="$(this).parents('tr').remove();calFactor();"><i class="icon-trash"></i> حذف</a></td>
            </tr>
        <tbody id="items">
        </tbody>
        <tr>
            <td colspan="4" style="text-align: left;">جمع کل</td>
            <td id="totalFactor"></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: left;">تخفیف</td>
            <td class="input-append" ><input id="discountFactor" name="data[discount]" onkeyup="calFactor()" type="text" /><span class="add-on">ریال</span></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: left;">جمع نهایی</td>
            <td id="finalFactor"></td>
        </tr>
        <tfoot>
            <tr>
                <th colspan="5"><a class="btn btn-primary" id="addItem">+ افزودن</a></th>
            </tr>
        </tfoot>
    </table>
    </div>
</div>
<?php
echo $this->Form->end(); 
?>
<script>
$(function() {
    cnt = <?php  if($this->request->data('Item')){ echo count($this->request->data('Item')); }else{echo '0';} ?>;
    $('#addItem').click(function(){
		cnt++
		fields = $('#sample').html()
		fields = fields.replace(/\[0\]/g,'['+cnt+']')
        fields = fields.replace(/disabled="disabled"/g, '' )
        fields = fields.replace(/\>0\</g,'>'+cnt+'<')
        fields = fields.replace(/row:0/,'row:'+cnt)
		$('<tr/>').html(fields).attr('id', 'tr' + cnt).appendTo('#items')
		
	})
    $('#date').datepicker({
            dateFormat: 'yy/mm/dd'
        });
});
function setItem(row, values){
    $items = $('#items')
    var finded = false
    items = $items.find('input[type=hidden]');
    for (i = 0; i < items.length; i++){
        if($(items[i]).val() == values.code){
            closeModal()
            alert('این کالا قبلا انتخاب شده است')
            return;
        }
    }
    $row = $('#tr' + row)
    $row.find('#Item0Name').val('(' + values.code + ') ' + values.name)
    $row.find('#Item0Code').val(values.code)
    <?php if($type == 1): ?>
    $row.find('#Item0Price').val(values.price)
    <?php else: ?>
    $row.find('#price').text(getPrice(values.price))
    <?php endif; ?>
    calRow(row)
    closeModal()
}

function chooseUser(row, values){
    $('#userField').val(values.name)
    $('#userId').val(values.id)
    closeModal()
}
function calRow(row){
    $row = $('#tr' + row)
    <?php if($type == 1): ?>
    price = $row.find('#Item0Price').val()
    <?php else: ?>
    price = removePrice($row.find('#price').text())
    <?php endif; ?>
    
    count = $row.find('#Item0Count').val()
    price = parseInt(price)
    count = parseInt(count)
    if(count <= 0 || count.lenght == 0){
        alert('تعداد مجاز وارد شود.')
        $row.find('#total').text(0)
    }
    var total = price * count
    if(isNaN(total)){
        total = 0;
    }
    $row.find('#total').text(getPrice(total))
    calFactor()
}

function calFactor(){
    $items = $('#items')
    totals = $items.find('tr #total');
    total = 0
    for (i = 0; i < totals.length; i++){
        t = $(totals[i]).text()
        t = removePrice(t)
        if(isNaN(t) || t == ''){
            continue;
        }
        total += parseInt(t)
    }
    $('#totalFactor').text(getPrice(total))
    discount = $('#discountFactor').val()
    if(discount.length == 0){
        discount = 0;
    }
    finalVal = total - parseInt(discount)
    if(finalVal < 0){
        finalVal = 0;
    }
    $('#finalFactor').text(getPrice(finalVal))
}
</script>