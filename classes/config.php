<?php

namespace news;

class Config {

	private static $config;


	// init config
	public static function init($data) {
		self::$config = $data["news"];
	}


	// get config parameter
	public static function config($name = false) {

		if (isset(self::$config[$name])) {
			return self::$config[$name];
		}

		elseif ($name === false) {
			return self::$config;
		}

		else {
			return false;
		}
	}
}

?>