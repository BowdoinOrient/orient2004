<?php 

$date = '2008-09-12';
echo $date . "<br />";
$dateYear = substr($date, 0, 4);
$dateMonth = substr($date, 5, 2);
$dateDay = substr($date, 8);
echo $dateYear . "<br />" . $dateMonth . "<br />" . $dateDay . "<br />";
for ($i = 1; $i <= 7; $i++) {
	date("Y-m-d", mktime(0, 0, 0, intval($dateMonth), intval($dateDay + $i), intval($dateYear))) . "<br />";
}


?>