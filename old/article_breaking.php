<?php

include("start.php");

# Article Query
$sqlQuery = "	select		s.name as sectionname,		ar.priority,
		ar.author1,		a1.name as author1name,
		a1.photo as author1photo,
		ar.author2,
		a2.name as author2name,
		a2.photo as author2photo,
		ar.author3,
		a3.name as author3name,
		a3.photo as author3photo,		j.name as jobname,		ar.title,
		ar.subhead,		ar.text,
		at.id as typenumber,
		at.name as type,
		series.name as series,
		series.id as series_id,
		s.order_flag
	from 
		section s,
		article ar,
		author a1,
		author a2,
		author a3,
		job j,
		articletype at,
		series
	where
		ar.author_job = j.id and
		ar.section_id = s.id and
		ar.author1 = a1.id and
		ar.author2 = a2.id and 
		ar.author3 = a3.id and
		ar.type = at.id and
		ar.series = series.id and
		ar.date = '$date' and
		ar.section_id = '$section' and 
		ar.priority = '$priority'
";

$result = mysql_query ($sqlQuery);if ($row = mysql_fetch_array($result)) {	$sectionName = $row["sectionname"];
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
	$articleTypeNumber = $row["typenumber"];
	$articleType = $row["type"];
	$articleSubhead = $row["subhead"];	$articleTitle = $row["title"];	$articleText = $row["text"];
	$articleSeries = $row["series"];
	$seriesID = $row["series_id"];
	$orderFlag = $row["order_flag"];}	
$sqlQuery2 = "
	select
		p.id,
		p.article_filename,
		p.thumb_filename,
		p.sfeature_filename,
		p.large_filename,
		p.ffeature_filename,
		a.name as photographer,
		p.credit as alternatecredit,
		concat(a.name, p.credit) as credit,
		p.caption,
		p.article_date,
		p.article_section,
		p.article_priority,
		p.slideshow_id,
		p.article_photo_priority,
		p.slideshow_photo_priority,
		p.feature,
		p.feature_section,
		a.id as authorid
	from
		photo p,
		author a
	where
		p.photographer = a.id and 
		p.article_date = '$date' and
		p.article_section = '$section' and
		p.article_priority = '$priority'
	order by
		p.article_photo_priority

";

$result2 = mysql_query ($sqlQuery2);

# Related Documents Query
$sqlQuery3 = "	select		
		rl.label,
		rl.url
	from 
		related rl
	where
		rl.article_date = '$date' and
		rl.article_section = '$section' and 
		rl.article_priority = '$priority'
";

$result3 = mysql_query ($sqlQuery3);
$result4 = mysql_query ($sqlQuery3);
$result5 = mysql_query ($sqlQuery3);

# Related Links Query
$sqlQuery6 = "	select		
		lk.linkname,
		lk.linkurl
	from 
		links lk
	where
		lk.article_date = '$date' and
		lk.article_section = '$section' and 
		lk.article_priority = '$priority'
";

$result6 = mysql_query ($sqlQuery6);
$result7 = mysql_query ($sqlQuery6);
$result8 = mysql_query ($sqlQuery6);
$result9 = mysql_query ($sqlQuery6);

$anyPhotos = false;
$multiplePhotos = false;

if ($row2 = mysql_fetch_array($result2)) {
	$anyPhotos = true;
	$articleImage = $row2["article_filename"];

	$photographer = $row2["photographer"];
	if(strcmp($photographer, "") != 0) {
		$photographer = "$photographer, Bowdoin Orient";
		$photographerlink = true;
	}
	$credit = $row2["alternatecredit"];
	$articlePhotoCredit = "$photographer$credit";
	$articleCaption = $row2["caption"];

	$photographerID = $row2["authorid"];











	if(mysql_num_rows($result2) > 1) {
		$multiplePhotos = true;
	}
}


startcode(removeText(removeText($articleTitle,"<i>"), "</i>"),false,true,0,0,0);

