<?php

namespace news;

class News {


	private static $data;


	public static function init($config, $text) {

		Config::init($config);
		View::init($text);

		Notes::load(Config::config("path_content"));
	}


	public static function render($category) {

		$note_array = [];

		$notes = Notes::get_category($category);

		foreach ($notes as $note) {

			$note_array[] = $note->render($category) . "<hr>";
		}

		return implode("<hr>", $note_array);
	}

}

?>