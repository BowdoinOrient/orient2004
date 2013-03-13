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
	$pullquote = $_POST['pullquote'];
	$text = $_POST['text'];
	$title = $_POST['title'];
	$priority = $_POST['priority'];
	$author1 = $_POST['author1'];
	$author2 = $_POST['author2'];
	$author3 = $_POST['author3'];
	$subhead = $_POST['subhead'];
	$series = $_POST['series'];
	$type = $_POST['type'];
	$job = $_POST['job'];




$link0 = mysql_connect("teddy", "orientdba","0r1en!") or die(mysql_error() );
mysql_select_db ("DB01Orient");

$sqlQuery = "select name from author where id = '$author1'";

$res=mysql_query($sqlQuery);

if ($row = mysql_fetch_array($res)) {
	$author = $row["name"];
}

mysql_close($link0);



	# build new DB query
$sql = "
insert into `article` ( `PRIORITY`, `DATE`, `PULLQUOTE`, 
`SERIES`, `TYPE`, `SECTION_ID`, `AUTHOR1`, 
`TEXT`, `AUTHOR2`, `TITLE`, `AUTHOR3`, 
`SUBHEAD`, `AUTHOR_JOB`) values ( '$priority', '$date', '$pullquote', '$series', '$type', '$section', '$author1', 
'$text', '$author2', '$title', '$author3', '$subhead', '$job')
";
	


	# OK now upload it to Teddy.  
	$link2 = mysql_connect("teddy", "orientdba","0r1en!") or die(mysql_error() );
	mysql_select_db ("DB01Orient");
	if (mysql_query($sql)) {
		echo("

<table bgcolor=\"CCCCCC\" cellpadding=\"1\" width=\"100%\"><tr><td>
<font class=\"textbold\">&nbsp;Article added successfully</font><tr><td></table>

<p>
<FORM method=\"POST\" action=\"photouploadfromarticle.htm\">
<font class=\"textbold\">Uploaded Article: </font>\"$title\"</p><p>

<INPUT type=\"hidden\" name=\"date\" value=\"$date\">
<INPUT type=\"hidden\" name=\"section\" value=\"$section\">
<INPUT type=\"hidden\" name=\"priority\" value=\"$priority\">

<INPUT type=\"submit\" name=\"preview\" value=\"Add a photo to this article\">

</p>

");
	}
	else {
		echo("<table bgcolor=\"CCCCCC\" cellpadding=\"1\" width=\"100%\"><tr><td>
<font class=\"textbold\">&nbsp;ERROR ADDING ARTICLE: ");
		echo mysql_error();
		echo("</font><tr><td></table>");
	}

	// Closing connection
	mysql_close($link2);



?>
</BODY>
</HTML>