?>

		  
		    <!--start-->
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
                <td valign="top">

		<!-- NOTE: Breaking News section starts here -->

	<div id="breaking_news">
	<div id="bn_title">BREAKING NEWS<br></div>
	<div id="bn_articlepage"><a href="http://orient.bowdoin.edu" >Trustees approve Darfur resolution</a></div>
	<hr>
	</div>
	

	<font class="sectiontitle"><?php echo $sectionName ?></font><p>
	<?php if(strcmp($articleType, "") != 0) { ?>
		<font class="articletype"><?php echo $articleType ?></font><br>
	<?php } ?>
                  <font class="articleheadline"><?php echo $articleTitle ?></font><br>
	<?php if(strcmp($articleSubhead, "") != 0) { ?>
	                    <font class="articlesubhead"><?php echo $articleSubhead ?><br>
	<?php } ?>
                    </font><font class="articledate"><?php echo $articleDate ?></font></p>
					
<?php 
if(strcmp($articleAuthor1, "") != 0) { 
# if no author, no author table.  
?> 
				<p><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                      <td>
	<?php if(strcmp($articleAuthorPhoto1, "")!=0) { ?>
		<img src="<?php echo $articleAuthorPhoto1 ?>" border="0" width="65" height="65" align="left">
	<?php } ?>
	<font class="articleauthorby">By </font>
	<font class="articleauthor"><a class="articleauthor" href="authorpage.php?authorid=<?php echo $articleAuthorID1 ?>"><?php echo $articleAuthor1 ?></a>
	<?php if(strcmp($articleAuthor2, "")!=0) { ?>
		 </font><font class="articleauthorby">and</font> <a class="articleauthor" href="authorpage.php?authorid=<?php echo $articleAuthorID2 ?>"><?php echo $articleAuthor2 ?></a>
	<?php } ?>
	<?php if(strcmp($articleAuthor3, "")!=0) { ?>
		 </font><font class="articleauthorby">and</font> <a class="articleauthor" href="authorpage.php?authorid=<?php echo $articleAuthorID3 ?>"><?php echo $articleAuthor3 ?></a>
	<?php } ?>	
                    <br><font class="articleauthorjob"><?php echo $articleJob ?></font></font></td>
                </tr>
              </table>
<?php 
}
?>					
					<p><!--Series code goes here--></p>

                  <p>
<?php if($anyPhotos == true) { ?>
                  <table align="right" width="1" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td>&nbsp;&nbsp;&nbsp;</td>
                      <td>
                        <div align="center"><img src="<?php echo "images/$date/$articleImage" ?>" border="1"></div>
                      </td>
                    </tr>
                    <tr> 
                      <td height="3"></td>
                      <td height="3"></td>
                    </tr>
                    <tr> 
                      <td></td>
                      <td>
                        <div align="right"><font class="photoenlarge"><a class="photoenlarge" href='javascript: rs("ss","picturewindow.php?<?php echo "date=$date&section=$section&id=$priority" ?>",600,600);'><?php if($multiplePhotos) { ?>see 
                          more pictures / <?php } ?>click to enlarge</a></font></div>
                      </td>
                    </tr>
                    <tr> 
                      <td height="3"></td>
                      <td height="3"></td>
                    </tr>
                    <tr> 
                      <td></td>
                      <td>
                        <div align="right">

	<?php
	if($photographerlink == true) {
	?>

	<a class="photocredit" href="/orient/authorpage.php?authorid=<?php echo $photographerID ?>">

	<?php
	}
	?>

	<font class="photocredit"><?php echo $articlePhotoCredit ?></font>

	<?php
	if($photographerlink == true) {
	?>

	</a>

	<?php
	}
	?>		
			</div>
                      </td>
                    </tr>
                    <tr> 
                      <td height="3"></td>
                      <td height="3"></td>
                    </tr>
                    <tr> 
                      <td></td>
                      <td><font class="photocaption"><?php echo $articleCaption ?></font></td>
                    </tr>
                    <tr> 
                      <td height="14">&nbsp;</td>
                      <td height="14">

<?php if ($row3 = mysql_fetch_array($result3)) { #start related documents and links
?>

                  <br><table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#CCCCCC">
                    <tr> 
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="4">
                          <tr> 
                            <td bgcolor="#FFFFFF">
			<table width="100%" border="0" cellpadding="1" cellspacing="0">
                      <tr> 
                        <td colspan="2" valign="top"><font class="articleoptionstitle">Related Documents</font></td>
                      </tr>
<?php } ?>
<?php
while ($row3 = mysql_fetch_array($result4)) {	
	$relatedName = $row3["label"];
	$relatedLink = $row3["url"];

?>

                      <tr> 
                        <td width="3%" valign="top"><font class="articleoptionsdot">&#8226;</font></td>
                        <td width="97%"><font class="articleoptionsitem"><a class="articleoptionsitem" href="/orient/related/<?php echo $date ?>/<?php echo $relatedLink ?>">
				<?php echo $relatedName ?></a></font></td>
                      </tr>

<?php } ?>
<?php if ($row3 = mysql_fetch_array($result5)) { ?>
                 <tr><td></td><td align="right"><font class="adobereader">(<a class="adobereader" href="http://www.adobe.com/products/acrobat/readermain.html">requires Adobe Reader</a>)</font></td></tr></table>
                             </td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
<?php } ?>
		
<?php if ($row6 = mysql_fetch_array($result6)) { ?>
			<br>
                  <table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#CCCCCC">
                    <tr> 
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="4">
                          <tr> 
                            <td bgcolor="#FFFFFF">
			<table width="100%" border="0" cellpadding="1" cellspacing="0">
                      <tr> 
                        <td colspan="2" valign="top"><font class="articleoptionstitle">Related Links</font></td>
                      </tr>
<?php } ?>
<?php
while ($row6 = mysql_fetch_array($result7)) {	
	$linkName = $row6["linkname"];
	$linkUrl = $row6["linkurl"];

?>

                      <tr> 
                        <td width="3%" valign="top"><font class="articleoptionsdot">&#8226;</font></td>
                        <td width="97%"><font class="articleoptionsitem"><a class="articleoptionsitem" href="<?php echo $linkUrl ?>">
				<?php echo $linkName ?></a></font></td>
                      </tr>

<?php } ?>
<?php if ($row6 = mysql_fetch_array($result8)) { ?>
                 </table>
                             </td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
<?php } #end related documents and links
?>

			</td>
                    </tr>
                  </table>
<?php
} #end image table


