<?php 
$categories = $this->requestAction(array('plugin' => 'Shop', 'controller' => 'Categories', 'action' => 'getList'));
echo $this->Html->script('/Shop/js/jquery.jstree') ;
echo $this->Html->css('/Shop/css/jstree/default-rtl/style') ;
?>
<input id="searchCategoryInput" style="width: 125px;" />
<a id="submitCategory" class="btn">جستجو</a>
<div id="listCategory">
<?php
echo $this->Html->generateList($categories, 'Category.name',array('plugin' => 'Shop', 'controller' => 'Categories', 'action' => 'view'), 'active');
?>
</div>
<script  type="text/javascript" >
    $("#submitCategory").click(function () {
        $("#listCategory").jstree("search",$('#searchCategoryInput').val());
    });
    $("#listCategory").jstree({
        "core" : { "initially_open" : [ "selectedList" ] },
        "themes":{
            "theme" : "default-rtl",
            "icons" : false
        },
        "plugins" : [ "themes", "html_data", "search" ]
    })
</script>