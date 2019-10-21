<?php

namespace news;


class Notes {


	private static $categories;
	private static $data;


	// load notes
	public static function load($path, $category = false) {

		// create path
		$path = $path . "news/";
		$cat_array = [];
		self::$data = [];
		self::$categories = [];


		if (!$category) {
			$category = "";
		}


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

				// save category
				self::$categories[] = $dir;


				// get files
				$files = scandir($path . $dir);

				// collect news
				foreach ($files as $file) {

					if ($file != "." && $file != "..") {

						// create note
						// add category to note
						$data = new Note();
						$data->load($path . $dir . "/", $file);
						$data->set("category", $dir);

						self::$data[] = $data;
					}
				}
			}
		}

// debug(self::$categories);
	}


	// get notes
	// optional GROUP by key
	// optional ORDER by key with DIR asc/desc 
	// group:		key to group
	// group_dir:	order direction of groups
	// order:		order of notes
	// dir:			order direction of notes
	public static function get_notes($options = []) {


		$order_notes = self::$data;


		// set default order direction
		if (!($dir = $options->dir())) $dir = "asc";


		// group notes and sort groups
		if ($group = $options->group()) {

			$order_notes = self::group_by_key($group);

			if ($group_dir = $options->group_dir()) {
				$order_notes = self::order_group($order_notes, $group_dir);
			}
		}


		// sort group content
		if ($group) {

			// iterate categories
			foreach ($order_notes as $key => $nodes) {

				// sort nodes of category
				if ($order = $options->order()) {
					$ordered = self::order_by_key($nodes, $key, $dir);
				}
				else {
					$ordered = $nodes;
				}

				// filter  notes
				$ordered = self::filter($ordered, $options->filter());	

				// filter published notes
				// show=all -> shows all notes
				$ordered = self::filter_online($ordered, $options->show());

				// add to category
				$order_notes[$key] = $ordered;
			}
		}


		// sort notes
		else {

			// sort nodes
			if ($order = $options->order()) {
				$ordered = self::order_by_key($order_notes, $order, $dir);
			}
			else {
				$ordered = $order_notes;
			}


			// filter published notes
			// show=all -> shows all notes
			$ordered = self::filter_online($ordered, $options->show());

			// apply filter
			$order_notes = self::filter($ordered, $options->filter());
		}


		return $order_notes;
	}


	// get category list
	public static function get_categories() {
		return self::$categories;
	}


	// filter notes list
	private static function filter($notes,$filter) {

		$ret_notes = [];

		if ($filter) {

			$filter_ary = explode(":", $filter);

			// select filter
			switch ($filter_ary[0]) {

				// limit to n entries
				case "count":
					$notes = array_slice($notes, 0, $filter_ary[1]);
					break;


				// filter by time string
				// +-n days/months/years
				case "time":

					$limit_time = strtotime($filter_ary[1], time());
					$notes = self::get_time_range($notes, $limit_time);
					break;

			}

		}

		return $notes;
	}


	// filter online notes
	// between start and expired
	public static function filter_online($notes, $options = false) {

		$ret_notes = [];


		switch ($options) {

			// show all notes
			case "all":
				return $notes;
				break;


			// default: show only published and not expired 
			default:
				$current = time();

				foreach ($notes as $note) {

					$start = $note->start();
					$end = $note->expired();

					// is online
					if ($start && $start <= $current) {

						// is not expired or no end date
						if (($end && $current <= $end) || !$end) {
							$ret_notes[] = $note;
						}
					}

				}

				return $ret_notes;
				break;
		}

		// 
	}


	// get note by key
	public static function get_by_key($key, $value) {

		foreach (self::$data as $idx => $entry) {

			if ($entry->get($key) == $value) {
				return $entry;
			}
		}
	}


	// get notes in time range of start date
	private static function get_time_range($notes, $start, $end = false) {

		$ret_notes = [];

		// no end -> use current time
		if (!$end) {
			$end = time();
		}


		// collect matching notes
		foreach ($notes as $note) {

			if ($note_time = $note->start()) {

				// is between start and end time
				if ($note_time >= $start && $note_time <= $end) {
					$ret_notes[] = $note;
				}
			}
		}

		return $ret_notes;
	}


	// group note list by key
	private static function group_by_key($key) {

		$ret_array = [];

		foreach (self::$data as $note) {
			
			if ($val = $note->get($key)) {

				// $note->remove($key);
				$ret_array[$val][] = $note;
			}
		}

		return $ret_array;
	}


	// order group
	private static function order_group($groups, $dir) {

		// $sort_array = self::$data;

		switch (strtolower($dir)) {

			case "asc":
				uksort($groups, 'strcasecmp');
				break;

			case "desc":
				uksort($groups, 'strcasecmp');
				$groups = array_reverse($groups);
				break;
		}

		return $groups;
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
				// $sort_array = array_reverse($sort_array);
				break;
		}
// debug(array_values($sort_array));
		return array_values($sort_array);
	}
}

?>