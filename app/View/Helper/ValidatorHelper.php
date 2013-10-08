<?php

class ValidatorHelper extends AppHelper{
    
    public $helpers = array('Html');
/**
 *  Contain field and his rule and message
 * 
 * Index Order : FormID.Model.Field.Rule
 * for example :
 *   array(
 *      'FormID' => array(
 *          'Post' => array(
 *              'title' => array(
 *                  'notempty' => array(
 *                      'rule' => array('notempty'),
 *                      'message' => 'Not Empty',
 *                  ),
 *                  'numric' => array(
 *                      'rule' => array('numric'),
 *                      'message' => 'It must be number',
 *                  ),
 *              ),
 *          ),
 *      ),
 *   )
 */
    protected $_fields = array();

/**
 *  Hold output script
 */
    protected $_output = array();
    
/**
 *  Hold id for current form
 */
    protected $_formID = null;
    
    public $defaultParams = array(
        'errorClass' => 'alert-input-error',
        'errorElement' => 'div',
    );
    
    public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);
        
        // Choose Form tag by cake rule
        $model = null;
        if (!empty($this->request->params['models'])) {
			$model = key($this->request->params['models']);
		}
        // example : ModelActionForm
        $this->_formID = $model . Inflector::camelize($this->request->params['action']).'Form'; 
	}
    
/**
 * Return validation jquery script
 * 
 * @return script block
 */
    public function validate($inline = false){
        
        $this->setDefaults();
        
        // only show func without option
        if(empty($this->_fields[$this->_formID])){
            $this->_output[] = '$("#'.$this->_formID.'").validate()';
            return $this->output();
        }
        
        
        $options = $this->_fields[$this->_formID];
        $rules = $messages = array();
        
        // for any Model
        foreach($options as $model => $fields){
            
            //for any fields for current Model
            foreach($fields as $field => $fieldRules){
                $id = "data[$model][$field]";
                
                // for any rule of current field
                foreach($fieldRules as $ruleWithMessage){
                    $rule = $ruleWithMessage['rule'];
                    $ruleValue = true;
                    
                    // if rule is array, such as: array('notempty') or array('maxLenght', 10)
                    if(is_array($rule)){
                        
                        // get value for current rule (if is specified)
                        if(! empty($rule[1])){
                            $ruleValue = $rule[1];
                        }
                        
                        // the first index is rule
                        $rule = $rule[0];
                    }
                    // we can have minlength and minLength 
                    if(!in_array($rule, array('notempty', 'minlength', 'maxlength', 'minLength', 'maxLength', 'url', 'email','equalTo'))){
                        continue;
                    }
                    switch($rule){
                        case 'notempty':
                            $rule = 'required';
                            break;
                        case 'minLength':
                            $rule = 'minlength';
                            break;
                        case 'maxLength':
                            $rule = 'maxlength';
                            break;
                    }
                    $rules[$id][$rule] = $ruleValue;
                    if(! empty($ruleWithMessage['message'])){
                        $messages[$id][$rule] = $ruleWithMessage['message'];   
                    }
                }   
            }      
        }
        // generate script
        
        $script = '$("#'.$this->_formID.'").validate({ rules :'.json_encode($rules);
        if(! empty($messages)){
            $script .= ', messages : '.json_encode($messages);
        }
        $script .= '});';
        
        // add to output
        $this->_output[] = $script;
        return $this->output($inline);
             
    }
    
/**
 * Add Rule from Model
 * 
 * @param array $fields : fields for custom validation rules
 *      example : 
 *          string : 'Model' or 'Model.field'
 *          array : array('Model', 'Model.field', 'Model' => array('field1', 'field2'))
 * @return void
 */
    public function addRule($fields = array()){

        // only write validate without option
        if(empty($fields)){
            $this->_fields[$this->_formID] = array();
            return;
        }
        
        if(is_string($fields)){
            $this->fetchValidate($fields);
        }
        
        if(is_array($fields)){
            foreach($fields as $key => $value){
                if(is_int($key)){
                    $this->fetchValidate($value);
                    continue;
                }
                
                foreach($value as $val){
                    $this->fetchValidate($key .'.'.$val);
                }
            }
        }
    }
    
    /**
     * Read validate array for specified Model and field(s)
     * 
     * @param mixed $fields : 'Model' or 'Model.field'
     * @return
     */
    public function fetchValidate($fields){
            $fields = $this->extract($fields);
            list($plugin, $model) = pluginSplit($fields['model']);
            
            // Create Object for this model
            if($plugin){
                App::import('Model', $plugin .'.'. $model);
            }else{
                App::import('Model', $model);
            }
            $modelObject = new $model;
            $validate = $modelObject->validate;
            
            //no validation
            if(empty($validate)){
                $this->_fields[$this->_formID] = array();
                return ;
            }
                
            // if has no field so submit all fields
            if(empty($fields['field'])){
                foreach($validate as $field => $validation){
                    $this->_fields[$this->_formID][$model][$field] = $validation;
                }
            }else{
                $this->_fields[$this->_formID][$model][$fields['field']] = $validate[$fields['field']];
            }
    }
    
    
/**
 * Extracting
 * 
 * @param string $modelWithField : 'Model' or 'Model.field'
 * @return array('model' => 'Model', 'field' => 'field')
 */
    public function extract($modelWithField){
        
        $return = array();
        
        $array = explode('.',$modelWithField);
        $plugins = CakePlugin::loaded();
        if(in_array($array[0], $plugins)){
            
            $return['model'] = $array[0] . '.'. $array[1];
            if(! empty($array[2])){
                $return['field'] = $array[2];    
            }
            return $return;
        }
        
        if(! empty($array[0])){
            $return['model'] = $array[0];    
        }
        
        if(! empty($array[1])){
            $return['field'] = $array[1];    
        }
        return $return;
    }
    
/**
 * Add custom rule that isn't in Model
 * 
 * @param string $element : id of specified input
 * @param string $rule : rule
 * @param string $message : message
 * @return void
 */
     public function addCustomRule($element, $rule,$value, $message){
        // for equalTo we must use another field with this code, we can point to currect field
        if(strpos($value, '#') === 0){
            $val = substr($value,1);
            $val = $this->extract($val);
            $value = '#'.$val['model']. Inflector::camelize($val['field']);
        }
        $fields = $this->extract($element);
        $this->_fields[$this->_formID][$fields['model']][$fields['field']] = array(
            $rule => array(
                'rule' => array($rule, $value),
                'message' => $message,
            ),
        );
    }
    
    public function setDefaults (){
        if($this->defaultParams){
            $output = array();
            foreach($this->defaultParams as $key => $value){
                if(strpos($value, 'function') !== false){
                    $output[] = '"'.$key.'" : '.$value;
                }else{
                    $output[] = '"'.$key.'" : "'.$value.'"';
                }
                
            }
            $this->_output[] = '$.validator.setDefaults({'.implode(',', $output).'});';
        }
    }
    
    public function beforeRender(){
        $this->Html->script('validation',false);
    }
    
    public function chooseForm($formID){
        $this->_formID = $formID;
        return true;
    }
    
    public function output($inline = false){
        if(empty($this->_output)){
            return;
        }
        $script = '';
        foreach($this->_output as $output){
            $script .= $output;
        }
        return $this->Html->scriptBlock('$(function(){'.$script.'});',array('inline' => $inline));
    }
    
    public function removeRule($field, $rule){
        $field = $this->extract($field);
        unset($this->_fields[$this->_formID][$field['model']][$field['field']][$rule]);
    }
}
