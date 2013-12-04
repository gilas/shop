<div class="testPayment">
<h4>لطفا صبر نمائید تا سامانه به بانک متصل شود</h4>
<form id="form"  action="<?php echo $this->Html->url(array('action' => 'onlineReceive', 'test')) ?>" method="post">
    <input type="hidden" id="Amount" name="Amount" value="<?php echo $price ?>"/>
    <input type="hidden" id="resultCode" name="resultCode" value="100"/>
    <input type="hidden" id="referenceId" name="referenceId" value="12"/>
    <input type="hidden" id="paymentId" name="paymentId" value="<?php echo $res_num ?>"/>
</form>
</div>
<script>
    $(function(){
        $('#form').submit();
    })
</script>