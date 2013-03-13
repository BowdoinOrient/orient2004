<?php
$ie6 = "MSIE 6.0";
if (strpos($_SERVER['HTTP_USER_AGENT'], $ie6) !== false) {
	$pieces = split("/", $_SERVER['SCRIPT_URL'], 3);
	$path = $pieces[2];
	echo "IE 6!!!<br />";
	$url = "http://orient.bowdoin.edu/orient/old/$path";
	echo "TEST";
//	header("Location: $url");
}
	$q = $_SERVER['QUERY_STRING'];
	echo "STRING!!!" . $q . "###";

// print_r($_SERVER);
?>