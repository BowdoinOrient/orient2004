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

	$adate = $_POST['adate'];
	$asection = $_POST['asection'];
	$apriority = $_POST['apriority'];

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
	$articletype = $_POST['type'];
	$job = $_POST['job'];




if ($type == add) { 
	$sql = "
	INSERT INTO article
	(`DATE`, `SECTION_ID`, `PRIORITY`, `AUTHOR1`, `AUTHOR2`, `AUTHOR3`, `AUTHOR_JOB`, `TITLE`, `SUBHEAD`, `TEXT`, `PULLQUOTE`, `TYPE`, `SERIES`) 
	VALUES ('$date', '$section', '$priority', '$author1', '$author2', '$author3', '$job', '$title', '$subhead', '$text', '$pullquote', '$articletype', '$series')
	";
}


if ($type == edit) { 
	$sql = "
	UPDATE article
	SET
		DATE = '$date',
		SECTION_ID = '$section',
		PRIORITY = '$priority',
		AUTHOR1 = '$author1',
		AUTHOR2 = '$author2',
		AUTHOR3 = '$author3',
		AUTHOR_JOB = '$job',
		TITLE = '$title',
		SUBHEAD = '$subhead',
		TEXT = '$text',
		PULLQUOTE = '$pullquote',
		TYPE = '$articletype',
		SERIES = '$series'
	WHERE
		DATE = '$adate' and
		SECTION_ID = '$asection' and
		PRIORITY = '$apriority'
	";
}

if ($type == delete) { 
	$sql = "
	DELETE FROM article
	WHERE
		DATE = '$adate' and
		SECTION_ID = '$asection' and
		PRIORITY = '$apriority'
	";
}



$link = mysql_connect("teddy", "orientdba","0r1en!") or die(mysql_error() );
mysql_select_db ("DB01Orient");

if (mysql_query($sql)) {
	echo("
		<table bgcolor=\"CCCCCC\" cellpadding=\"1\" width=\"100%\"><tr><td>
		<font class=\"textbold\">&nbsp;
	");

	if ($type == add) { echo("Article added successfully"); }
	if ($type == edit) { echo("Article edited successfully"); }
	if ($type == delete) { echo("Article deleted successfully"); }
		
	echo("
		</font><tr><td></table>
	");
	}
else {
	echo("<table bgcolor=\"CCCCCC\" cellpadding=\"1\" width=\"100%\"><tr><td>
		<font class=\"textbold\">&nbsp;
	");

	if ($type == add) { echo("ERROR ADDING ARTICLE: "); }
	if ($type == edit) { echo("ERROR EDITING ARTICLE: "); }
	if ($type == delete) { echo("ERROR DELETING ARTICLE: "); }

	echo mysql_error();

	echo("</font><tr><td></table>
	");
	}

if ($type == add) {

echo("

	<p>
	<FORM method=\"POST\" action=\"photo.php?type=addFromArticle\">
	<font class=\"textbold\">Uploaded Article: </font>\"$title\"</p><p>
	<INPUT type=\"hidden\" name=\"adate\" value=\"$date\">
	<INPUT type=\"hidden\" name=\"asection\" value=\"$section\">
	<INPUT type=\"hidden\" name=\"apriority\" value=\"$priority\">
	<INPUT type=\"submit\" name=\"preview\" value=\"Add a photo to this article\">
	</p>

");

}



?>

</BODY>
</HTML>
