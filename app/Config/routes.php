<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));



Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
Router::connect('/Pages/*', array('controller' => 'Pages', 'action' => 'display'));

Router::connect('/Contents/view/:id-:slug', 
    array('controller' => 'Contents', 'action' => 'view'),
    array(
        'pass' => array('id'),
        'id' => '[0-9]+'
    )
);

Router::connect('/Contents/category/:id-:slug', 
    array('controller' => 'Contents', 'action' => 'category'),
    array(
        'pass' => array('id'),
        'id' => '[0-9]+'
    )
);
/**
 * show profile of any user
 * use * because we send other parameters to this link
 */
Router::connect('/~:username/*', 
	array('controller' => 'Profile', 'action' => 'view'),
	array(
        'pass' => array('username'),
        'username' => '[a-z|A-Z|0-9]+'
    )
);

Router::parseExtensions('rss');
/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
$prefixes = Router::prefixes();

// Get route from Setting
$adminPrefix = SettingsController::read('Site.AdminAddress');
Router::connect("/{$adminPrefix}", array('controller' => 'Dashboards', 'action' => 'index', 'admin' => true));
Router::connect("/profile", array('controller' => 'Dashboards', 'action' => 'profile', 'admin' => false));

// Route plugins
if ($plugins = CakePlugin::loaded()) {
	App::uses('PluginShortRoute', 'Routing/Route');
	foreach ($plugins as $key => $value) {
		$plugins[$key] = Inflector::underscore($value);
        $plugins[] = $value;
	}
	$pluginPattern = implode('|', $plugins);
	$match = array('plugin' => $pluginPattern);
	$shortParams = array('routeClass' => 'PluginShortRoute', 'plugin' => $pluginPattern);
	foreach ($prefixes as $prefix) {
	   
       	$params = array('prefix' => $prefix, $prefix => true);
	    $indexParams = $params + array('action' => 'index');    
        if($prefix == 'admin'){
            Router::connect("/{$adminPrefix}/:plugin", $indexParams, $shortParams);
            Router::connect("/{$adminPrefix}/:plugin/:controller", $indexParams, $match);
            Router::connect("/{$adminPrefix}/:plugin/:controller/:action/*", $params, $match);
	   	}else{             
    		Router::connect("/{$prefix}/:plugin", $indexParams, $shortParams);
    		Router::connect("/{$prefix}/:plugin/:controller", $indexParams, $match);
    		Router::connect("/{$prefix}/:plugin/:controller/:action/*", $params, $match);
        }
	}
	Router::connect('/:plugin', array('action' => 'index'), $shortParams);
	Router::connect('/:plugin/:controller', array('action' => 'index'), $match);
	Router::connect('/:plugin/:controller/:action/*', array(), $match);
}

// Route other urls
foreach ($prefixes as $prefix) {
    $params = array('prefix' => $prefix, $prefix => true);
	$indexParams = $params + array('action' => 'index');
    if($prefix == 'admin'){
       Router::connect("/{$adminPrefix}/:controller", $indexParams);
	   Router::connect("/{$adminPrefix}/:controller/:action/*", $params);
   	}else{
        Router::connect("/{$prefix}/:controller", $indexParams);
        Router::connect("/{$prefix}/:controller/:action/*", $params);
   	}
}
Router::connect('/:controller', array('action' => 'index'));
Router::connect('/:controller/:action/*');



$namedConfig = Router::namedConfig();
if ($namedConfig['rules'] === false) {
	Router::connectNamed(true);
}

// remove all defined vars
unset($namedConfig, $params, $indexParams, $prefix, $prefixes, $shortParams, $match,
	$pluginPattern, $plugins, $key, $value, $adminPrefix);