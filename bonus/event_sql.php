<?php

# set and get variables for mode
$type = $_GET['type'];

?>

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




if ($type == add) {
	$sql = "
	INSERT INTO event
	(`ISSUE_DATE`, `EVENT_DATE`, `EVENT_PRIORITY`, `TITLE`, `DESCRIPTION`, `TIMEPLACE`) 
	VALUES ('$issuedate', '$eventdate', '$priority', '$title', '$description', '$timeplace')
	";
}


if ($type == edit) { 
	$sql = "
	UPDATE event
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
}

if ($type == delete) { 
	$sql = "
	DELETE FROM event
	WHERE
		ISSUE_DATE = '$Oissuedate' and
		EVENT_DATE = '$Oeventdate' and
		EVENT_PRIORITY = '$Opriority'
	";
}



$link = mysql_connect("teddy", "orientdba","0r1en!") or die(mysql_error() );
mysql_select_db ("DB01Orient");

if (mysql_query($sql)) {
	echo("
		<table bgcolor=\"CCCCCC\" cellpadding=\"1\" width=\"100%\"><tr><td>
		<font class=\"textbold\">&nbsp;
	");

	if ($type == add) { echo("Event added successfully"); }
	if ($type == edit) { echo("Event edited successfully"); }
	if ($type == delete) { echo("Event deleted successfully"); }
		
	echo("
		</font><tr><td></table>
	");
	}
else {
	echo("<table bgcolor=\"CCCCCC\" cellpadding=\"1\" width=\"100%\"><tr><td>
		<font class=\"textbold\">&nbsp;
	");

	if ($type == add) { echo("ERROR ADDING EVENT: "); }
	if ($type == edit) { echo("ERROR EDITING EVENT: "); }
	if ($type == delete) { echo("ERROR DELETING EVENT: "); }

	echo mysql_error();

	echo("</font><tr><td></table>
	");
	}

?>

</BODY>
</HTML>
