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
		$this->data = $data;
	}


	// load note file from path
	public function load($path, $file) {

		if ($path != "" && $file != "") {

			$this->data = parse_ini_file($path . $file);
			$this->set("file", pathinfo($file, PATHINFO_FILENAME));
		}
	}


	// save note to file
	public function save($category, $file = false) {

		$path = Config::config("path_content") . 'news/' . $category . '/';

		// if no file name as param -> get own filename
		if (!$file) {
			$file = $this->get("file");
		}

		// no filename at all -> create new file
		if (!$file) {
			$file = uniqid();
		}

		// if not exists -> create new category
		if (!file_exists($path)) {
			mkdir($path);
		}

		// has file and category
		if ($file != "" && $category != "") {

			$path = $path . $file . ".ini";

//TODO create ini class to read an write

			// $ini = new Ini();
			// $ini->load($this->data);
			// file_put_contents($path, $ini);

debug($path);
debug($this->data);
		}
	}


	// render note
	// class: optional additional block class
	// edit: if true, edit enabled
	public function render($class = "", $edit = false) {
		return View::note($this, $class, $edit);
	}


	// add data value
	public function set($key, $value) {
		$this->data[$key] = $value;

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