#####related links and documents if no photo
if ($anyPhotos == false) {

?>



<?php if ($row3 = mysql_fetch_array($result3)) { #start related documents and links
?>
                  <table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#CCCCCC">
                    <tr> 
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="4">
                          <tr> 
                            <td bgcolor="#FFFFFF">
			<table width="100%" border="0" cellpadding="1" cellspacing="0">
                      <tr> 
                        <td colspan="2" valign="top"><font class="articleoptionstitle">Related Documents</font></td>
                      </tr>
<?php } ?>
<?php
while ($row3 = mysql_fetch_array($result4)) {	
	$relatedName = $row3["label"];
	$relatedLink = $row3["url"];

?>

                      <tr> 
                        <td width="3%" valign="top"><font class="articleoptionsdot">&#8226;</font></td>
                        <td width="97%"><font class="articleoptionsitem"><a class="articleoptionsitem" href="/orient/related/<?php echo $date ?>/<?php echo $relatedLink ?>">
				<?php echo $relatedName ?></a></font></td>
                      </tr>

<?php } ?>
<?php if ($row3 = mysql_fetch_array($result5)) { ?>
                 <tr><td></td><td align="right"><font class="adobereader">(<a class="adobereader" href="http://www.adobe.com/products/acrobat/readermain.html">requires Adobe Reader</a>)</font></td></tr></table>
                             </td>
                          </tr>
                        </table></td>
                    </tr>
                  </table><br>
<?php } ?>
		
<?php if ($row6 = mysql_fetch_array($result6)) { ?>
			
                  <table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#CCCCCC">
                    <tr> 
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="4">
                          <tr> 
                            <td bgcolor="#FFFFFF">
			<table width="100%" border="0" cellpadding="1" cellspacing="0">
                      <tr> 
                        <td colspan="2" valign="top"><font class="articleoptionstitle">Related Links</font></td>
                      </tr>
<?php } ?>
<?php
while ($row6 = mysql_fetch_array($result7)) {	
	$linkName = $row6["linkname"];
	$linkUrl = $row6["linkurl"];

?>

                      <tr> 
                        <td width="3%" valign="top"><font class="articleoptionsdot">&#8226;</font></td>
                        <td width="97%"><font class="articleoptionsitem"><a class="articleoptionsitem" href="<?php echo $linkUrl ?>">
				<?php echo $linkName ?></a></font></td>
                      </tr>

<?php } ?>
<?php if ($row6 = mysql_fetch_array($result8)) { ?>
                 </table>
                             </td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
<?php } #end related documents and links
?>




<?php

####end related links and documents for non-photo articles

}
?>
                  <font class="text"><?php echo $articleText ?>

                  </font>

