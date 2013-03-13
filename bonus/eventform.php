<HTML>
<HEAD>
<TITLE>BONUS</TITLE>
<link href="orient.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY>
<p><a href="index.php"><img src="logo.jpg" border="0"></a></p>

<?php

	# get submitted variables

	$issuedate = $_POST['issuedate'];
	$eventdate = $_POST['eventdate'];
	$priority = $_POST['priority'];
	$title = $_POST['title'];
	$description = $_POST['description'];
	$timeplace = $_POST['timeplace'];


$sql = "insert into event
(`ISSUE_DATE`, `EVENT_DATE`, `EVENT_PRIORITY`, `TITLE`, `DESCRIPTION`, `TIMEPLACE`) 
values ('$issuedate', '$eventdate', '$priority', '$title', '$description', '$timeplace')";


$link0 = mysql_connect("teddy", "orientdba","0r1en!") or die(mysql_error() );
mysql_select_db ("DB01Orient");

if (mysql_query($sql)) {
		echo("

<table bgcolor=\"CCCCCC\" cellpadding=\"1\" width=\"100%\"><tr><td>
<font class=\"textbold\">&nbsp;Event added successfully</font><tr><td></table>


");
	}
	else {
		echo("<table bgcolor=\"CCCCCC\" cellpadding=\"1\" width=\"100%\"><tr><td>
<font class=\"textbold\">&nbsp;ERROR ADDING EVENT: ");
		echo mysql_error();
		echo("</font><tr><td></table>");
	}


?>
</BODY>
</HTML>
