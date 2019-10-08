<?php

namespace news;


class Notes {

	private static $data;


	// load notes
	public static function load($path, $category) {

		// create path
		$path = $path . "news/";
		$cat_array = [];

		// split category string by comma
		if (is_string($category)) {
			$cat_array = explode(",", $category);
		}

		// create lowercase match array
		$match_array = array_filter(array_map('strtolower', $cat_array));

		// create news content path
		if (!is_dir($path)) {
			mkdir($path);
		}

		// get category directories
		$dirs = scandir($path);

		// collect categories
		foreach ($dirs as $dir) {

			// category found
			// not . ..
			// in category array
			// category array not empty -> show all
			if (($dir != "." && $dir != "..") && (in_array(strtolower($dir), $match_array) || count($match_array) == 0))  {

				// get files
				$files = scandir($path . $dir);

				// collect news
				foreach ($files as $file) {

					if ($file != "." && $file != "..") {

						// create note
						// add category
						$data = new Note(parse_ini_file($path . $dir . "/" . $file));
						$data->set("category", $dir);

						self::$data[] = $data;
					}
				}
			}
		}

		// debug(self::$data);
	}


	// get notes
	// optional GROUP by key
	// optional ORDER by key with DIR asc/desc 
	// group:		key to group
	// group_dir:	order direction of groups
	// order:		order of notes
	// dir:			order direction of notes
	public static function get_notes($options = []) {


		// set default order direction
		if (!($dir = $options->dir())) $dir = "asc";


		// group notes and sort groups
		if ($group = $options->group()) {

			self::$data = self::group_by_key($group);

			if ($group_dir = $options->group_dir()) {
				self::$data = self::order_group($group_dir);
			}
		}


		// sort group content
		if ($group) {

			// order nodes of category
			if ($order = $options->order()) {

				foreach (self::$data as $key => $nodes) {
					self::$data[$key] = self::order_by_key($nodes, $key, $dir);
				}
			}

		}


		// sort notes
		elseif ($order = $options->order()) {
			self::$data = self::order_by_key(self::$data, $order, $dir);
		}


		return self::$data;
	}


	// filter notes list
	private static function filter($filter) {


	}


	// group note list by key
	private static function group_by_key($key) {

		$ret_array = [];

		foreach (self::$data as $note) {
			
			if ($val = $note->get($key)) {

				$note->remove($key);
				$ret_array[$val][] = $note;
			}
		}

		return $ret_array;
	}


	// order group
	private static function order_group($dir) {

		$sort_array = self::$data;

		switch (strtolower($dir)) {

			case "asc":
				ksort($sort_array);
				break;

			case "desc":
				krsort($sort_array);
				break;
		}

		return $sort_array;
	}


	// sort notes
	private static function order_by_key($ary, $key, $dir) {

		$sort_array = [];

		// create temp array for sorting
		foreach ($ary as $idx => $note) {
			$sort_array[$note->get($key) . "_" . $idx] = $note;
		}

		// sort
		switch (strtolower($dir)) {

			case "asc":
				ksort($sort_array);
				break;

			case "desc":
				krsort($sort_array);
				break;
		}

		return array_values($sort_array);
	}
}

?>