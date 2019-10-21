<?php

namespace news;


class Note {

	private $data;

	private $struct = [
		"title",
		"text",
		"created",
		"start",
		"modified",
		"expired"
	];


	// create note from data array
	// [title, text, created, modified, start, expired]
	public function __construct($data = []) {
		$this->init($data);
	}


	// load note file from path
	public function load($path, $file) {

		if ($path != "" && $file != "") {

			if (file_exists($path . $file)) {

				$this->set(parse_ini_file($path . $file));
				$this->set("file", pathinfo($file, PATHINFO_FILENAME));
			}
		}
	}


	// init the array and set data
	public function init($new_data) {

		foreach ($this->struct as $element) {

			$this->data[$element] = "";

			if (is_array($new_data) && isset($new_data[$element])) {
				$this->data[$element] = $new_data[$element];
			}
		}
	}


	// save note to file
	public function save($category, $file = false) {

		if (!$this->data["created"]) {
			$this->data["created"] = time();
		}

		// if no file name as param -> get own filename
		if (!$file) {
			$file = $this->get("file");
			$this->data["modified"] = time();
		}

		// no filename at all -> create new file
		if (!$file) {
			$file = uniqid();
		}

		$cat_path = Category::base($category);
		$old_cat_path = Category::base(Session::param("news_old_cat"));

		// add category if don't exist
		Category::add_category($category);


		// has file and category
		if ($file != "" && $category != "") {

			// create ini
			$ini = new Ini();
			$ini->load($this->data);


			// save
			if ($ini->save($cat_path . $file . ".ini")) {

				Message::success("note_saved");

				// if saved and moved to other category -> clear old entry
				if ($old_cat_path && $cat_path != $old_cat_path) {
					Session::set_param("news_cat", $category);
					unlink($old_cat_path . $file . ".ini");
				}
			}

			// save failure
			else {
				Message::failure("note_save_failure");
			}
		}
	}


	// render note
	// class: optional additional block class
	// edit: if true, edit enabled
	public function render($class = "", $edit = false) {
		return View::note($this, $class, $edit);
	}


	// add data value
	public function set($key, $value = false) {

		// set from array
		if (is_array($key)) {
			$this->data = $key;
		}

		// set single key->value pair
		else {
			$this->data[$key] = $value;
		}

		return $value;
	}


	// remove by key
	public function remove($key) {
		if ($this->get($key)) {
			unset($this->data[$key]);
		}
	}


	// get data value by key
	public function get($key) {
		 if (isset($this->data[$key])) {
		 	return $this->data[$key];
		 }

		 else {
		 	return false;
		 }
	}


	// magic get
	public function __call($name, $attr) {
		return $this->get($name);
	}


	// note is valid to be displayed
	// between start and expire
	private function is_valid() {

	}
}

?>