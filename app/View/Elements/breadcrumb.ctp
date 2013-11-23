<?php
$crumbs = $this->Html->getCrumbs('&ac;',array('text' => 'داشبورد', 'url' => array('controller' => 'Dashboards', 'action' => 'index', 'plugin' => false) ));
$crumbs = explode('&ac;',$crumbs);

// only has Dashboard link
if(count($crumbs) == 1){
    return;
}
?>
<div class="breadcrumb">
<?php 
foreach($crumbs as $k => $crumb){
    if(isset($crumbs[$k + 1])){
        echo $crumb . '<span class="divider">/</span>';
    }else{
        echo $crumb;
    }
} 
?>
</div>