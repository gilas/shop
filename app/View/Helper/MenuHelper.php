<?php

/**
 * Menu Helper used for generating menu
 *
 * @package     Gilas
 * @author      Hamid
 * @copyright   2012
 * @version     0.1
 * @access      public
 */
class MenuHelper extends AppHelper {

    /**
     * Used Helpers
     *
     * @var array
     */
    public $helpers = array('Html');

    /**
     * Getting menu items for current $menuTypeID
     *
     * @param integer $menuTypeID  : id of MenuType Model
     * @param string  $optionDiv    : div option for output: if false so without div
     * @param string  $activeStyle : class attribute for active item
     * @return
     */
    public function getMenu($menuTypeID, $optionDiv = false, $activeStyle = null,$optionUL = array('class' => 'menu'), $options = array()) {

        $items = $this->requestAction(array('controller' => 'menus', 'action' => 'getMenu', 'admin' => false, 'plugin' => false, $menuTypeID), array('named' => $options));
        $output = $this->__generateMenu($items, $activeStyle, $optionUL);
        if(! $optionDiv){
            return $output;
        }
        $classDiv = false;
        if(!empty($optionDiv['class'])){
            $classDiv = $optionDiv['class'];
            unset($optionDiv['class']);
        }
        return $this->Html->div($classDiv, $output, $optionDiv);
    }

    /**
     * Generate recursive menu items
     *
     * @param array  $menus       : items
     * @param string $activeStyle : class attribute for active item
     * @return ul li tag
     */
    private function __generateMenu($menus, $activeStyle, $optionUL) {
        $output = null;
        if ($menus) {
            foreach ($menus as $menu) {
                $child = null;
                $class = null;
                if ($menu['children']) {
                    $child = $this->__generateMenu($menu['children'], $activeStyle, array('class' => 'sub-menu') );
                }
                if ($child) {
                    $class = 'parent';
                    //Add activeStyle to parent if child is active
                    if(strpos($child, $activeStyle) !== false){
                        $class .= ' '.$activeStyle;
                    }
                }
                $here = $this->request->here(false);
                $url = urlencode($menu['Menu']['link']);
                $url = str_replace('%2F','/',$url);
                $output .= $this->Html->tag('li', $this->Html->link($menu['Menu']['title'], $menu['Menu']['link'], array('class' => ($here == $url) ? $activeStyle : '')) . $child, array('class' => ($here == $url) ? $activeStyle : $class));
            }
        }
        return $this->Html->tag('ul', $output, $optionUL);
    }

}