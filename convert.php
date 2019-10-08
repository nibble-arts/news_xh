<h1>Convert News data</h1>

<?php

$source = "news_old/";
$target = "news/";

$files = scandir($source);

foreach ($files as $file) {

	if ($file != "." && $file != "..") {


		if(pathinfo($file, PATHINFO_EXTENSION) == "csv") {

			echo $file . "<br>";
			$data = file_get_contents($source . $file);

// echo "<pre>";
(split($data));
// echo "</pre>";
		}
	}
}



function split($string) {

	// $string = str_replace('"', '\"', $string);

	$ret = [];
	$ary = array_filter(explode("\n", $string));


	foreach ($ary as $line) {

		$temp = array_filter(explode("##", $line));

echo "<pre>";
print_r(explode("#", $temp[0]));
// print_r($temp);
echo "</pre>";

echo "<pre>";
print_r(explode("#", $temp[1]));
echo "</pre>";

	}


	return $ret;
}

?>