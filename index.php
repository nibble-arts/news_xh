<?php

/* CMSimple_XH plugin
 * news
 * (c) 2019 Thomas Winkler
 *
 * News system
 */

// plugin base path
define('NEWS_PLUGIN_BASE', $pth['folder']['plugin']);


// init class autoloader
spl_autoload_register(function ($path) {


	if ($path && strpos($path, "news\\") !== false) {
		$path = "classes/" . str_replace("news\\", "", strtolower($path)) . ".php";
		include_once $path; 
	}
});



// init news class
news\News::init($plugin_cf, $plugin_tx);


// ================================
// main plugin function call
function news($function = false, $options) {

	$o = "";
	$edit = false;

// debug($options);


	// memberaccess installed
	if (class_exists("ma\Access")) {
		// $o .= "Member access plugin found";

		// check if write permission from memberaccess is granted
		// $edit = admin group || false
		if (ma\Access::user()) {
			$edit = ma\Access::user()->is_in_group(news\Config::config("access_admin_group"));

			$o .= "EDIT";
		}
	}


	return $o;
}