<h4>لطفا صبر نمائید تا سامانه به بانک متصل شود</h4>
<form id="form"  action="<?php echo $url; ?>" method="post">
    <input type="hidden" id="Amount" name="Amount" value="<?php echo $price ?>"/>
    <input type="hidden" id="MID" name="MID" value="<?php echo $mid ?>"/>
    <input type="hidden" id="ResNum" name="ResNum" value="<?php echo $res_num ?>"/>
    <input type="hidden" id="RedirectURL" name="RedirectURL" value="<?php echo $this->Html->url(array('action' => 'onlineReceive', 'enbank'),array('full'=>true)) ?>"/>
</form>
<script>
    $(function(){
        $('#form').submit();
    })
</script>