<?php

namespace news;


class Ini {

	private $data;


	// construct class
	// optional load data with auto type recognition
	// ini string or assoz array
	public function __construct($data = false) {

		$this->data = [];

		// select data type
		if (is_string($data)) {
			$this->load_ini_string($data);
		}

		elseif (is_array($data)) {
			$this->load_array($data);
		}
	}


	// load ini string
	// if string is file and exists, load file
	public function load($ini_string) {

		// is string or path
		if (is_string($ini_string)) {

			// is path
			if (file_exists($ini_string)) {
				$this->data = parse_ini_file($ini_string, true);
			}

			// is string
			else {
				$this->data = parse_ini_string($ini_string, true);
			}
		}

		// load string
		else {
			$this->load_array($ini_string);
		}
	}


	// save ini to file
	public function save($path) {
		return file_put_contents($path, $this->serialize());
	}


	// load array
	public function load_array($ini_array) {
		$this->data = $ini_array;
	}


	// get array
	public function get_array() {
		return $this->data;
	}


	// serialize ini file
	public function serialize() {

		$ret = "";

		// remove category
		if (isset($this->data["category"])) {
			unset($this->data["category"]);
		}

		// is section
		foreach ($this->data as $key => $value) {

			// key = section
			if (is_array($value)) {

				$ret .= $this->section($key);

				foreach ($value as $k => $v) {

					$ret .= $this->line($k, $v, $this->quotes($v));
				}
			}

			// is single value
			else {
				$ret .= $this->line($key, $value, $this->quotes($value));
			}
		}

		return $ret;
	}


	// render key value line
	// $d optional quotes for value 
	private function line($k, $v, $q) {

		return $k . ' = ' . $q . $v . $q . "\n";
	}


	// render section
	private function section ($s) {
		return "[" . $s . "]";
	}


	// get quotes for text
	private function quotes($value) {

		$q = '"';

		if (!is_int($value)) {

			if (strpos($value, '"') !== false) {
				$q = "'";
			}
		}

		return $q;
	}
}