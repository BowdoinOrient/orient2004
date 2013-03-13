<?php
include("currentsurvey.php");
include("polls.php");
authorizedResults('results.php');
include("../dbconnect.php");
$surveyname = mysql_real_escape_string($currentTitle);

$query = "SELECT * FROM survey WHERE surveyname='$surveyname' ORDER BY id ASC;";
$numquery = "SELECT * FROM survey WHERE surveyname='$surveyname' GROUP BY userhash ORDER BY id ASC;";
// echo $query;
$results = mysql_query($query);
$numresults = mysql_query($numquery);
$first = '';
$csv = ($_GET['type'] == 'csv');
if (!$csv) {
	echo "<h2>Number of results: " . mysql_num_rows($numresults) . "</h2><h4>View as <a href='results.php?type=csv'>csv</h4><table border='1'>\n<thead>\n";
	$thead = "\t<tr>";
	$tbody = "\t<tr>";
} else {
	header("Content-type: text/plain");
	$thead = array();
	$tbody = "";
	$curRow = array();
}
$firstentry = true;
$time = '';
while ($row = mysql_fetch_array($results)) {
	if ($row['name'] == $first) {
		$firstentry = false;
		if ($csv) {
			$tbody .= "\"" . implode("\",\"", $curRow) . "\",\"" . $browser . "\",\"" . $os . "\",\"" . formatTime($time) . "\"\n";
			$curRow = array();
		} else {
			$tbody .= "<td>" . $browser . "</td><td>" . $os . "</td><td>" . formatTime($time) . "</td></tr>\n<tr>";	
		}
	}
	if ($firstentry) {
		if ($csv) {
			$thead[] = $row['name'];
		} else {
			$thead .= "<td><b>" . $row['name'] . "</b></td>";
		}
	}
	if ($first == '') {
		$first = $row['name'];
	}
	if ($csv) {
		$curRow[] .= $row['response'];
	} else {
		$tbody .= "<td>" . $row['response'] . "&nbsp;</td>";
	}
	$time = $row['time'];
	$browser = $row['browser'];
	$os = $row['os'];
}
if ($csv) {
	echo "\"" . strtoupper(implode("\",\"", $thead)) . "\"BROWSER\",\"OS\",\"TIMESTAMP\"\n";
	echo $tbody . "\"" . implode("\",\"", $curRow) . "\",\"$browser\",\"$os\",\"" . formatTime($time) . "\"";
} else {
	echo $thead . "<td><b>Browser</b></td><td><b>OS</b></td><td><b>Timestamp</b></td></tr>\n</thead>\n";
	echo "<tbody>\n";
	echo $tbody;
	echo "<td>$browser</td><td>$os</td><td>" . formatTime($time) . "</td></tr>\n</tbody>\n</table>";
}

?>