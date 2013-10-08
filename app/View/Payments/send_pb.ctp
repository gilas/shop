<h3>لطفا صبر نمائید تا سامانه به بانک متصل شود</h3>
<form id="form"  action="<?php echo $url ?>">
    <input type="hidden" id="Amount" name="Amount" value="<?php echo $price ?>"/>
    <input type="hidden" id="MerchantId" name="MerchantId" value="<?php echo $mid ?>"/>
    <input type="hidden" id="CustomerId" name="CustomerId" value="<?php echo $res_num ?>"/>
    <input type="hidden" id="ReturnPage" name="ReturnPage" value="<?php echo $this->Html->url(array('action' => 'onlineReceive', 'postbank'),array('full'=>true)) ?>"/>
</form>
<script>
    $(function(){
        $('#form').submit();
    })
</script>