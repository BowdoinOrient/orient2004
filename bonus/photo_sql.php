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

	$photoID = $_POST['photoid'];

	$date = $_POST['date'];
	$section = $_POST['section'];
	$priority = $_POST['priority'];
	$slideshow = $_POST['slideshow'];
	$slideshow_photo_priority = $_POST['slideshow_photo_priority'];
	$article_photo_priority = $_POST['article_photo_priority'];
	$feature = $_POST['feature'];
	$feature_section = $_POST['feature_section'];
	$photocaption = $_POST['photocaption'];
	$photographer = $_POST['photographer'];
	$photocredit = $_POST['photocredit'];
	$photoTemp = explode("\\", $_POST['photofilename']);
	$photofilename = $photoTemp[(sizeof($photoTemp)-1)];
	$thumbfilename = "thumb_$photofilename";

if($article_photo_priority == 1) {

$sql = "select name from author where id = $photographer";
	
	$link0 = mysql_connect("teddy", "orientdba","0r1en!") or die(mysql_error() );
	mysql_select_db ("DB01Orient");
	$res = mysql_query($sql);
	$row = mysql_fetch_array($res);
	if (strcmp($row["name"],"")!=0) {
		$photocreditname = $row["name"];
		$photocreditname = "$photocreditname, <i>Bowdoin Orient</i>";
	}
	else {
		$photocreditname = $photocredit;
	}

	// Closing connection
	mysql_close($link0);

}


if ($type == add) { 
	$sql = "
	insert into `photo` ( `CAPTION`, `ARTICLE_PRIORITY`, 
	`SLIDESHOW_ID`, `THUMB_FILENAME`, `ARTICLE_FILENAME`, `LARGE_FILENAME`, `SFEATURE_FILENAME`, `FFEATURE_FILENAME`, `FEATURE_SECTION`, 
	`SLIDESHOW_PHOTO_PRIORITY`, `ARTICLE_SECTION`, 
	`ARTICLE_DATE`, `PHOTOGRAPHER`, `CREDIT`, `FEATURE`, 
	`ARTICLE_PHOTO_PRIORITY`) values ( '$photocaption', '$priority', '$slideshow', 
	'thumb_$photofilename', 'article_$photofilename', 'large_$photofilename', 'article_$photofilename', 'ffeature_$photofilename', '$feature_section', '$slideshow_photo_priority', '$section', '$date', '$photographer', '$photocredit', '$feature', '$article_photo_priority')
	";
}


if ($type == edit) { 
	$sql = "
	UPDATE photo
	SET
		CAPTION = '$photocaption',
		ARTICLE_PRIORITY = '$priority',
		SLIDESHOW_ID = '$slideshow',
		THUMB_FILENAME = 'thumb_$photofilename',
		ARTICLE_FILENAME = 'article_$photofilename',
		LARGE_FILENAME = 'large_$photofilename',
		SFEATURE_FILENAME = 'article_$photofilename',
		FFEATURE_FILENAME = 'ffeature_$photofilename',
		FEATURE_SECTION = '$feature_section',
		SLIDESHOW_PHOTO_PRIORITY = '$slideshow_photo_priority',
		ARTICLE_SECTION = '$section',
		ARTICLE_DATE = '$date',
		PHOTOGRAPHER = '$photographer',
		CREDIT = '$photocredit',
		FEATURE = '$feature',
		ARTICLE_PHOTO_PRIORITY = '$article_photo_priority'
	WHERE
		ID = '$photoID'
	";

}

if ($type == delete) { 
	$sql = "
	DELETE FROM photo
	WHERE
		ID = '$photoID'
	";
}






$link = mysql_connect("teddy", "orientdba","0r1en!") or die(mysql_error() );
mysql_select_db ("DB01Orient");

if (mysql_query($sql)) {
	echo("
		<table bgcolor=\"CCCCCC\" cellpadding=\"1\" width=\"100%\"><tr><td>
		<font class=\"textbold\">&nbsp;
	");

	if ($type == add) { echo("Photo added successfully"); }
	if ($type == edit) { echo("Photo edited successfully"); }
	if ($type == delete) { echo("Photo deleted successfully"); }
		
	echo("
		</font><tr><td></table>
	");
	}
else {
	echo("<table bgcolor=\"CCCCCC\" cellpadding=\"1\" width=\"100%\"><tr><td>
		<font class=\"textbold\">&nbsp;
	");

	if ($type == add) { echo("ERROR ADDING PHOTO: "); }
	if ($type == edit) { echo("ERROR EDITING PHOTO: "); }
	if ($type == delete) { echo("ERROR DELETING PHOTO: "); }

	echo mysql_error();

	echo("</font><tr><td></table>
	");
	}

?>

</BODY>
</HTML>