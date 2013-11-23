<?php

/**
 * Filter Helper class used for filtering form in pages that must have pagination and limitation
 * 
 * @package     Gilas
 * @author      Hamid Mamdoohi
 * @copyright   2012
 * @version     0.1
 * @access      public
 */
class FilterHelper extends AppHelper{
    
/**
 * Used Helpers
 *
 * @var array
 */
    public $helpers = array('Html','Form','Paginator');

/**
 * Hold Paginator->params
 * 
 * @var array
 */
    public $paginParams = array();
    
/**
  * Hold action for form
  * 
  * @var string
  */
    public $action = null;
    
/**
  * Hold class for form
  * 
  * @var string
  */
    public $formClass = 'form-filter';
    
    public function __construct(View $view, $settings = array()) {
        parent::__construct($view, $settings);
        $this->paginParams = $this->Paginator->params();
    }
    
/**
 * use this method againest Form->create
 * 
 * @param mixed $model
 * @param mixed $options
 * @return
 */
    public function create($model = null, $options = array()) {
        $options['type'] = 'get';           // use GET method in filtering form
        $options['class'] = $this->formClass ;  // use this class
        $this->action = $options['action']; // we must indicate action when define form
        return $this->Form->create($model,$options);
    }
    
/**
 * use this method againest Form->input
 * 
 * @param mixed $fieldName
 * @param mixed $options
 * @return
 */
    public function input($fieldName, $options = array()) {
        // because data sent with GET , we need indicate this index to set sent value
        if($this->paginParams['paramType'] == 'named'){
            $options['value'] = @$this->request->named[$fieldName];
        }else{
            $options['value'] = @$this->request->query[$fieldName];
        } 
        
        return $this->Form->input($fieldName,$options);
    }
    
/**
 * use this method againest Form->end
 * 
 * @param mixed $options
 * @return
 */
    public function end($options = array()) {
        
        // must be use this link for erase all fields
        $link = $this->Html->link('پاکسازی',array('action' => $this->action),array('class' => 'btn'));
        $link = $this->Html->div('reset', $link);
        
        if(is_array($options)){
            $options +=array('label' => 'جستجو', 'class' => 'btn');
        }
        
        $submit = $this->Form->submit($options['label'], $options);
        $end = $this->Form->end();
        
        $output = $submit . $link . $end;
        
        if($this->paginParams['paramType'] == 'named'){
            $output .= $this->__namedScript();;
        }
        
        return $output;
    }
    
/**
 * when paramType is named we must use script for sending data with named format 
 * 
 * @return script tag
 */
    private function __namedScript(){
        $url = $this->getUrl(false);
        
        $script = "
            $(function(){
                $('.{$this->formClass}').submit(function(){
                    fields = $(this).serializeArray()
                    url = '{$url}'
                    $.each(fields,function(i,field){
                        if(field.value.length > 0){
                            url += '/' + field.name + ':' + field.value
                        }
                    })
                    window.location.href = url;
                    return false
                })
            })
        ";
        return $this->Html->scriptBlock($script);
    }
    
/**
 * Show select tag for choosing limit
 * 
 * @return select tag
 */
    public function paginLimit(){
        if(empty($this->paginParams['count'])){
            return;
        }
        $options = array(
            array('name' => 5,  'value' => 5),
            array('name' => 10, 'value' => 10),
            array('name' => 15, 'value' => 15),
            array('name' => 20, 'value' => 20),
            array('name' => 25, 'value' => 25),
            array('name' => 30, 'value' => 30),
            array('name' => 35, 'value' => 35),
            array('name' => 50, 'value' => 50),
            array('name' => 100, 'value' => 100),
            array('name' => 'همه', 'value' => $this->paginParams['count']),
            );
            
        $select = $this->Form->select('limit',$options,array(
            'id' => 'limit',
            'value' => $this->paginParams['limit'],
            'empty' => false,
        ));
        $label = $this->Html->tag('label','نمایش');
        $div = $this->Html->div('page-limit form-filter',$label.$select);
        return $div.$this->__limitScript();
    } 
    
/**
 * Script for paginLimit 
 * 
 * @return
 */
    private function __limitScript(){
        $script = '';
        if($this->paginParams['paramType'] == 'named'){
            $urlPage = $this->getUrl(true);
            // Output
            $script .= "url = '$urlPage';";
            $script .= "url += '/limit:'+$(this).val();";
            if(! empty($this->request->query)){
                $script .= 'url += "?'.http_build_query($this->request->query).'";';
            }
            $script .= 'window.location.href = url;';
            
        }elseif($this->paginParams['paramType'] == 'querystring'){
            $urlOption = $this->request->query; 
            unset($urlOption['page'],$urlOption['limit']);
            $urlPage = $this->Html->url(array('?' => $urlOption));
            $urlPage = str_replace('&amp;','&',$urlPage);
            
            //Output
            $script = "
                url = '{$urlPage}';
                if(url.indexOf('?') != -1){
                    url += '&limit='+$(this).val();
                }else{
                    url += '?limit='+$(this).val();
                }
                window.location.href = url;
            ";
        }
        return $this->Html->scriptBlock("\$(function(){\$('#limit').change(function(){{$script}})})");
    }
    
/**
 * Paginator Links
 * 
 * @return
 */
    public function paginator($options = array()){
        if($this->paginParams['pageCount'] <= 1){
            return;
        }
        if($this->paginParams['paramType'] == 'named'){
            $this->Paginator->options(array('url' => array_merge($this->request->named, $this->request->pass)));
        }else{
            $this->Paginator->options(array('url' => array_merge($this->request->pass, array('?' => $this->request->query))));
        }
        if($options){
            $this->Paginator->options($options);
        }
        $ul = '<ul>'.
              $this->Paginator->first('→',array('tag' => 'li'),null,array('class' => 'disabled','tag' => 'li')).
              $this->Paginator->prev('«',array('tag' => 'li'),null,array('class' => 'disabled','tag' => 'li')).
              $this->Paginator->numbers(array('class' => 'page','tag' => 'li','currentClass' => 'active','separator' => ' ')).
              $this->Paginator->next('»',array('tag' => 'li'),null,array('class' => 'disabled','tag' => 'li')).
              $this->Paginator->last('←',array('tag' => 'li'),null,array('class' => 'disabled','tag' => 'li')).
              '</ul>';
        $span = $this->Html->tag('span',$this->Paginator->counter('صفحه {:page} از {:pages}'),array('class' => 'pages'));
        return $this->Html->div('pagination',$ul . $span);
    }
    
/**
 * Use this method for every page that want have limit and paginator
 * 
 * @return
 */
    public function limitAndPaginate(){
        return $this->Html->div('clearfix','').$this->paginLimit().$this->paginator();
    }
    
    
/**
 * When paramType is named for scripts we must have appropiate url,
 * this method return best url for our scripts
 * 
 * @param bool $withNamed, if we want have named params, set this true 
 * @return url string
 */
    public function getUrl($withNamed = false){
        $url =  Router::url();//get This url
        $url = substr($url,strpos('?',$url));//escape querystring
        $url = rtrim($url,'/');// delete slash trail
        $named = $this->request->named;
        $pass = $this->request->params['pass'];
        $urlWitoutNamed = $url;
        // remove named params from url
        if($named){
            foreach($named as $key => $value){
                // we may have more than one named param with one key, so we recieve first param
                if(is_array($value)){
                    $value = array_shift($value);
                }
                // url have encoding param,
                $key = rawurlencode($key);
                $value = rawurlencode($value);
                
                // if exist in url, because we can add param to request in program
                if(preg_match("/$key:$value/",$url)){
                    // remove only page and limit
                    if($key == 'page' || $key == 'limit'){
                        $url = str_replace("/$key:$value",'',$url);
                    }
                    $urlWitoutNamed = str_replace("/$key:$value",'',$urlWitoutNamed);
                }else{
                    // add index trailer to url
                    if(empty($pass) 
                        and strpos(':', $url) === false 
                        and (
                            $this->request->params['action'] == 'index' 
                            or $this->request->params['action'] == $this->request->params['prefix'].'_index'
                        )
                    ){
                        $url .= '/index';
                    }
                    // otherwise add it
                    $url .= "/$key:$value";
                }
                
            }
        }
        
        $trail = '';
        // because if action is index url escape it we must add it in url
        $action = $this->request->params['action'];
        if(($action == 'index')){
            $trail = '/index';
        }elseif(strpos($action,'_')){
            if($this->request->params['prefix'].'_index' == $action){
                $trail = '/index';
            }
        }
        // so add trail to url in url has no pass params
        if($trail and empty($pass)){
            if(strpos($urlWitoutNamed,$trail,strlen($urlWitoutNamed) - 6) === false){
                $urlWitoutNamed .= $trail;
            }  
        }
        // replace to url if this url has no pass and named params
        if(empty($pass) and empty($named)){
            $url = $urlWitoutNamed;
        }
        
        if($withNamed){
            return $url;
        }
        return $urlWitoutNamed;
    }
    
/**
 * this is used for pagination
 * in pagination the helper removed all params from url 
 * for adding we must set params to pagination option
 * this function used for this goal
 * @param $pass  : Add pass params
 * @param $named : Add named params
 * @param $query : Add query params
 * @return return an array that must be set in Paginator::options
 */
    public function getParam($pass = true, $named = true, $query = true ){
        $url = array();
        if($pass){
            if($this->request->params['pass']){
                foreach($this->request->params['pass'] as $value){
                    $url[] = $value;
                }
            }
        }
        if($named){
            if($this->request->named){
                foreach($this->request->named as $key => $value){
                    $url[$key] = $value;
                }
            }
        }
        if($query){
            $url['?'] = $this->request->query;
        }
        return $url;
    }
}