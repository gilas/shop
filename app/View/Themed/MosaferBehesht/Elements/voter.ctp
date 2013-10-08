<?php 

$vote =  $this->requestAction('/polls/vote',array('return')) ;
if(empty($vote)) return;
?>
<div id="voter"><?php echo $vote ?></div>
<script>
    $(function(){
        if($('#voter').html()){
            $('#voter').show();
        }
    })
</script>