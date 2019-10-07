<?php

namespace news;

class News {


	private static $data;


	public static function init($config, $text) {

		Config::init($config);
		View::init($text);

		Notes::load(Config::config("path_content"));
	}



}

?>