<?php
$this->Html->addCrumb('تنظیمات');
echo $this->Form->create('Setting', array('class' => 'form-horizontal'));
?>
<div id="toolbar-menu" class="row">
    <div class="title">تنظیمات</div>
    <ul id="toolbar">
        <li>
            <a onclick="$(this).parents('form').submit();" class="btn btn-success" tooltip-place="bottom" data-original-title="ذخیره" rel="tooltip" >
                <i class="icon-ok icon-white"></i><input type="submit" style="display: none;" />
            </a>
        </li>
        <li>
            <a <?php if(!empty($this->request->named['layout'])) echo 'href="#" onclick="window.parent.closeModal();return false;"'; else echo 'href="'.$this->Html->url(array('controller' => 'dashboards')).'"'; ?> class="btn btn-danger" tooltip-place="bottom" data-original-title="انصراف" rel="tooltip" >
                <i class="icon-remove icon-white"></i>
            </a>
        </li>
        <li>
            <a <?php echo 'href="'.$this->Html->url(array('action' => 'clearCache')).'"'; ?> class="btn btn-warning" tooltip-place="bottom" data-original-title="پاکسازی کش" rel="tooltip" >
                <i class="icon-refresh icon-white"></i>
            </a>
        </li>
    </ul>
</div>
<?php
if($settings){
    echo '<ul class="nav nav-tabs">';
    $firstChild = true;
    foreach($settings as $key => $setting){
        echo '<li '.(($firstChild)?'class="active"':'').'>';
            echo $this->Html->link($namedSection[$key],'#'.$key,array('data-toggle' => 'tab'));
        echo '</li>';
        $firstChild = false;
    }
    echo '</ul>';
    
    echo '<div class="tab-content">';
    $firstChild = true;
    foreach($settings as $key => $setting){
        echo "<div id='$key' class='tab-pane fade ".(($firstChild)?'active in':'')."'>";
        foreach($setting as $k => $s){
            echo $this->Form->input($k, array( 'label' => array('text' => $s['alias'], 'class' => 'control-label') ,'value' => $s['value'],'style' => 'width:75%;margin-right:17px', 'options' => @$s['params']['options'], 'class' => 'control-input', 'div' => array('style' => 'margin:15px 0;')));
        }
        echo '</div>';   
        $firstChild = false;     
    }
    echo '</div>';
}
echo $this->Form->end();
?>