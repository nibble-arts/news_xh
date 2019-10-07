<?php

namespace news;


class Note {

	private $data;


	public function __construct($data) {

		$this->data = $data;
	}


	public function render($cat = false) {

		$o = "";

		$o .= '<div class="news_date">' . date("d.m.Y", $this->data["created"]) . '</div>';

		$o .= '<div class="news_title">' . $this->data["title"];

		if ($cat) {
			$o .= '<div class="news_category">' . $cat . '</div>';
		}

		$o .= '</div>';

		$o .= '<div class="news_text">' . $this->data["text"] . '</div>';

		return $o;
	}
}

?>