<?php if(strcmp($articleSeries, "")!=0) { ?>
<p><font class="articleseriesmore"><a class="articleseriesmore" href="seriespage.php?seriesid=<?php echo $seriesID?>">See more articles from this series: <?php echo $articleSeries ?></a></font></p>
<?php
}
?>
<p><div align="left">
                  <table width="275" border="0" cellpadding="1" cellspacing="0" bgcolor="#CCCCCC">
                    <tr> 
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="4">
                          <tr> 
                            <td bgcolor="#FFFFFF">


                      

              
                    <table width="100%" border="0" cellpadding="1" cellspacing="0">
                      <tr> 
                        <td colspan="2" valign="top"><font class="articleoptionstitle">Article Options</font></td>
                      </tr>

                      <tr> 
                        <td width="3%" valign="top"><font class="articleoptionsdot">&#8226;</font></td>
                        <td width="97%"><font class="articleoptionsitem"><a class="articleoptionsitem" href='javascript: rs("ss","emailarticle.php?date=<?php echo "$date&section=$section&id=$priority" ?>",600,600);'>Email this article</a></font></td>
                      </tr>

                      <tr> 
                        <td width="3%" valign="top"><font class="articleoptionsdot">&#8226;</font></td>
                        <td width="97%"><font class="articleoptionsitem"><a class="articleoptionsitem" href="printer.php?date=<?php echo "$date&section=$section&id=$priority" ?>">Printer-friendly 
                                version</a></font></td>
                      </tr>

                      <tr> 
                        <td valign="top"><font class="articleoptionsdot">&#8226;</font></td>
                        <td><font class="articleoptionsitem"><a class="articleoptionsitem" href="/orient/letters.php">Send 
                                a letter to the editor</a></font></td>
                      </tr>

                    </table>
                             </td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></div>

                  <p></P><div align="left"><table width="100%" border="0" cellpadding="2" cellspacing="0">
                    <tr> 
                      <td colspan="2" valign="top">
<font class="articlealsoinsectiontitle">
      <a class="articlealsoinsectiontitle" href="section.php?section=<?php echo $section ?>">
      In <i><?php echo $sectionName ?></i> this week...</a>
</font>
	     </td>
                    </tr>

<?php
if($date != $currentDate) {
# if we're looking at an old article, don't exclude 
# the current article with the same priority
$includeThisArticleOrNot = "";
}
else {
# if we're looking at a current article,
# don't show it
$includeThisArticleOrNot =  " and priority != '$priority' ";
}

$sqlQuery = "
	select
		title,
		priority
	from
		article
	where
		date = '$currentDate' and
		section_id = '$section'
		$includeThisArticleOrNot
	order by
		priority
";

$res = mysql_query ($sqlQuery);

while ($row = mysql_fetch_array($res)) {
	$nextArticleTitle = $row["title"];
	$nextArticlePriority = $row["priority"];


?>	
                    <tr> 
                      <td width="3%" valign="top"><font class="articlealsoinsectiondot">&#8226;</font></td>
                      <td width="97%"><font class="articlealsoinsectionheadline"><a class="articlealsoinsectionheadline" href="article.php?date=<?php echo $currentDate ?>&section=<?php echo $section ?>&id=<?php echo $nextArticlePriority ?>"><?php echo $nextArticleTitle ?></a></font></td>
                    </tr>
<?php
}
?>
                  </table></div>

                  </td>
    <td width="14"></td>
    <td width="145" align="center" valign="top">
      <?php  include("rightsidebar.php");  ?>
    </td>
  </tr>
</table>

			
            <!--end-->
<?php  include("stop.php");  ?>