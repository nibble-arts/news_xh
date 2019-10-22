<h1>Convert News data</h1>

<?php

$source = "news_old/";
$target = "news/";

$files = scandir($source);

foreach ($files as $file) {

	if ($file != "." && $file != "..") {


		if(pathinfo($file, PATHINFO_EXTENSION) == "csv") {

			$cat = pathinfo($file, PATHINFO_FILENAME) . "/";

			// echo $file . "<br>";
			$data = file_get_contents($source . $file);

			$list = split($data);

			if (!file_exists($target . $cat))
				mkdir (strtolower($target . $cat));

			if (count($list)) {

				foreach ($list as $entry) {

					file_put_contents($target . $cat . uniqid() . ".ini", $entry);
				}
			}
		}
	}
}



function split($string) {

	// $string = str_replace('"', '\"', $string);

	$ret = [];
	$ary = array_filter(explode("\n", $string));


	foreach ($ary as $line) {

		$line = htmlspecialchars_decode ($line);
		
		$o = "";

		$temp = array_filter(explode("##", $line));

		$one = explode("#",$temp[0]);

		$created = $one[0];
		$title = $one[1];



		// replace " around text with '
		if (substr($temp[1],0,1) == "\"") {
			$temp[1][0] = "'";

			$temp[1][strpos($temp[1], "\"#")] = "'";
		}

		$two = explode("#", $temp[1]);
		$start = array_pop($two);
		$text = implode("", $two);

// echo "<pre>";
// print_r();
// echo "</pre>";


		$o .= "title = " . $title . "\n";
		$o .= "text = " . $text . "\n";
		$o .= "created = " . $created . "\n";
		$o .= "modified = " . $created . "\n";
		$o .= "start = ";
		if ($start > 0) $o .= $start;
		$o .= "\n";
		$o .= "expired = \n";

		$ret[] = $o;
	}


	return $ret;
}

?>