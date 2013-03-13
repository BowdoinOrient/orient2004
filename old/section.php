<?php

include("start.php");




# Issue Query
$sqlQuery = "
	select
		date_format(issue.issue_date, '%M %e, %Y') as date,
		issue.issue_number,
		volume.numeral
	from issue
	inner join volume on issue.volume_ID = volume.ID
	where issue.issue_date = '$date'
";

$res = mysql_query ($sqlQuery);

if ($row = mysql_fetch_array($res)) {
	$articleDate = $row["date"];
	$issueNumber = $row["issue_number"];
	$volumeNumber = $row["numeral"];
}



#Section info.

# we don't use the following code.  stay consistent.  
#$sqlQuery = "select order_flag from section where id=$section";
#$result=mysql_query($sqlQuery);
#if($row = mysql_fetch_array($result)) {
#	$section = $row["order_flag"];
#}

$sqlQuery = "

    select
		section.name as sectionname,
		section.abbrev
    from section
    where ID = '$section'

";

$result = mysql_query ($sqlQuery);

if ($row = mysql_fetch_array($result)) {
	$sectionName = $row["sectionname"];
	$abbrev = $row["abbrev"];
}


startcode("The Bowdoin Orient - $sectionName", true, false, $articleDate, $issueNumber, $volumeNumber);


?>


              
            <!--NOTE: Homepage section starts here-->
			
			<!--NOTE: Section starts here-->

<font class="sectiontitle"><?php echo $sectionName ?></font><p>

            <table width="800px" border="0" cellpadding="0" cellspacing="0">
              <tr align="center" valign="top"> 
                <td> <div align="left"> 




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
	from article
	inner join job on article.author_job = job.ID
	inner join series on article.series = series.ID
	inner join articletype on article.type = articletype.ID
	inner join author a1 on article.author1 = a1.id
	inner join author a2 on article.author2 = a2.id
	inner join author a3 on article.author3 = a3.id
    where article.date = '$date'
    and article.section_ID = '$section'
    order by article.priority
";

$result = mysql_query ($sqlQuery);

        $counter = 0;

#        $limit = 1;
 #       if($i == 1) { $limit = 3 };

	        while ($row = mysql_fetch_array($result))  {
			$articleSection=$row["section_id"];
			$articlePriority=$row["priority"];
			$articleAuthor1 = $row["author1"];
			$articleAuthor2 = $row["author2"];
			$articleAuthor3 = $row["author3"];
			$articleJob = $row["jobname"];
			$articleTitle = $row["title"];
			$articlePullquote = $row["pullquote"];
			$articleSeries = $row["series"];
			$articleType = $row["type"];
			
# Thumbnail info.

$sqlQueryThumb = "

	select 
		thumb_filename
	from
		photo
	where
		article_section = '$articleSection' and
		article_date = '$date' and
		article_priority = '$articlePriority' and
		(
		feature_section <> '$articleSection' or
		feature = 'n'
		)
";

$resultThumb = mysql_query($sqlQueryThumb);

if($rowThumb = mysql_fetch_array($resultThumb)) {

	$thumbFilename = $rowThumb["thumb_filename"];

}

			
     
?>
<?php
	if(strcmp($articleType, "") != 0) {
?>
		<font class="hometype"><?php echo $articleType ?></font><br>
<?php
	}
?>	
	<font class="homeheadline"><a class="homeheadline" href="article.php?<?php echo "date=$date&section=$articleSection&id=$articlePriority" ?>"> 

<?php if(strcmp($thumbFilename, "")!=0) { ?><img border="1" class="thumb" src="../images/<?php echo "$date/$thumbFilename" ?>" align="right" alt="Picture"><?php } ?> 
<?php 
$thumbFilename = "";
?>


<?php
	if(strcmp($articleSeries, "") != 0) {
		echo "<i>$articleSeries:</i> ";
	}
?>
                    <?php echo $articleTitle ?></a></font><br>
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
?>
, <?php echo $articleJob ?> </font><br>
<?php 
	}
