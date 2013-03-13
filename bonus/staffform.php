<HTML>
<HEAD>
<TITLE>BONUS</TITLE>
<link href="orient.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY>
<p><a href="index.php"><img src="logo.jpg" border="0"></a></p>
<?php

	# get submitted variables

	$authorName = $_POST['authorName'];
	$authorPhoto = $_POST['authorPhoto'];

$sql = "insert into author (`NAME`, `PHOTO`) values ('$authorName', '$authorPhoto')";


$link0 = mysql_connect("teddy", "orientdba","0r1en!") or die(mysql_error() );
mysql_select_db ("DB01Orient");

if (mysql_query($sql)) {
		echo("<table bgcolor=\"CCCCCC\" cellpadding=\"1\" width=\"100%\"><tr><td>
<font class=\"textbold\">&nbsp;Staff member added successfully</font><tr><td></table>
");
	}
	else {
		echo("<table bgcolor=\"CCCCCC\" cellpadding=\"1\" width=\"100%\"><tr><td>
<font class=\"textbold\">&nbsp;ERROR ADDING STAFF MEMBER: ");
		echo mysql_error();
	}

?>
</BODY>
</HTML>
