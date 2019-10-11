<?php


/* static class for display of different screens */
namespace news;

class View {
	
	private static $text;
	
	// init view
	public static function init ($text) {

		self::$text = $text['news'];

	}


	// get multilingual text
	public static function text ($code) {

		if (isset(self::$text [$code])) {
			return self::$text [$code];
		}
		else {
			return $code;
		}
	}


	// return timestamp as human readable date
	public static function date ($timestamp) {

		if ($timestamp > 0) {
			return date("d.m.Y", $timestamp);
		}
	}


	// show list of notes
	public static function note_list($category, $options) {

		$note_array = [];

		Notes::load(Config::config("path_content"), $category);
		$notes = Notes::get_notes($options);


		// notes found
		if ($notes) {

			foreach ($notes as $key => $notes) {

				// is node
				if (is_int($key)) {
					$note_array[] = $notes->render("", $options->edit());
				}

				// is category
				else {

					$note_array[] = '<div class="news_category_title">' . ucfirst($key) . '</div>';

					foreach ($notes as $note) {
						$note_array[] = $note->render('news_tab', $options->edit());
					}
				}
			}
		}


		return implode("", $note_array);
	}


	// render note
	// $note: note object
	// class: optional additional class for note block
	// edit: true -> has edit rights
	public static function note($note, $class, $edit) {

		$o = '<div class="news_block ' . $class . '">';

			// add edit link
			if ($edit) {

				$o .= '<a href="?' . Config::config("note_edit_page") . '&news_cat=' . $note->get("category") . '&news_edit=' . $note->get("file") . '">';
					$o .= '<img class="news_icon" src="' . NEWS_PLUGIN_BASE . 'images/edit.png" title="' . View::text("note_edit") . '">';
				$o .= '</a>';
			}

			// title
			$o .= '<div class="news_title">' . $note->get("title");

				if ($note->get("category")) {
					$o .= '<div class="news_category">' . ucfirst($note->get("category")) . '</div>';
				}
			$o .= '</div>';

			// creation date
			$o .= '<div class="news_date">' . View::date($note->get("created")) . '</div>';

			// text
			$o .= '<div class="news_text">' . $note->get("text") . '</div>';

		$o .= '</div>';

		return $o;
	}


	// add note dialog
	public static function add_note() {

		$o = '<div class="news_add"><a href="?' . Config::config("note_edit_page") . '">';

			$o .= '<img class="news_icon" src="' . NEWS_PLUGIN_BASE . 'images/add.png" title="' . View::text("note_add") . '">';

		$o .= '</a></div>';

		return $o;
	}


	// news form
	public static function news_form($file = false) {

		$o = "";
		$new = true;

		$data = new Note();

		// load file to edit
		if ($file) {

			$file = $file . ".ini";
			$new = false;

			$data->load(Config::config("path_content") . 'news/', $file);
		}


		// form
		$o .= '<form method="post" action="' . '">';

			$o .= '<div if="ta" class="news_title">' . View::text("note_add") . '</div>';


			$o .= '<div class="news_form_block">';
				$o .= '<div class="news_label">' . View::text("note_category") . '</div>';

				// get category list
				Notes::load(Config::config("path_content"));
				$o .= HTML::select(Notes::get_categories(),["name" => "news_cat", "selected" => Session::param("news_cat")]);
			$o .= '</div>';


			$o .= '<div class="news_form_block">';
				$o .= '<div class="news_label">' . View::text("note_title") . '</div>';

				$o .= HTML::input([
					"type" => "text",
					"name" => "news_title",
					"size" => 50,
					"value" => $data->title()
				]);
			$o .= '</div>';


			$o .= '<div class="news_form_block">';
				$o .= '<div class="news_label">' . View::text("note_text") . '</div>';
				$o .= HTML::textarea(
					["name" => "news_text",
					"rows" => 20,
					"content" => $data->text()
				]);
			$o .= '</div>';


			$o .= '<div class="news_form_block">';

				// add new note
				if ($new) {

					$o .= HTML::input([
						"type" => "submit",
						"value" => View::text("note_add")
					]);

					$o .= HTML::input([
						"type" => "hidden",
						"name" => "action",
						"value" => View::text("note_add")
					]);
				}

				// save changes
				else {
					$o .= HTML::input([
						"type" => "submit",
						"value" => View::text("note_save")
					]);

					$o .= HTML::input([
						"type" => "hidden",
						"name" => "action",
						"value" => View::text("note_update")
					]);
				}

			$o .= '</div>';

		$o .= '</form>';

		return $o;
	}
}

?>