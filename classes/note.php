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


	// render note
	// class: optional additional block class
	// edit: if true, edit enabled
	public function render($class = "", $edit = false) {

		$o = '<div class="news_block ' . $class . '">';

			// add edit link
			if ($edit) {
				// $o = '<a href="?' . Config::config("note_edit_page") . '&news_cat=' . $this->get("category") . '">';
					$o .= View::text("note_edit");
				// $o .= '</a>';
			}

			// title
			$o .= '<div class="news_title">' . $this->get("title");

				if ($this->get("category")) {
					$o .= '<div class="news_category">' . ucfirst($this->get("category")) . '</div>';
				}
			$o .= '</div>';

			// creation date
			$o .= '<div class="news_date">' . View::date($this->get("created")) . '</div>';

			// text
			$o .= '<div class="news_text">' . $this->get("text") . '</div>';

		$o .= '</div>';

		return $o;
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