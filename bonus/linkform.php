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
	$URL = $_POST['URL'];

$sql = "insert into links (`ARTICLE_DATE`, `ARTICLE_SECTION`, `ARTICLE_PRIORITY`, `LINKNAME`, `LINKURL`) values ('$date', '$section', '$priority', '$label', '$URL')";


$link0 = mysql_connect("teddy", "orientdba","0r1en!") or die(mysql_error() );
mysql_select_db ("DB01Orient");

if (mysql_query($sql)) {
		echo("<table bgcolor=\"CCCCCC\" cellpadding=\"1\" width=\"100%\"><tr><td>
<font class=\"textbold\">&nbsp;Related link added successfully</font><tr><td></table>
");
	}
	else {
		echo("<table bgcolor=\"CCCCCC\" cellpadding=\"1\" width=\"100%\"><tr><td>
<font class=\"textbold\">&nbsp;ERROR ADDING RELATED LINK: ");
		echo mysql_error();
	}

?>
</BODY>
</HTML>
