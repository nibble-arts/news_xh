<?php

namespace news;

class News {


	private static $data;


	public static function init($config, $text) {

		Config::init($config);
		Text::init($text["news"]);
		Session::load();
		Category::init();
		Notes::load(Config::path_content());

		self::action();

	}


	// add note
	public static function action() {

		switch (Session::param("action")) {

			case "note_update":


				// set message online
				if (Session::post("news_button_online")) {

					$note = Notes::get_by_key("file", Session::param("news_file"));

					// note loaded, add start and save
					if ($note) {
						$note->set("start", time());
						$note->save(Session::param("news_cat"), Session::param("news_file"));
					}
				}


				// set message offline
				elseif (Session::post("news_button_offline")) {

					$note = Notes::get_by_key("file", Session::param("news_file"));

					// note loaded, add start and save
					if ($note) {
						$note->set("start", "");
						$note->save(Session::param("news_cat"), Session::param("news_file"));
					}
				}

				// delete category
				elseif (Session::post("news_button_del_cat")) {
					Category::remove_category(Session::param("news_cat"));
				}


				// delete note
				elseif (Session::post("news_button_del_note")) {
					unlink (Category::base(Session::post("news_cat")) . Session::post("news_file") . ".ini");
				}


				else {

					$new_note = new Note();

					// add new category
					if (Session::param("news_new_cat")) {
						Category::add_category(Session::param("news_new_cat"));		
						$category = Session::param("news_new_cat");
					}

					else {
						$category = Session::param("news_cat");
					}
	
					// save note if title and text		
					if (Session::param("news_title") && Session::param("news_text")) {

						// set note data
						$new_note->set([
							"category" => $category,
							"title" => Session::param("news_title"),
							"text" => Session::param("news_text"),
							"start" => Session::param("news_start"),
							"created" => Session::param("news_created"),
							"modified" => time(),
							"expired" => View::date_to_timestamp(Session::param("news_expired"))
						]);

						$new_note->save($category, Session::param("news_file"));
					}

					else {
						Message::failure("note_no_content");
					}
				}


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