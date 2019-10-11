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

		$this->data = parse_ini_file($path . $file);
		$this->set("file", pathinfo($file, PATHINFO_FILENAME));
	}


	// save note to file
	public function save($category, $file) {

		// has file and category
		if ($this->get("file") != "" && $category != "") {

			$path = Config::config("path_content") . 'news/' . $category . $file . ".ini";
debug($path);
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