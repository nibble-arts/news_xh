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

	}


	// render notes
	public static function render($category, $options = false) {

		$o = "";

		// select special function
		switch ($category) {

			case "_add":
				$o .= View::news_form();
				break;


			case "_edit":



				$o .= View::news_form($options->get("news_id"));
				break;


			default:

				// $t = class_exists("\ma\Access");
				// \ma\Access::user();

				// memberaccess installed
				// if ($t) {
				// 	$o .= news\View::add_note();
				// }

				$o .= View::note_list($category, $options);
				break;

		}

		return $o;
	}
}

?>