<?php
/*
print_r($_SERVER);
print_r(split("/", $_SERVER['SCRIPT_URL'], 3));

*/
$pieces = split("/", $_SERVER['SCRIPT_URL'], 3);
$path = $pieces[2];
$url = "http://orient.bowdoin.edu/orient/old/$path";
echo $url;
?>