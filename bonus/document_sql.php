<HTML>
<HEAD>
<TITLE>BONUS</TITLE>
<link href="orient.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY>
<p><a href="index.php"><img src="logo.jpg" border="0"></a></p>
<?php

	# get submitted variables

	$date = $_POST['date'];
	$section = $_POST['section'];
	$priority = $_POST['priority'];
	$label = $_POST['label'];
	$filename = $_POST['filename'];

$sql = "insert into related (`ARTICLE_DATE`, `ARTICLE_SECTION`, `ARTICLE_PRIORITY`, `LABEL`, `URL`) values ('$date', '$section', '$priority', '$label', '$filename')";


$link0 = mysql_connect("teddy", "orientdba","0r1en!") or die(mysql_error() );
mysql_select_db ("DB01Orient");

if (mysql_query($sql)) {
		echo("<table bgcolor=\"CCCCCC\" cellpadding=\"1\" width=\"100%\"><tr><td>
<font class=\"textbold\">&nbsp;Related document added successfully</font><tr><td></table>
");
	}
	else {
		echo("<table bgcolor=\"CCCCCC\" cellpadding=\"1\" width=\"100%\"><tr><td>
<font class=\"textbold\">&nbsp;ERROR ADDING RELATED DOCUMENT: ");
		echo mysql_error();
	}

?>
</BODY>
</HTML>
