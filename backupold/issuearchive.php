<?php
include("start.php");
#change first false to true gives date
#change second false to true gives "In the current Orient"
startcode("The Bowdoin Orient - Archives", false, false, $articleDate, $issueNumber, $volumeNumber);
?>

<!-- Start -->


<font class="pagetitle">Archives</font>

<p><font class="headertext">Volume <?php echo $volumeNumber ?>, Number <?php echo $issueNumber ?><br>
<?php echo $articleDate ?></font></p>

<?php

for($i = 1; $i<6; $i = $i+1) {

$sqlQuery = "select id from section where order_flag=$i";
$result=mysql_query($sqlQuery);
if($row = mysql_fetch_array($result)) {
	$section = $row["id"];
}

$sqlQuery = "
	select
		section.name as sectionname,
		section.abbrev
	from 
		section
	where
		id = '$section'
";

$result = mysql_query ($sqlQuery);

if ($row = mysql_fetch_array($result)) {
	$sectionName = $row["sectionname"];
	$abbrev = $row["abbrev"];
}

?>

<p><table width="100%" border="0" cellpadding="2" cellspacing="0">
                    <tr> 
                      <td colspan="2" valign="top"><font class="morehead"><?php echo $sectionName ?></font></td>
                    </tr>
<?php

#Article info.

$sqlQuery = "
	select
		section_id,
		priority,
		a1.name as author1,
		a2.name as author2,
		a3.name as author3,
		job.name as jobname,
		article.title,
		article.pullquote,
		series.name as series,
		articletype.name as type
	from 
		article
	inner join job on article.author_job = job.id
	inner join series on article.series = series.id
	inner join articletype on article.type = articletype.id
	inner join author a1 on article.author1 = a1.id
	inner join author a2 on article.author2 = a2.id
	inner join author a3 on article.author3 = a3.id
    where article.date = '$date'
    and article.section_id = '$section'
    order by article.priority

";

$result = mysql_query ($sqlQuery);

while($row = mysql_fetch_array($result)) {


			$articlePriority=$row["priority"];
			$articleTitle = $row["title"];
			$articleSeries = $row["series"];
			$articleType = $row["type"];
			if(strcmp($articleSeries, "") != 0) {
				$articleSeries = "$articleSeries: ";
			}

			if(strcmp($articleType, "") != 0) {
				$articleType = "$articleType: ";
			}

?>
                    <tr> 
                      <td width="4%" valign="top"><font class="moredot">&#8226;</font></td>
                      <td width="96%"><font class="more"><a class="more" href="article.php?date=<?php echo $date ?>&section=<?php echo $section ?>&id=<?php echo $articlePriority ?>"><strong><em><?php echo $articleSeries ?></em></strong><strong><?php echo $articleType ?></strong><?php echo $articleTitle ?></a></font></td>
                    </tr>
<?php
}  # while
?>

                  </table></p>

<?php
} #for(i=...
?>

<!--Photo archives-->

<table width="100%" border="0" cellpadding="2" cellspacing="0">
                    <tr> 
                      <td colspan="2" valign="top"><font class="morehead">Photos</font></td>
                    </tr>

                    <tr> 
                      <td width="4%" valign="top"><font class="moredot">&#8226;</font></td>
                      <td width="96%"><font class="more"><a href='javascript: rs("ss","slideshowwindow.php?date=<?php echo $date ?>",600,600);' class="more"><strong>Slideshow:</strong> All photos from this issue</a></font></td>
                    </tr>


<?php
$sqlQuery = "
	select
		name,
		id
	from
		slideshow
	where
		date = '$date'
";

$result = mysql_query($sqlQuery);

while($row = mysql_fetch_array($result)) {
	$slideshowID = $row["id"];
	$slideshowname = $row["name"];
?>

                    <tr> 
                      <td width="4%" valign="top"><font class="moredot">&#8226;</font></td>
                      <td width="96%"><font class="more"><a href='javascript: rs("ss","slideshowwindow.php?date=<?php echo "$date&slideshowid=$slideshowID" ?>",600,600);' class="more"><strong>Slideshow:</strong> <?php echo $slideshowname ?><i> (Web extra)</i></a></font></td>
                    </tr>


<?php
}
?>
</p>

<!-- Stop -->

<?php
include("stop.php");
?>