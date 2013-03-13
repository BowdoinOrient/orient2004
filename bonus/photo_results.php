<?php
function removeLastWord($theString) {
	$a = explode(" ", $theString);
	array_pop($a);
	$b = implode(" ", $a);
	return $b;
}
?>

<HTML>
<HEAD>
<TITLE>BONUS</TITLE>
<link href="orient.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY>
<p><a href="index.php"><img src="logo.jpg" border="0"></a></p>

<?php
mysql_connect("teddy","orientdba","0r1en!") or die(mysql_error() );
mysql_select_db ("DB01Orient");
?>

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
	$photofilename = $_POST['photofilename'];

$query = "

SELECT photo.CREDIT,
       photo.CAPTION,
       photo.FEATURE,
       photo.ARTICLE_FILENAME,
       photo.ARTICLE_DATE,
       s1.SHORTNAME as FEATURESECTION,
       s2.SHORTNAME as ARTICLESECTION,
       photo.ARTICLE_SECTION,
       photo.ARTICLE_PRIORITY,
       slideshow.NAME as SLIDESHOWNAME,
       photo.SLIDESHOW_PHOTO_PRIORITY,
       photo.ARTICLE_PHOTO_PRIORITY,
       author.NAME as AUTHORNAME,
       photo.ID,
       photo.SLIDESHOW_ID
FROM photo, section s1, section s2, slideshow, author
WHERE
	s1.ID = photo.FEATURE_SECTION and
	s2.ID = photo.ARTICLE_SECTION and
	slideshow.ID = photo.SLIDESHOW_ID and
	author.ID = photo.photographer and
	photo.ARTICLE_DATE LIKE '%$date' and
	s2.SHORTNAME LIKE '%$section%' and
	photo.ARTICLE_PRIORITY LIKE '%$priority' and
	photo.ARTICLE_PHOTO_PRIORITY LIKE '%$article_photo_priority' and
	photo.FEATURE LIKE '%$feature%' and
	s1.SHORTNAME LIKE '%$feature_section%' and
	photo.SLIDESHOW_PHOTO_PRIORITY LIKE '%$slideshow_photo_priority' and
	photo.CREDIT LIKE '%$photocredit%' and
	photo.CAPTION LIKE '%$photocaption%' and
	author.NAME LIKE '%$photographer%' and
	photo.ARTICLE_FILENAME LIKE '%$photofilename%' and
	slideshow.NAME LIKE '%$slideshow%'
ORDER BY
	photo.ARTICLE_DATE desc, s2.id, photo.ARTICLE_PRIORITY, photo.ARTICLE_PHOTO_PRIORITY
";


$queryresult = mysql_query ($query);
$numRows = mysql_num_rows ($queryresult);

?>

<table bgcolor="CCCCCC" cellpadding="1" width="100%"><tr><td>
<font class="textbold">&nbsp;Select a photo to edit</font><tr><td></table>

<p><b>Your search returned <?php echo $numRows ?> results.</b></p>

<p><table bgcolor="CCCCCC" cellspacing="0" cellpadding="0"><tr><td>
<table cellspacing="1" cellpadding="3">
<tr>
<td nowrap align="center" bgcolor="FFFFFF"><b>Edit</b></td>
<td nowrap bgcolor="FFFFFF"><b>Date</b></td>
<td nowrap bgcolor="FFFFFF"><b>Article</b></td>
<td bgcolor="FFFFFF" nowrap align="center"><b>Feature</b></td>
<td bgcolor="FFFFFF"><b>Information</b></td>
</tr>

<?php
while ($row = mysql_fetch_array($queryresult)) {	
	$date = $row['ARTICLE_DATE'];
	$section = $row['ARTICLESECTION'];
	$sectionID = $row['ARTICLE_SECTION'];
	$priority = $row['ARTICLE_PRIORITY'];
	$articlePriority = $row['ARTICLE_PHOTO_PRIORITY'];
	$feature = $row['FEATURE'];
	$featureSection = $row['FEATURESECTION'];
	$slideshow = $row['SLIDESHOWNAME'];
	$slideshowID = $row['SLIDESHOW_ID'];
	$slideshowPriority = $row['SLIDESHOW_PHOTO_PRIORITY'];
	$filename = $row['ARTICLE_FILENAME'];
	$photographer = $row['AUTHORNAME'];
	$credit = $row['CREDIT'];
	$caption = $row['CAPTION'];
	$photoID = $row['ID'];

?>


<tr valign="top">
	<td bgcolor="FFFFFF"><FORM method="POST" action="photo.php?type=edit">
	    	<INPUT type="hidden" name="photoid" value="<?php echo $photoID ?>">
	    	<INPUT type="submit" name="submit" value="Edit">
	    	</FORM></td>
	<td nowrap bgcolor="FFFFFF"><?php echo $date ?></td>
	<td nowrap bgcolor="FFFFFF">
		<?php if ($sectionID == 0) { } else { ?>
		<?php echo $section ?> (<?php echo $priority ?>.<?php echo $articlePriority ?>)<?php } ?>
	</td>
	<td nowrap bgcolor="FFFFFF"><?php echo $featureSection ?></td>
	<td bgcolor="FFFFFF"><?php echo $photographer ?><?php echo $credit ?><br><b>
			<?php # remove article_ from filename
				$old = array("article_");
				$new = array("");
				$newFilename = str_replace($old, $new, $filename);?><?php echo $newFilename ?></b>
			<?php if ($slideshowID == 0) { } else { ?>
		<br>Slideshow: <?php echo $slideshow ?> (<?php echo $slideshowPriority ?>)<?php } ?><br><?php echo $caption ?>
	</td>
</tr>



<?php
}
?>

</table>
</td></tr></table>

</BODY>
</HTML>
