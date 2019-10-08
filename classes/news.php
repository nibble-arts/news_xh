<?php

namespace news;

class News {


	private static $data;


	public static function init($config, $text) {

		Config::init($config);
		View::init($text);

		// Notes::load(Config::config("path_content"));
	}


	public static function render($category, $options = false) {

		$note_array = [];

		$options = new Options($options);

		Notes::load(Config::config("path_content"), $category);
		$notes = Notes::get_notes($options);


		// notes found
		if ($notes) {

			foreach ($notes as $key => $notes) {

				// is node
				if (is_int($key)) {
					$note_array[] = $notes->render($category);
				}

				// is category
				else {

					$note_array[] = '<div class="news_category_title">' . ucfirst($key) . '</div>';

					foreach ($notes as $note) {
						$note_array[] = $note->render($category);
					}
				}
			}
		}


		return implode("<hr>", $note_array);
	}
}

?>