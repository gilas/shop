<?php

class ShopHelper extends AppHelper {
    
    public $helpers = array('Html');
    public function beforeRender(){
        $this->Html->css('/Shop/css/style', null, array('inline' => false));
    }
    
    public function namedPrice($price){
        // change to string for using array
        $price = (string)$price;
        $length = strlen($price);
        
        // reorder price
        $number = array();
        for($i = $length; $i > 0; $i--){
            $number[$i] = $price[$length - $i];
        }
        
        $return = '';
        foreach($number as $index => $value){
            // using another dahgan where dahgan is 1
            if((in_array($index, array(2,5,8,11,14)) and  $number[$index] == 1) or (in_array($index, array(1,4,7,10,13)) and @$number[$index + 1] == 1 )){
                if(in_array($index, array(1,4,7,10,13))){
                    continue;
                }
                $return .= $this->_getDahValue($value.$number[$index - 1], $index);
                $return .= $this->_addVa($number, $named, $index);
                continue;
            }
            
            $named = $this->_getNamedValue($value, $index);
            $return .= $named;
            $return .= $this->_addVa($number, $named, $index);
        }
        return $return;
    }
    
    protected function _addVa($number, $setted, $index){
        $remain = ($index - 1) % 3;
        if($remain == 2){
            if($number[$index - 1] == 0 and $number[$index - 2] == 0){
                return '';
            }
        }
        if($remain == 1){
            if($number[$index - 1] == 0){
                return '';
            }
        }
        $return = '';
        $isEmpty = false;
        switch($index){
            case 4: 
                if(!empty($number[4]) or !empty($number[5]) or !empty($number[6])){
                    $return .= 'هزار ';
                }else{
                    $isEmpty = true;
                }
                break;
            case 7: 
                if(!empty($number[7]) or !empty($number[8]) or !empty($number[6])){
                    $return .= 'میلیون ';
                }else{
                    $isEmpty = true;
                }
                break;
            case 10: 
                if(!empty($number[10]) or !empty($number[11]) or !empty($number[12])){
                    $return .= 'میلیارد ';
                }else{
                    $isEmpty = true;
                }
                break;
            case 13: 
                if(!empty($number[13]) or !empty($number[14]) or !empty($number[15])){
                    $return .= 'هزار میلیارد ';
                }else{
                    $isEmpty = true;
                }
                break;
        }
        foreach($number as $i => $n){
            if($i >= $index){continue;}
            if($n != '0' and !empty($setted)){
                if(!$isEmpty){
                    $return .= 'و ';
                    break;
                }
                    
            }
        }
        return $return;
    }
    protected function _getDahValue($value, $index){
        $return = '';
        switch($value){
            case 10: $return = 'ده ';break;
            case 11: $return = 'یازده ';break;
            case 12: $return = 'دوازده ';break;
            case 13: $return = 'سیزده ';break;
            case 14: $return = 'چهارده ';break;
            case 15: $return = 'پانزده ';break;
            case 16: $return = 'شانزده ';break;
            case 17: $return = 'هفده ';break;
            case 18: $return = 'هجده ';break;
            case 19: $return = 'نوزده ';break;
        }
        switch($index){
            case 5: $return .= 'هزار '; break;
            case 8: $return .= 'میلیون '; break;
            case 11: $return .= 'میلیارد '; break;
            case 14: $return .= 'میلیارد '; break;
        }
        return $return;
    }
    
    protected function _getNamedValue($value, $index){
        switch($index){
            case 1:case 4:case 7:case 10:case 13: return $this->_getYekanValue($value);
            case 2:case 5:case 8:case 11:case 14: return $this->_getYekanValue($value);
            case 3:case 6:case 9:case 12:case 15: return $this->_getYekanValue($value);
        }
    }
    
    protected function _getYekanValue($value){
        switch($value){
            case 1: return 'یک ';
            case 2: return 'دو ';
            case 3: return 'سه ';
            case 4: return 'چهار ';
            case 5: return 'پنج ';
            case 6: return 'شش ';
            case 7: return 'هفت ';
            case 8: return 'هشت ';
            case 9: return 'نه ';
        }
        return '';
    }
    protected function _getDahganValue($value){
        switch($value){
            case 2: return 'بیست ';
            case 3: return 'سی ';
            case 4: return 'چهل ';
            case 5: return 'پنجاه ';
            case 6: return 'شصت ';
            case 7: return 'هفتاد ';
            case 8: return 'هشتاد ';
            case 9: return 'نود ';
        }
        return '';
    }
    protected function _getSadganValue($value){
        switch($value){
            case 1: return 'یکصد ';
            case 2: return 'دویست ';
            case 3: return 'سیصد ';
            case 4: return 'چهارصد ';
            case 5: return 'پانصد ';
            case 6: return 'ششصد ';
            case 7: return 'هفتصد ';
            case 8: return 'هشتصد ';
            case 9: return 'نهصد ';
        }
        return '';
    }
}