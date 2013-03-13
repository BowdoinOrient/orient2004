<?php 
	include("start.php");
	
	# On break messages
	
	$summerBreak = false;
	$summerBreak_year = "2007-2008";
	
	$fallBreak = false;
	$fallBreak_resumeDate = "Friday, October 12";
	
	
	#front page feature photo query
	$sqlQuery = "
		select
			p.article_section,
			p.article_priority,
			p.ffeature_filename,
			a.name as photographer,
			p.caption,
			p.credit,
			p.feature_section,
			a.id
		from 
			photo p,
			author a
		where 
			p.photographer = a.id and
			p.article_date = '$date' and 
			p.feature = 'y' and
			p.feature_section  = '10'
		";

	$result = mysql_query($sqlQuery);
	$anyPhotos = false;
	$multiplePhotos = false;
	$relatedArticle = true;

	if($row = mysql_fetch_array($result)) 
	{
		$anyPhotos = true;
		$photoFilename = $row["ffeature_filename"];
		$photoSection = $row["article_section"];
	
		if($photoSection == 0) 
		{
			$relatedArticle = false;
		}

		$photoFeatureSection = $row["feature_section"];
		$photoPriority = $row["article_priority"];
		$photographer = $row["photographer"];

		if(strcmp($photographer, "") != 0) 
		{
			$photographer = "$photographer, The Bowdoin Orient";
			$photographerlink = true;
		}

		$credit = $row["credit"];
		$photoCredit = "$photographer$credit";

		$photoCaption = $row["caption"];
		$photographerID = $row["id"];
		
		if(mysql_num_rows($result) > 1) 
			$multiplePhotos = true;
	}
	else 
	{
		echo "$sqlQuery<br>";
		echo mysql_error();
	}
	
	$dateQuery = "SELECT issue_date FROM issue ORDER BY issue_date DESC LIMIT 0, 1";
	$latestDate = mysql_result(mysql_query($dateQuery), 0);
	
	$latestArticles = mysql_query("SELECT section_id, priority, author1, author2, author3, title, subhead, pullquote, views FROM article WHERE date='$latestDate' ORDER BY views DESC LIMIT 0, 5");
	
	startcode("The Bowdoin Orient",true,false,$articleDate,$issueNumber,$volumeNumber,"yes");
?>             

<!--NOTE: Homepage section starts here-->

<!-- NOTE: Breaking News section starts here

<div id="breaking_news">
	<div id="bn_title">BREAKING NEWS</div>
	<div class="bn_header">WILLEY WINS SAFC SEAT</div>
	<div class="bn_subheader">WEB UPDATED APRIL 26, 2007 9:53 PM</div>
	<div class="hometext">Nicole Willey '08 will serve as the next SAFC treasurer. Elections closed at 8:30 p.m. Thursday. Willey received 273 votes. Clark Gascoigne '08 received 255 votes and John Masland '08 received 181.</div>
</div>


<div id="front_page_title">FRIDAY'S FRONT PAGE AND OTHER NEWS</div>-->

				<!--VACATION MESSAGE--> <?php if($summerBreak) { ?>
				  <div style="border-width: 1px 0 1px 0; border-color: #CCCCCC; border-style: solid; padding: 15px 5px 5px 5px">
					<font class="notetitle">SUMMER BREAK</font>
					<p><font class="notetext">The Orient has concluded publication for the <?php echo $summerBreak_year; ?> academic year. Be sure to check out our <a href="http://orient.bowdoin.edu/orient/article.php?date=2007-05-04&section=3&id=1">Year in Review</a>, and have a great summer!</font></p>
				</div>
				<br>
				<?php } ?>
				
				<?php if ($fallBreak) { ?>
					<div style='border-width: 1px 0 1px 0; border-color: #ccc; border-style: solid; padding: 15px 5px 5px 5px'>
					<font class="notetitle">FALL BREAK</font>
					<p><font class="notetext">Due to Fall Break, there is no Orient this week. Publication will resume on <?php echo $fallBreak_resumeDate; ?>.</font></p>
					</div>
					<br />
				<?php } ?>

