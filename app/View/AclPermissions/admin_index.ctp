<?php
$this->Html->addCrumb('مدیریت سطح دسترسی');
// Add
$this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-refresh icon-white')),array('action' => 'sync','normalLink' => true ),array('class' => 'btn btn-success','escape' => false, 'rel' => 'tooltip','data-original-title' => 'بروزرسانی','tooltip-place' => 'bottom'));
// Add
foreach($aros as $aro_id => $aro){
    $parent_handle = 'parent'. $aro_id; 
    $this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-user icon-white')),array('action' => 'add','normalLink' => true ),array('class' => 'btn btn-info','escape' => false,'isParent' => $parent_handle, 'rel' => 'tooltip','data-original-title' => $aro,'tooltip-place' => 'top'));
    $this->AdminForm->addToolbarItem($aro,false,array('parent' => $parent_handle), array('class' => 'nav-header'));
    $this->AdminForm->addToolbarItem(null,'#',array('parent' => $parent_handle), array('class' => 'divider'));
    $this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-ok')). ' صدور مجوز',array('action' => 'editPermission', 'aro' => $aro_id,'type' => 'on'),array('parent' => $parent_handle,'escape' => false, ));
    $this->AdminForm->addToolbarItem($this->Html->tag('i','',array('class' => 'icon-remove')). ' لغو مجوز',array('action' => 'editPermission', 'aro' => $aro_id,'type' => 'off'),array('parent' => $parent_handle,'escape' => false,));
}
//Show toolbar
$this->AdminForm->showToolbar('مدیریت سطح دسترسی');
$actions = array();
$controller = '' ;
foreach($acos as  $aco_id => $aco){
    if(substr_count($aco,'_') == 0){
        $controller = $aco;
    }elseif(substr_count($aco,'_') == 1 and strpos(@$acos[$aco_id + 1],'__') === 0){
        $actions[$controller][$aco_id]['plugin_controller'] = true;
        $actions[$controller][$aco_id]['name'] = $aco;
    }else{
        $actions[$controller][$aco_id] = $aco;
    }
}
echo $this->AdminForm->startFormTag('AclPermission');
?>
<div class="tabbable tabs-right">
    <ul class="nav nav-tabs" style="margin-left: 0;height: 450px;overflow-y: scroll;overflow-x: hidden;">
        <?php $flag = true; foreach($actions as $controller => $action): ?>
            <li <?php if($flag){echo 'class="active"';$flag = false;} ?> ><a data-toggle="tab" href="#<?php echo $controller?>"><?php echo $controller?></a></li>
        <?php endforeach; ?>
    </ul>
    <div class="tab-content" style="clear: none;border:none;padding:0;">
        <?php $flag = true; foreach($actions as $controller => $action): ?>
            <div id="<?php echo $controller?>" class="tab-pane  <?php if($flag){echo 'active';$flag = false;} ?>">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="col-checkbox"><?php echo $this->AdminForm->selectAll() ?></th>
                            <th style="width: 150px;">تابع</th>
                            <?php
                            foreach($aros as $aro){
                                echo $this->Html->tag('th',$aro);
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach($action as $aco_id => $aco){
                                if(is_array($aco)){
                                    echo '<tr class="Controller">';
                                        echo $this->Html->tag('td','');
                                        echo $this->Html->tag('td', ltrim($aco['name'],'_'),array('colspan' => '15'));
                                    echo '</tr>';
                                    continue;                                    
                                }
                                    echo '<tr>';
                                    echo $this->Html->tag('td', $this->AdminForm->checkbox($aco_id),array('id' => 'grid-align'));
                                    echo $this->Html->tag('td',ltrim($aco,'_'));
                                    foreach($permissions[$aco_id] as $aro_id => $permission){
                                        echo '<td id="grid-align">';
                                        if($permission){
                                            // Published
                                            echo $this->AdminForm->item(
                                                $this->Html->image('tick.png'),//title
                                                array('action' => 'editPermission', 'aro' => $aro_id,'type' => 'off'),// url
                                                array('escape' => false, 'class' => 'btn active btn-small')//option
                                            );
                                        }else{
                                            // Non Published
                                            echo $this->AdminForm->item(
                                                $this->Html->image('publish_x.png'),
                                                array('action' => 'editPermission', 'aro' => $aro_id,'type' => 'on'),
                                                array('escape' => false, 'class' => 'btn btn-small')//option
                                            );
                                        }
                                        echo '</td>';
                                    }
                                echo '</tr>'; 
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php echo $this->AdminForm->endFormTag();// end form tag ?>
<style>
    .Controller td {
        background-color: #919191 !important;
        color: #FFF;
    }
</style>