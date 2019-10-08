<?php

namespace news;


class Note {

	private $data;


	// create note from data array
	// [title, text, created, modified, start, expire]
	public function __construct($data) {
		$this->data = $data;
	}


	// render note
	public function render($class = "") {

		$o = '<div class="news_block ' . $class . '">';

			// title
			$o .= '<div class="news_title">' . $this->get("title");

				if ($this->get("category")) {
					$o .= '<div class="news_category">' . ucfirst($this->get("category")) . '</div>';
				}

			$o .= '</div>';


			// create date
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