<?php

include("start.php");

if(strcmp($seriesID, "")==0) {
# do error thing.
}
else  { #start noerrorpage

$sqlQuery = "

	select
		name
	from
		series
	where
		id = '$seriesID'
";

$res = mysql_query ($sqlQuery);

if ($row = mysql_fetch_array($res)) {
	$seriesName = $row["name"];
}


$sqlQuery = "

	select 
		ar.title,
		ar.date,
		date_format(ar.date, '%M %e, %Y') as fancydate,
		ar.section_id,
		ar.priority,
		j.name as jobname,
		a1.name as authorname1,
		a2.name as authorname2,
		a3.name as authorname3,
		ar.series
	from 
		article ar,
		author a1,
		author a2,
		author a3,
		job j,
		issue i
	where
		j.id = ar.author_job and
		a1.id = ar.author1 and
		a2.id = ar.author2 and
		a3.id = ar.author3 and
		ar.series = '$seriesID' and
		i.issue_date = ar.date and
		i.ready = 'y'
	order by
		ar.date desc,
		ar.title

";

$res = mysql_query ($sqlQuery);

startcode("The Bowdoin Orient - $seriesName", false, false, 0,0,0);

?>

<!--start-->

		<font class="pagetitle">Series</font><br><br>
		<font class="authorpagetext"><?php echo $seriesName ?></font><br>
<?php
while ($row = mysql_fetch_array($res)) {
	$articleTitle = $row["title"];
	$articleDate = $row["date"];
	$articleFancyDate = $row["fancydate"];
	$articleSectionID = $row["section_id"];
	$articlePriority = $row["priority"];
	$articleJob = $row["jobname"];
	$articleAuthor1 = $row["authorname1"];
	$articleAuthor2 = $row["authorname2"];
	$articleAuthor3 = $row["authorname3"];
?>

			  			  <p><font class="smallheadline"><a class="smallheadline" href="article.php?date=<?php echo "$articleDate&section=$articleSectionID&id=$articlePriority" ?> "><?php echo $articleTitle ?></a></font><br>
<?php 
	if(strcmp($articleAuthor1, "") != 0) {
?>
                    <font class="homeauthorby">By </font><font class="homeauthor"> <?php echo $articleAuthor1 ?>
<?php 
		if(strcmp($articleAuthor2, "") != 0) {
?>
                    and <?php echo $articleAuthor2 ?>
<?php 
			if(strcmp($articleAuthor3, "") != 0) {
?>
                    and <?php echo $articleAuthor3 ?>
<?php
			}
		}
?>, <?php echo $articleJob ?></font><br>
<?php
}
?>
			  <font class="articledate"><?php echo $articleFancyDate ?></font></p>
<?php
}
?>
			  
             
<p>&nbsp;</p>			  
<p><font class="text">For articles published before April 2, 2004, use the <a href="/orient/search.php">search page</a> or the <a href="/orient/archives.php">archives</a>.</p>			 

		  
<!--end-->

<?php 

include("stop.php");
} #end noerrorpage
?>