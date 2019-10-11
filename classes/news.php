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

		switch (Session::param("action")) {

			case "note_update":
		
				$new_note = new Note();

				$new_note->set("category", Session::param("news_cat"));
				$new_note->set("title", Session::param("title"));
				$new_note->set("text", Session::param("news_text"));
				$new_note->set("text", Session::param("news_text"));
				$new_note->set("created", Session::param("news_created"));
				$new_note->set("modified", time());
				$new_note->set("expired", Session::param("news_expired"));

				$new_note->save(Session::param("news_cat"), Session::param("news_file"));

				break;
		}

	}


	// render notes
	public static function render($category, $options = false) {

		$o = "";

		// select special function
		switch ($category) {

			// add note if new_file is empty
			// edit note file
			case "_edit":
				$o .= View::news_form(implode("/", [Session::param("news_cat"), Session::param("news_file")]));
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