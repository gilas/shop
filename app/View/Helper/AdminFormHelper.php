<?php

/**
 * AdminForm Helper class, is a easy way for managering
 * With this class we can select or deselect items, and doing actions for selected items 
 * 
 * @package     Gilas
 * @author      Hamid Mamdoohi
 * @copyright   2012
 * @version     0.1
 * @access      public
 */
class AdminFormHelper extends AppHelper{

/**
 * Used Helpers
 *
 * @var array
 */
    public $helpers = array('Html','Form');
    
/**
 * Special keys that used in url parameter in methods
 *
 * @var array
 */
    public $keys = array(
        'action',       // action method that data must be send to it
        'firstChild',   // true | false : true = send first selected item, false = send all 
        'method',       // post|get : sending method
        'extraField',   // extra fields that must be send with cuurent request
        'confirm',        // Show confirm alert
    );
 
/**
 * Hold added items to toolbar
 *
 * @var array
 */
    public $items = array();
 
 /**
 * Index of checkbox for any row
 * with this we create difference id for any checkbox in row,
 * starts by -1, because by first calling it increase
 * 
 * @var integer
 */
    private $__index = -1;
    
/**
 * Add item to toolbar row and create 'a' tag for this item 
 * 
 * @param mixed $title : title of item
 * @param mixed $url    : url of item, this param used for option of $.adminForm
 * @param mixed $options : options for this tag
 * @return void
 */
    public function addToolbarItem($title, $url , $options = array(), $liOptions = array()){
        
        if(!empty($options['isParent']))// is parent, so this option is handle of this parent
        {
            $parent_name = $options['isParent'];
            unset($options['isParent']);
            $url = '#';
            $this->items[$parent_name] = compact('title', 'url', 'options', 'liOptions');

        }elseif(!empty($options['parent']))// is child, so this option specify his parent
        {
            $parent_name = $options['parent'];
            unset($options['parent']);
            $this->items[$parent_name]['child'][] = compact('title', 'url', 'options', 'liOptions');
            
        }else{
            $this->items[] = compact('title', 'url', 'options', 'liOptions');
        }
    }
        
/**
 * Show toolbar
 * 
 * @param mixed $title : Title for current toolbar
 * @param bool $return : true | false : true = return output, false : echo output
 * @return output
 */
    public function showToolbar($title, $return = false){
        if(empty($this->items)){
            return false;
        }
        $output = '';
        foreach($this->items as $item){
            // add class
            $options = $item['liOptions'];
            
            if(!empty($item['child'])){
                $options['class'] = @$options['class'] . ' dropdown';
            }
            $output .= $this->Html->tag('li',$this->__createItem($item), $options);
        }
        $toolbar = $this->Html->tag('ul',$output, array('id' => 'toolbar'));
        $title = $this->Html->div('title', $title);
        $output = $this->Html->div('row',$title . $toolbar,array('id' => 'toolbar-menu'));
        if($return){
            return $output;
        }
        echo $output;
        
    }

/**
 * Generate 'a' tag for current $item
 * 
 * @param array $item : contain all parameters of self::addToolbarItem() in one array
 * @param bool $inToolbar: true | false : true = this item used in toolbar, false = this item used in row
 * @return 'a' tag
 */
    private function __createItem($item,$inToolbar = true){
        extract($item);
        $childs = '';
        if(!empty($item['child'])){
            foreach($item['child'] as $child){
                $childs .= $this->Html->tag('li',$this->__createItem($child), $child['liOptions']);
            }
        }
        if($url === false){
            return $title;
        }
        // Normal Link
        if(!empty($url['normalLink']) or is_string($url)){
            if(is_array($url)){
                unset($url['normalLink']);
                if (!empty($this->request->named['layout'])) {
                    $url['layout'] = 'iframe';
                }
            }
            if(!empty($childs)){
                $ul = $this->Html->tag('ul',$childs, array('class' => 'dropdown-menu'));
                $options['data-toggle'] = 'dropdown';
                $options['class'] = 'dropdown-toggle ' . @$options['class'] ;
                $link = $this->Html->link($title, $url,$options);
                return $link . $ul;
            }
            return $this->Html->link($title, $url,$options); 
        }
        
        // iframe Link
        if(!empty($url['layout'])){
            if($url['layout'] == 'iframe'){
                return $this->_createIframe($title, $url,$options);
            }
            return $this->_createIframe($title, $url,$options);
        }
        if(is_array($url)){
            $extraField = array();
            foreach($url as $key => $value){
                if(!in_array($key,$this->keys) || is_int($key)){
                    $extraField[$key] = $value;
                    unset($url[$key]);
                }
            }
            if(! empty($url['extraField'])){
                $extraField = Set::merge($extraField,$url['extraField']);
            }
            if(! empty($extraField)){
                $url['extraField'] = $extraField;
            }
            if (!empty($this->request->named['layout'])) {
                    $url['layout'] = 'iframe';
                }
            
        }  
        $url = json_encode($url);
        // replace " with '
        $url = str_replace('"',"'",$url);
        $options['onclick'] = '$.adminForm('.$url.');';
        if(! $inToolbar){
            $options['onclick'] = '$.adminForm.chooseCb(this);'.$options['onclick'];    
        }
        return $this->Html->link($title, 'javascript:void(0);',$options);     
    }
    
/**
 * Return start 'form' tag 
 * 
 * @return 'form' tag
 */
    public function startFormTag($model = null){
        return $this->Form->create($model,array('action' => 'dispatch','id' => 'adminForm'));
    }
    
/**
 * Return checkbox that with it, we can (select| deselect) all rows
 * 
 * @return 'checkbox' tag 
 */
    public function selectAll(){
        return $this->Html->useTag('input',null,array('type' => 'checkbox', 'class' => 'selectAll'));
    }
    
/**
 * Return checkbox for current row
 * 
 * @param number $id : ID of current row
 * @return 'checkbox' tag 
 */
    public function checkbox($id){
        // increase for this index
        $this->__index ++;
        
        $tagID = 'cb'.$this->__index;
        return $this->Html->useTag('input','id[]',array('type' => 'checkbox', 'value' => $id,'id' => $tagID));
    }
    
/**
 * We can use items for any row as same as toolbar item,
 * items is same self::addToolbarItem()
 * 
 * @param mixed $title
 * @param mixed $url
 * @param mixed $options
 * @return
 */
    public function item($title, $url,  $options = array()){
        $item = compact('title', 'url', 'options');
        return $this->__createItem($item,false);
    }
    
/**
 * Add script to document
 * 
 * @return void
 */
    public function beforeRender(){
        $this->Html->script('adminform',false);
    }
    
/**
 * Return end 'form' tag
 * 
 * @return
 */
    public function endFormTag(){
        return $this->Form->end();
    }
    protected $_modalCount = 0;
    public function _createIframe($title, $url, $options){
        //$options['id'] = 'modal'.$this->_modalCount++;
//        $script = '$.modal("<iframe width=\"500px\" height=\"400px\" style=\"border:none\"  src=\"'.$this->Html->url($url).'\" />",{overlayClose:true,minHeight:400,minWidth:500});';
//        $this->Html->script('modal', false);
//        $this->Html->css('modal', null, array('inline' => false));
//
//        $this->Html->scriptBlock("\$(function(){\$('#{$options['id']}').click(function(){{$script} return false;})})", array('inline' => false));
//        return $this->Html->link($title, $url, $options);

        $options['id'] = 'modal'.$this->_modalCount++;
        $this->Html->script('fancybox', false);
        $this->Html->css('fancybox', null, array('inline' => false));
        $script = "$(function(){
            $('#".$options['id']."').fancybox({
                'width' : '75%',
                'height' : '75%',
                'autoScale' : false,
                'transitionIn' : 'none',
                'transitionOut' : 'none',
                'type' : 'iframe'
            }); 
        })";
        $this->Html->scriptBlock($script, array('inline' => false));
        return $this->Html->link($title, $url, $options);
    }
}
