<?php

namespace news;


class Notes {

	private static $data;


	// load notes
	public static function load($path) {

		// create path
		$path = $path . "news/";

		if (is_dir($path)) {
			$dirs = scandir($path);

			// collect categories
			foreach ($dirs as $dir) {

				if ($dir != "." && $dir != "..") {

					// create category
					self::$data[$dir] = [];

					// get files
					$files = scandir($path . $dir);


					// collect news
					foreach ($files as $file) {

						if ($file != "." && $file != "..") {

							self::$data[$dir][pathinfo($file,PATHINFO_FILENAME)] = new Note(parse_ini_file($path . $dir . "/" . $file));
						}
					}
				}
			}

			debug(self::$data);
		}
	}
}

?>