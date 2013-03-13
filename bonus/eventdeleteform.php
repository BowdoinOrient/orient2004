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

$sql = "DELETE FROM event

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
<font class=\"textbold\">&nbsp;Event deleted successfully</font><tr><td></table>


");
	}
	else {
		echo("<table bgcolor=\"CCCCCC\" cellpadding=\"1\" width=\"100%\"><tr><td>
<font class=\"textbold\">&nbsp;ERROR DELETING EVENT: ");
		echo mysql_error();
		echo("</font><tr><td></table>");
	}


?>
</BODY>
</HTML>
