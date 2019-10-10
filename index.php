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

	// create oprions object
	$options = new news\Options($options);


	// memberaccess installed
	// and logged
	// and user is in news access group
	if (class_exists("ma\Access") && ma\Access::user() && ma\Groups::user_is_in_group(ma\Access::user()->username(), news\Config::config("access_admin_group"))) {

		$options->set("edit", "true");
	}

	// render notes
	$o .= news\News::render($category, $options);

	return $o;
}