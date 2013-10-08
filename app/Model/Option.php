<?php

/**
 * Option Model
 *  We have some options in all app that must be dynamic
 *  such as warden, inquiries and so on
 *  We can save option in one table and with one field (section) relate it to owner table
 * 
 * @package Gilas
 * @author Hamid
 * @copyright 2013
 * @version $Id$
 * @access public
 */
class Option extends AppModel {
    
    public $displayField = 'name';
}

?>
