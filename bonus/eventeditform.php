<HTML>
<HEAD>
<TITLE>BONUS</TITLE>
<link href="orient.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY>
<p><a href="index.php"><img src="logo.jpg" border="0"></a></p>

<?php

	# get submitted variables

	$Oissuedate = $_POST['oissuedate'];
	$Oeventdate = $_POST['oeventdate'];
	$Opriority = $_POST['opriority'];
	$issuedate = $_POST['issuedate'];
	$eventdate = $_POST['eventdate'];
	$priority = $_POST['priority'];
	$title = $_POST['title'];
	$description = $_POST['description'];
	$timeplace = $_POST['timeplace'];


$sql = "UPDATE event

	SET
		ISSUE_DATE = '$issuedate',
		EVENT_DATE = '$eventdate',
		EVENT_PRIORITY = '$priority',
		TITLE = '$title',
		DESCRIPTION = '$description',
		TIMEPLACE = '$timeplace'
	WHERE
		ISSUE_DATE = '$Oissuedate' and
		EVENT_DATE = '$Oeventdate' and
		EVENT_PRIORITY = '$Opriority'
";


$link0 = mysql_connect("teddy", "orientdba","0r1en!") or die(mysql_error() );
mysql_select_db ("DB01Orient");

if (mysql_query($sql)) {
		echo("

<table bgcolor=\"CCCCCC\" cellpadding=\"1\" width=\"100%\"><tr><td>
<font class=\"textbold\">&nbsp;Event edited successfully</font><tr><td></table>


");
	}
	else {
		echo("<table bgcolor=\"CCCCCC\" cellpadding=\"1\" width=\"100%\"><tr><td>
<font class=\"textbold\">&nbsp;ERROR EDITING EVENT: ");
		echo mysql_error();
		echo("</font><tr><td></table>");
	}


?>
</BODY>
</HTML>
