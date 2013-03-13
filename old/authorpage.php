<?php

include("start.php");

if(strcmp($authorID, "")==0) {
include("error.php");
}
else  { #start noerrorpage

$sqlQuery = "

	select
		au.name as authorname,
		j.name as job
	from
		author au,
		job j
	where
		au.job = j.id and
		au.id = '$authorID'
";

$res = mysql_query ($sqlQuery);

if ($row = mysql_fetch_array($res)) {
	$authorName = $row["authorname"];
	$authorJob = $row["job"];
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
		a3.name as authorname3
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
		i.issue_date = ar.date and
		i.ready = 'y' and
		(
		ar.author1 = '$authorID' or
		ar.author2 = '$authorID' or
		ar.author3 = '$authorID'
		)
	order by
		ar.date desc,
		ar.title

";

$res = mysql_query ($sqlQuery);

$sqlQueryphotos = "

	SELECT p.large_filename,
       		p.caption,
       		a.name AS photographer,
       		p.credit,
       		p.article_date
	FROM author a,
		photo p
	WHERE 
   		(
      			(p.photographer = a.id)
   		and 
      			(p.photographer = '$authorID')
   		)
	ORDER BY p.article_date DESC
";

$result = mysql_query ($sqlQueryphotos);

startcode("The Bowdoin Orient - $authorName", false, false, 0,0,0);

?>

<!--start-->

		<font class="pagetitle">Staff and Writers</font><br><br>
		<font class="authorpageauthortitle"><?php echo $authorName ?></font><br>

<?php
$nrows = mysql_num_rows($result);

if($nrows != 0) { ?>

            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <td height="14"></td>
              </tr>
              <tr> 
                <td height="17" bgcolor="#003366"><font class="homesection">&nbsp;Photos</font></td>
              </tr>
              <tr> 
                <td height="14"></td>
              </tr>
            </table>

<a href='javascript: rs("ss","photographerwindow.php?photographerid=<?php echo "$authorID" ?>",600,600);' class="more"><strong>Slideshow:</strong> All (<?php echo $nrows ?>) photos taken by <?php echo $authorName ?></a>

<?php
}
?>

<?php
$nrows = mysql_num_rows($res);

if($nrows != 0) { ?>

            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <td height="14"></td>
              </tr>
              <tr> 
                <td height="17" bgcolor="#003366"><font class="homesection">&nbsp;Articles</font></td>
              </tr>
              <tr> 
                <td height="14"></td>
              </tr>
            </table>

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

			  <font class="smallheadline"><a class="smallheadline" href="article.php?date=<?php echo "$articleDate&section=$articleSectionID&id=$articlePriority" ?> "><?php echo $articleTitle ?></a></font><br>
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


		  
<p><font class="text"><i>For articles published before April 2, 2004, use the <a href="/orient/archives.php">archives</a>.</i></p>		 
<?php
}
?>
		  
<!--end-->

<?php 

include("stop.php");
} #end noerrorpage
?>