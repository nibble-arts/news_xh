<?php

namespace news;

class News {


	private static $data;


	public static function init($config, $text) {

		Config::init($config);
		View::init($text);

		Session::load();

		self::action();

	}


	// add note
	public static function action() {

		debug(Session::param("action"));
		debug(Session::debug());

		debug("category: ".Session::param("news_cat"));
		debug("title: ".Session::param("title"));
		debug("text: ".Session::param("news_text"));
		debug("modified: ".time());
	}


	// render notes
	public static function render($category, $options = false) {

		$o = "";

		// select special function
		switch ($category) {

			// add note if new_file is empty
			// edit note file
			case "_edit":
				$o .= View::news_form(implode("/", [Session::param("news_cat"), Session::param("news_edit")]));
				break;


			default:

				if ($options->edit()) {
					$o .= View::add_note();
				}

				$o .= View::note_list($category, $options);
				break;

		}

		return $o;
	}
}

?>