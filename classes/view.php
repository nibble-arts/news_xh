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
}

?>