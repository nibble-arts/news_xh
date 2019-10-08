<?php

namespace news;

class Options {

	private $options;


	public function __construct($options) {

		$this->parse($options);
	}


	// get val by key
	public function get($key) {
		if (isset($this->options[$key])) {
			return $this->options[$key];
		}

		else {
			return false;
		}
	}


	// magic get function 
	public function __call($name, $attr) {
		return $this->get($name);
	}


	// parse option string
	private function parse($options) {

		$ret_array = [];
		$this->options = [];


		// is array
		if (is_array($options)) {
			$this->options = $options;
		}


		// parse option string
		// key=val[,key1=val1]
		if (is_string($options)) {

			// options found
			if ($options) {

				// split options string
				if (is_string($options)) {
					$ret_array = explode(",", $options);
				}

				// create assoc array
				foreach ($ret_array as $key => $val) {
					$temp = explode("=", $val);

					if (count($temp) > 1) {
						$this->options[$temp[0]] = $temp[1];
					}
				}
			}
		}
	}
}