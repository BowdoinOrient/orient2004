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




$query = "
		SELECT article.DATE,
		       	article.PRIORITY,
		       	article.TITLE,
		       	articletype.NAME as TYPENAME,
			a1.name as authorname1,
			a2.name as authorname2,
			a3.name as authorname3,
		       	section.SHORTNAME as SECTIONNAME,
		       	series.NAME as SERIESNAME,
			series.ID as SERIESID,
		       	article.section_id as SECTIONID,
		       	job.NAME as JOBNAME
		FROM 	article,
				author a1,
				author a2,
				author a3
		   INNER JOIN section ON (article.SECTION_ID = section.ID)
		   INNER JOIN articletype ON (article.TYPE = articletype.ID)
		   INNER JOIN series ON (article.SERIES = series.ID)
 		   INNER JOIN author ON (article.`AUTHOR1`  = author.ID) 
 		   INNER JOIN job ON (article.AUTHOR_JOB  = job.ID) 
		WHERE
			a1.id = article.author1 and
			a2.id = article.author2 and
			a3.id = article.author3 and
        		article.DATE LIKE '%$date' and
        		article.SECTION_ID LIKE '%$section' and
        		article.PRIORITY LIKE '%$priority' and
        		article.TEXT LIKE '%$text%' and
        		article.TITLE LIKE '%$title%' and
        		article.SUBHEAD LIKE '%$subhead%' and
        		article.PULLQUOTE LIKE '%$pullquote%' and
        		series.NAME LIKE '%$series' and
        		articletype.NAME LIKE '%$type' and
        		job.NAME LIKE '%$job' and
			(
			a1.name like '%$author1' or 
			a2.name like '%$author1' or 
			a3.name like '%$author1'
			) and
			(
			a1.name like '%$author2' or 
			a2.name like '%$author2' or 
			a3.name like '%$author2'
			) and
			(
			a1.name like '%$author3' or 
			a2.name like '%$author3' or 
			a3.name like '%$author3'
			)
		ORDER by
			article.date desc, article.section_ID, article.priority

";


$queryresult = mysql_query ($query);
$numRows = mysql_num_rows ($queryresult);

?>

<table bgcolor="CCCCCC" cellpadding="1" width="100%"><tr><td>
<font class="textbold">&nbsp;Select an article to edit</font><tr><td></table>

<p><b>Your search returned <?php echo $numRows ?> results.</b></p>

<p><table bgcolor="CCCCCC" cellspacing="0" cellpadding="0"><tr><td>
<table cellspacing="1" cellpadding="3">
<tr>
<td nowrap align="center" bgcolor="FFFFFF"><b>Edit</b></td>
<td nowrap bgcolor="FFFFFF"><b>Issue Date</b></td>
<td nowrap bgcolor="FFFFFF"><b>Section</b></td>
<td bgcolor="FFFFFF" nowrap align="center"><b>Priority</b></td>
<td nowrap bgcolor="FFFFFF"><b>Author</b></td>
<td bgcolor="FFFFFF"><b>Headline</b></td>
</tr>

<?php
while ($row = mysql_fetch_array($queryresult)) {	
	$date = $row['DATE'];
	$title = $row['TITLE'];
	$priority = $row['PRIORITY'];
	$author1 = $row['authorname1'];
	$author2 = $row['authorname2'];
	$author3 = $row['authorname3'];
	$series = $row['SERIESNAME'];
	$type = $row['TYPENAME'];
	$section = $row['SECTIONNAME'];
	$seriesID = $row['SERIESID'];
	$sectionID = $row['SECTIONID'];

?>


<tr valign="top">
	<td bgcolor="FFFFFF"><FORM method="POST" action="article.php?type=edit">
	    	<INPUT type="hidden" name="adate" value="<?php echo $date ?>">
	    	<INPUT type="hidden" name="asection" value="<?php echo $sectionID ?>">
	    	<INPUT type="hidden" name="apriority" value="<?php echo $priority ?>">
	    	<INPUT type="submit" name="submit" value="Edit">
	    	</FORM></td>
	<td nowrap bgcolor="FFFFFF"><?php echo $date ?></td>
	<td nowrap bgcolor="FFFFFF" align="center"><?php echo $section ?></td>
	<td nowrap bgcolor="FFFFFF" align="center"><?php echo $priority ?></td>
	<td nowrap bgcolor="FFFFFF"><?php echo $author1 ?><br><?php echo $author2 ?><br><?php echo $author3 ?></td>
	<td bgcolor="FFFFFF"><b><?php if ($seriesID != 0) { echo "<i>";echo $series; echo "</i>: "; } ?>
			<?php echo $title ?></b><br><?php echo $type ?></td>
</tr>



<?php
}
?>

</table>
</td></tr></table>

</BODY>
</HTML>
