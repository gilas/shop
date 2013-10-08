<h3>لطفا صبر نمائید تا سامانه به بانک متصل شود</h3>
<form id="form"  action="<?php echo $url ?>" method="post">
    <input type="hidden" id="amount" name="amount" value="<?php echo $price ?>"/>
    <input type="hidden" id="merchantId" name="merchantId" value="<?php echo $mid ?>"/>
    <input type="hidden" id="paymentId" name="paymentId" value="<?php echo $res_num ?>"/>
    <input type="hidden" id="revertURL" name="revertURL" value="<?php echo $this->Html->url(array('action' => 'onlineReceive', 'tejaratbank'),array('full'=>true)) ?>"/>
</form>
<script>
    $(function(){
        $('#form').submit();
    })
</script>