?>                   
	 <font class="hometext"> <?php echo $articlePullquote ?> <!--<a href="more.htm" class="homeelipse">...</a> -->
                    </font> <br><br>
<?php 
		}
	
?>

	</div></td>
                <td width="1">&nbsp;&nbsp;&nbsp;</td>
                <td width="1">
				

		<!--NOTE: Section feature photo section starts here-->

<?php
# section feature photo query

$sqlQuery = " 



	select
		p.article_section,
		p.feature_section,
		p.article_priority,
		p.sfeature_filename,
		a.name as photographer,

		p.caption,
		a.id,
		p.credit

	from 
		photo p,
		author a

	where 
		p.photographer = a.id and
		p.article_date = '$date' and 
		p.feature = 'y' and
		p.feature_section  = '$articleSection'

";



$result = mysql_query ($sqlQuery);

$anyPhotos = false;
$multiplePhotos = false;
$relatedArticle = false;
while ($row = mysql_fetch_array($result)) {
	$anyPhotos = true;
	$photoFilename = $row["sfeature_filename"];
	$photoSection = $row["article_section"];
	if($photoSection == 0) {
		$relatedArticle = false;
	}
	else {
		$relatedArticle = true;
	}
	$photoFeatureSection = $row["feature_section"];
	$photoPriority = $row["article_priority"];
	$photographer = $row["photographer"];
	if(strcmp($photographer, "") != 0) {
		$photographer = "$photographer, Bowdoin Orient";
		$photographerlink = true;
	}

	$credit = $row["credit"];
	$photoCredit = "$photographer$credit";

	$photoCaption = $row["caption"];


	$photographerID = $row["id"];



?>


	<?php 
	if($anyPhotos == true) {
		
		$multiplePhotos = false;	
		if($relatedArticle == true) {
			$sqlQuery2 = " 
		 		select
					*
				from 
					photo
				where 
					article_date = '$date' and
					article_priority = '$photoPriority' and
					article_section  = '$photoSection'
			";

		
			$result2 = mysql_query ($sqlQuery2);
		

			if(mysql_num_rows($result2) > 1)  {
				$multiplePhotos = true;
			}
		}

	?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td><img src="../images/<?php echo $date ?>/<?php echo $photoFilename ?>" border="1" alt="Picture"></td>
                    </tr>
                    <tr>
                      <td height="3"></td>
                    </tr>
                    <tr> 
                      <td><div align="right"><font class="photoenlarge"><a class="photoenlarge" href='javascript: rs("ss","picturewindow.php?<?php echo "section=$photoSection&featuresection=$photoFeatureSection&date=$date&id=$photoPriority" ?>", 600,600);'><?php if($multiplePhotos==true) { ?>see more pictures / <?php } ?>click 
                          to enlarge</a></font></div></td>
                    </tr>
                    <tr>
                      <td height="3"></td>
                    </tr>
                    <tr> 
                      <td><div align="right">

	<?php
	if($photographerlink == true) {
	?>

	<a class="photocredit" href="/orient/authorpage.php?authorid=<?php echo $photographerID ?>">

	<?php
	}
	?>

	<font class="photocredit"><?php echo $photoCredit ?></font>

	<?php
	if($photographerlink == true) {
	?>

	</a>

	<?php
	}
	?>



			</div></td>
                    </tr>
                    <tr>
                      <td height="3"></td>
                    </tr>
                    <tr> 
                      <td><font class="photocaption"><?php echo $photoCaption ?></font><?php
if($relatedArticle == true) {
?>
<font class="photorelated"> 
                        <a class="photorelated" href="article.php?<?php echo "section=$photoSection&date=$date&id=$photoPriority" ?>">See related article...</a></font><?php
}
?><br>
</td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td height="2" bgcolor="#FFFFFF"></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td height="15"></td>
                    </tr>
                  </table>

<?php
	}
}

?>
				
				  
				  </td>
              </tr>
            </table>
<?php

$limit = 1;

?>
			
			
            <!--NOTE: Homepage section ends here-->
			
<?php include("stop.php"); ?>