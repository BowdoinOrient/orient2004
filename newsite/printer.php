<?php

include("template/top.php");
# Article Query
$sqlQuery = "

	select
		
		s.name as sectionname,
		ar.priority,
		ar.author1,
		a1.name as author1name,
		a1.photo as author1photo,
		ar.author2,
		a2.name as author2name,
		a2.photo as author2photo,
		ar.author3,
		a3.name as author3name,
		a3.photo as author3photo,
		j.name as jobname,
		ar.title,
		ar.subhead,
		ar.text,
		at.name as type
	from section s,
		article ar,
		author a1,
		author a2,
		author a3,
		job j,
		articletype at
	where
		ar.type = at.id and
		ar.author_job = j.id and
		ar.section_id = s.id and
		ar.author1 = a1.id and
		ar.author2 = a2.id and 
		ar.author3 = a3.id and
		ar.date = '$date' and
		ar.section_id = '$section' and 
		ar.priority = '$priority'
";

$result = mysql_query ($sqlQuery);

if ($row = mysql_fetch_array($result)) {
	$sectionName = $row["sectionname"];
	$articleAuthor1 = $row["author1name"];
	$articleAuthor2 = $row["author2name"];
	$articleAuthor3 = $row["author3name"];
	$articleAuthorID1 = $row["author1"];
	$articleAuthorID2 = $row["author2"];
	$articleAuthorID3 = $row["author3"];
	$articleAuthorPhoto1 = $row["author1photo"];
	$articleAuthorPhoto2 = $row["author2photo"];
	$articleAuthorPhoto3 = $row["author3photo"];
	$articleJob = $row["jobname"];
	$articleSubhead = $row["subhead"];
	$articleTitle = $row["title"];
	$articleCaption = $row["photo_caption"];
	$articlePhotoCredit = $row["photo_credit"];
	$articleText = $row["text"];
	$articleImage = $row["photo_filename"];
	$articlePhotoPosition = $row["photo_position"];
	$articleType = $row["type"];
	

$title = "$sectionName - $articleTitle";


# Issue Query
$sqlQuery = "
	select
		date_format(article.date, '%M %e, %Y') as date,
		issue.issue_number,
		volume.numeral
	from article
	inner join issue on article.date = issue.issue_date
	inner join volume on issue.volume_id = volume.id
	where article.date = '$date'
";

$res = mysql_query ($sqlQuery);

if ($row = mysql_fetch_array($res)) {
	$articleDate = $row["date"];
	$issueNumber = $row["issue_number"];
	$volumeNumber = $row["numeral"];
}





?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo removeText(removeText($articleTitle,"<i>"), "</i>"); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
# This checks if the domain requested is studorgs.bowdoin.edu
# and tells search engines not to index the page if it is.   
if(strcmp($_SERVER["HTTP_HOST"], "studorgs.bowdoin.edu")==0) {
?>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<?php
}
?>
<link href="css/oldorient.css" rel="stylesheet" type="text/css">
</head>

<body class="printer">
<img src="/orient/images/whiteminilogo.jpg" width="277" height="26">
<hr size="1" noshade>
<p>
<?php
if(strcmp($articleType, "") != 0) {
?>
<font class="articletype"><?php echo $articleType ?></font><br>
<?php
}
?>
  <font class="articleheadline"><?php echo $articleTitle ?></font><br>
<?php
if(strcmp($articleSubhead, "")!=0) {
?>
  <font class="articlesubhead"><?php echo $articleSubhead ?><br>
<?php 
} 
?>
  </font><font class="articledate"><?php echo $articleDate ?></font></p>
<?php
if(strcmp($articleAuthor1, "")!=0) { # if we have any authors
?>
<p><font class="articleauthorbold">By <?php 
				echo $articleAuthor1;
				if(strcmp($articleAuthor2, "")!= 0) {
					echo " and $articleAuthor2";
				}
				if(strcmp($articleAuthor3, "")!= 0) {
					echo " and $articleAuthor3";
				}
			
			?></font><br>
<?php
}
?>
<font class="articleauthorjob"><?php echo $articleJob ?></font>
<p>
  <!--Series code goes here-->
</p>


                  
                 
                  <font class="text"><?php echo $articleText ?></font> 
<p>&nbsp;</p>
Copyright &copy; 2007, The Bowdoin Orient</p>

<!-- Start of StatCounter Code -->
<script type="text/javascript" language="javascript">
var sc_project=279507; 
var sc_partition=0; 
</script>

<script type="text/javascript" language="javascript" src="http://www.statcounter.com/counter/counter.js"></script><noscript><a href="http://www.statcounter.com/" target="_blank"><img  src="http://c1.statcounter.com/counter.php?sc_project=279507&amp;amp;java=0" alt="counter statistics" border="0"></a> </noscript>
<!-- End of StatCounter Code -->

</body>
</html>

<?php

	}

else {
	print "Sorry, no records were found!";
}
?>