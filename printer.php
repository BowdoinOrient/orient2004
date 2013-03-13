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
<meta name="robots" content="noindex">
<link href="css/orient.css" rel="stylesheet" type="text/css">

<style>
body {
	font-family: Georgia, Palatino, serif;
	font-size: 10pt;
	line-height: 15pt;
}

hr {
	background: rgb(0, 0, 0);
	border: none;
	clear: both;
	color: rgb(0, 0, 0);
	float: none;
	height: 1px;
	margin: 0px 0px 1.45em;
	width: 100%;
	border-width: 1px;
	display: block;
}

.articleauthor {
	font-family: 'Helvetica Neue', Arial Narrow, Helvetica, sans-serif;
	font-weight: bold;
}

.articleauthorjob {
	font-family: 'Helvetica Neue', Arial Narrow, Helvetica, sans-serif;
}

.articledate {
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-right-width: 0px;
	border-top-width: 0px;
	color: rgb(85, 85, 85);
	display: block;
	font-family: georgia, palatino;
	font-size: 12px;
	font-style: normal;
	font-weight: normal;
	height: 12px;
	line-height: 12px;
	margin-bottom: 12px;
	margin-left: 0px;
	margin-right: 0px;
	margin-top: 0px;
	padding-bottom: 0px;
	padding-left: 0px;
	padding-right: 0px;
	padding-top: 0px;
	vertical-align: baseline;
	width: 630px;
}

.header{
	margin-top: 15px;
	margin-bottom: 10px;
}

.headerleft{
	text-align: left;
}

.headercenter{
	text-align: center;
}

.headerright{
	text-align: right;
}

</style>

</head>

<body class="printer">
<center>
<?php echo "<a href='article.php?date=".$_GET['date']."&section=".$_GET['section']."&id=".$_GET['id']."'>"?><img src="/orient/images/banner_sm.png" width="451" height="55"></a>
</center>

<div class="header">
<table width="100%">
<tr>
<td width="25%" class="headerleft">BRUNSWICK, ME</td>
<td width="50%" class="headercenter">THE NATION'S OLDEST CONTINUOUSLY PUBLISHED COLLEGE WEEKLY</td>
<td width="25%" class="headerright"><?php echo strtoupper($articleDate) ?></td>
<tr>
</table>
<hr style="margin-bottom:3px">
<hr style="height:2px;">
</div>

<p>
<?php
if(strcmp($articleType, "") != 0) {
?>
<font class="articletype"><?php echo $articleType ?></font><br>
<?php
}
?>
  <h2 class="articletitle top bottom"><?php echo $articleTitle ?></h2>
<?php
if(strcmp($articleSubhead, "")!=0) {
?>
  <font class="articlesubhead"><?php echo $articleSubhead ?><br>
<?php 
} 
?>
  </font><!--<h3 class="articledate"><?php echo $articleDate ?></h3>--></p>
<?php
if(strcmp($articleAuthor1, "")!=0) { # if we have any authors
?>
<p><font class="articleauthor">BY <?php 
				echo strtoupper($articleAuthor1);
				if(strcmp($articleAuthor2, "")!= 0) {
					echo " and ".strtoupper($articleAuthor2);
				}
				if(strcmp($articleAuthor3, "")!= 0) {
					echo " and ".strtoupper($articleAuthor3);
				}
			
			?></font><br>
<?php
}
?>
<font class="articleauthorjob"><?php echo strtoupper($articleJob) ?></font>
<p>
  <!--Series code goes here-->
</p>


                  
                 
                  <font class="text"><?php echo $articleText ?></font> 
<p>&nbsp;</p>
<hr>
Copyright &copy; <?php echo date("Y"); ?>, The Bowdoin Orient</p>

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