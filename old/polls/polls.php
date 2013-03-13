<?php 

session_start();
include("../dbconnect.php");
$authorized = array();
$authorized[] = "sglickma";
$authorized[] = "akommel";
$authorized[] = "nday";
$authorized[] = "mmiller2";
$authorized[] = "eguerin";

function formatTime($time) {
	$time = substr(strval($time), 6, 6);
	return substr($time, 0, 2) . ", " . substr($time, 2, 2) . ":" . substr($time, 4);
}

function array_test() {
	foreach ($_POST as $key => $value) {
		echo "KEY: $key, VALUE: $value\n";
	}
}

function startPoll($pollURL, $closed, $authenticated) {
	if ($closed) {
		header("Location: index.php?status=closed");
	}
	if ($authenticated and !$_SESSION["username"]) {
		header("Location: login.php?redirect=$pollURL");
		exit;
	}
}

function authorizedResults() {
	if (!$_SESSION['username']) {
		header("Location: login.php?redirect=results.php");
		exit;
	}
	global $authorized;
	if (!in_array($_SESSION['username'], $authorized)) {
		header("Location: index.php?status=unauthorized");
		exit;
	}
}

function enterResults($surveyname, $url, $requiredAnswers, $questions, $authenticated) {	
	foreach($requiredAnswers as $answer) {
		if ($_POST[$answer] == '') {
			header("Location: $url?status=missing");
			exit;
		}
	}
	$surveyname = mysql_real_escape_string($surveyname);
	if ($authenticated) {
		$username = $_SESSION['username'];
		$userhash = md5($username);
		$query = "SELECT * FROM survey WHERE surveyname='$surveyname' AND userhash='$userhash';";
		$results = mysql_query($query);
		if (mysql_num_rows($results) > 0) {
			// Then $username has already taken this survey.
			header("Location: index.php?status=alreadytaken");
			exit;
		}
	}
	
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	if (strpos($useragent, "Windows")) {
		$os = "Windows";
	} else if (strpos($useragent, "Macintosh")) {
		$os = "Macintosh";
	} else if (strpos($useragent, "Linux")) {
		$os = "Linux";
	} else {
		$os = "Unknown";
	}
	
	if (strpos($useragent, "Opera")) {
		$browser = "Opera";
	} else if (strpos($useragent, "Chrome")) {
		$browser = "Chrome";
	} else if (strpos($useragent, "Firefox")) {
		$browser = "Firefox";
	} else if (strpos($useragent, "MSIE")) {
		$browser = "IE";
	} else if (strpos($useragent, "Safari")) {
		$browser = "Safari";
	} else {
		$browser = "Unknown (probably not Konqueror, though)";
	}
	
	for ($i = 0; $i < count($questions); $i++) {
		$qname = $questions[$i];
		$name = mysql_real_escape_string($qname);
		$value = "";
		if ($_POST[$qname]) {
			if (is_array($_POST[$qname])) {
				$value = mysql_real_escape_string(implode("; ", $_POST[$qname]));
			} else {
				$value = mysql_real_escape_string($_POST[$qname]);
			}
		}
		if ($authenticated) {
			$query = "INSERT INTO survey (`surveyname`, `userhash`, `name`, `response`, `time`, `browser`, `os`) VALUES ('$surveyname', '$userhash', '$name', '$value', NOW(), '$browser', '$os');";
		} else {
			$query = "INSERT INTO survey (`surveyname`, `name`, `response`, `time`, `browser`, `os`) VALUES ('$surveyname', '$name', '$value', NOW(), '$browser', '$os');";
		}
		mysql_query($query);
	}
	header("Location: index.php?status=success");
	exit;
}

?>