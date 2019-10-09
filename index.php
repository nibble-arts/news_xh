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
function news($category = false, $options = false) {

	$o = "";

	// memberaccess installed
	if (class_exists("ma\Access") && ma\Access::user()) {
		$o .= news\View::add_note();
	}

	$o .= news\News::render($category, $options);

	return $o;
}