<!--NOTE: Features section starts here-->
<?php
	# section info.
	$limit = 3;

	for($i = 1; $i<6; $i = $i+1) 
	{
		$sqlQuery = "select id from section where order_flag=$i";
		$result = mysql_query($sqlQuery);

		if($row = mysql_fetch_array($result)) 
			$section = $row["id"];

		$sqlQuery = "
			select
				section.name as sectionname,
				section.abbrev
			from 
				section
			where
				id = '$section'
			";

		$result = mysql_query($sqlQuery);

		if ($row = mysql_fetch_array($result)) 
		{
			$sectionName = $row["sectionname"];
			$abbrev = $row["abbrev"];
		}
			
		if($i != 1)  
		{
			?>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			  <tr> 
				<td height="14"></td>
			  </tr>
			  <tr> 
				<td height="17" bgcolor="#003366"><font class="homesection">&nbsp;<a class="homesection" href="section.php?<?php echo "date=$date&section=$section" ?>"><?php echo $sectionName ?></a></font></td>
			  </tr>
			  <tr> 
				<td height="14"></td>
			  </tr>
			</table>
			<?php
		}
			?>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="center" valign="top"> 
                <td width="310"> <div align="left">

			<?php
				# Thumbnail info.
				$sqlQuery = "
					select 
						thumb_filename
					from
						photo
					where
						article_section = '$section' and
						article_date = '$date' and
						article_priority = '$priority'
					";
				
				$result = mysql_query($sqlQuery);

				if($row = mysql_fetch_array($result)) 
					$thumbFilename = $row["thumb_filename"];

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
				$counter = 0;

				for($counter = 0; $counter < $limit; $counter=$counter+1)  
				{
					if ($row = mysql_fetch_array($result))  
					{
						$articleSection=$row["section_id"];
						$articlePriority=$row["priority"];
						$articleAuthor1 = $row["author1"];					
						$articleAuthor2 = $row["author2"];					
						$articleAuthor3 = $row["author3"];
						$articleJob = $row["jobname"];
						$articleTitle = $row["title"];
						$articlePullquote = $row["pullquote"];
						$thumbPosition = $row["thumb_position"];
						$articleSeries = $row["series"];
						$articleType = $row["type"];
						
						if(strcmp($articleType, "") != 0) 
						{
							?>
							<font class="hometype"><?php echo $articleType ?></font><br>
							<?php
						}

						?>

						<font class="homeheadline"><a class="homeheadline" href="article.php?<?php echo "date=$date&section=$articleSection&id=$articlePriority" ?>"><?php if(($section != 1) && (strcmp($thumbFilename, "")!=0)) { ?><img border="1" class="thumb" src="images/<?php echo "$date/$thumbFilename" ?>" align="right" alt="Picture"><?php } ?>
						
						<?php 
						$thumbFilename = "";

						if(strcmp($articleSeries, "") != 0)
							echo "<i>$articleSeries:</i> ";
						
						echo $articleTitle; 
						echo '</a></font><br>';

						if(strcmp($articleAuthor1, "") != 0) 
						{
							?>
							
							<font class="homeauthorby">By </font><font class="homeauthor"> <?php echo $articleAuthor1;

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
	 <font class="hometext"> <?php echo $articlePullquote ?>
                    </font> <br><br>
<?php 
		}
	}
?>




	</div></td>
                <td width="13">&nbsp;</td>
                <td width="310">
				
<?php
if($section == 1) {
?>

				<!--NOTE: News feature photo section starts here-->




<!--browser upgrade alert-->
<div align="left" class="hide"><font class="browserred">Browser Upgrade Alert: </font><font class="browser">
You are currently using an old web browser that will likely display some formatting anomolies. This website renders beautifully in newer web browsers. Please <a href="/orient/browserupgrade.php">upgrade your web browser</a> to enjoy the <i>Orient's</i> website at its best.<br><br>
</font></div>



	<?php 
	if($anyPhotos == true) {
	?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td><img src="images/<?php echo $date ?>/<?php echo $photoFilename ?>" border="1" alt="Picture"></td>
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
                        <a class="photorelated" href="article.php?<?php echo "section=$photoSection&date=$date&id=$photoPriority" ?>">See feature article...</a></font><?php
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

				<!--NOTE: More Features section starts here-->
				
				<table width="100%" border="0" cellpadding="2" cellspacing="0">
                    <tr> 
                      <td colspan="2" valign="top"><font class="morehead"><a class="morehead" href="section.php?<?php echo "date=$date&section=$section" ?>">More 
                        <?php echo $sectionName ?></a></font></td>
                    </tr>
<?php


	        while ($row = mysql_fetch_array($result))  {

			$articleSection=$row["section_id"];
			$articlePriority=$row["priority"];

			$articleAuthor = $row["author"];

			$articleJob = $row["jobname"];

			$articleTitle = $row["title"];

			$articlePullquote = $row["pullquote"];

			$articleThumb = $row["thumb_filename"];

			$thumbPosition = $row["thumb_position"];
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
                      <td width="3%" valign="top"><font class="moredot">&#8226;</font></td>
                      <td width="97%"><font class="more"><a class="more" href="article.php?date=<?php echo "$date&section=$articleSection&id=$articlePriority" ?>"><strong><em><?php echo $articleSeries ?></em></strong><strong><?php echo $articleType ?></strong><?php echo $articleTitle ?></a></font></td>
                    </tr>
<?php

		}

?>



                  </table>
				
<?php if($articleSection == 1) { ?>
<p><table width="100%" border="0" cellpadding="2" cellspacing="0">
                    <tr> 
                      <td colspan="2" valign="top"><font class="morehead">Extras</font></td>
                    </tr>
<!-- headlines from nyt -->
                    <tr> 
                      <td width="3%" valign="top"><font class="moredot">&#8226;</font></td>
                      <td width="97%"><font class="more"><select onChange="document.location=this.value;">
                      	<?php
                      		for ($k = 0; $k < mysql_num_rows($latestArticles); $k++) {
                      			echo "<option value='article.php?date=$latestDate&section=" . mysql_result($latestArticles, $k, "section_id") . "&id=" . mysql_result($latestArticles, $k, "priority") . "'>" . (strlen(mysql_result($latestArticles, $k, "title")) < 40 ? mysql_result($latestArticles, $k, "title") : substr(mysql_result($latestArticles, $k, "title"), 0, 40) . "...") . "</option>";
                      		}
                      	?>
                      </select></font></td>


<!--                      <td width="97%"><font class="more"><a class="more" href="nyt.php"><strong>Headlines from <i>The New York Times</i></strong></a></font></td> -->
                    </tr>

<!-- weather from weather.com -->
                    <tr> 
                      <td width="3%" valign="top"><font class="moredot">&#8226;</font></td>
                      <td width="97%"><font class="more"><a class="more" href="weather.php"><strong>Current weather in Brunswick, Maine</strong></a></font></td>
                    </tr>
</table></p>
<?php } ?>






  
				  <!--NOTE: More Features section end here-->
				  
				  </td>
              </tr>
            </table>
<?php

$limit = 1;

}
?>
			
			<!--NOTE: Features section end here-->


			
            <!--NOTE: Homepage section ends here-->
			
			
<?php include("stop.php") ?>