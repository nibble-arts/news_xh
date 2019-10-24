<?php

namespace news;


class Category {

	private static $base_path;

	public static function init() {
		self::$base_path = Config::path_content() . 'news/';
	}


	// add category if don't exists
	public static function add_category($category) {

		$path = self::$base_path . $category . "/";

		if (!file_exists($path)) {
			mkdir($path);
		}
	}


	// remove category
	public static function remove_category($category) {

		$path = self::$base_path . $category . "/";

		// directory exists
		if (is_dir($path)) {

			// remove files
			foreach (scandir($path) as $file) {

				if (is_file($path . $file)) {
					unlink($path . $file);
				}
			}

			// remove directory
			rmdir($path);
		}

	}


	// get category base directory
	public static function base($category = false) {

		if ($category) {
			return self::$base_path . $category . "/";
		}

		return self::$base_path;
	}
}

?>