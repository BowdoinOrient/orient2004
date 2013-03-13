<?php

include("start.php");
$dateQuery = "SELECT issue_date FROM issue ORDER BY issue_date DESC LIMIT 0, 1";
$latestDate = mysql_result(mysql_query($dateQuery), 0);

$allTimeArticles = mysql_query("SELECT date, section_id, priority, author1, author2, author3, title, subhead, pullquote, views FROM article ORDER BY views DESC LIMIT 0, 50");
$latestArticles = mysql_query("SELECT section_id, priority, author1, author2, author3, title, subhead, pullquote, views FROM article WHERE date='$latestDate' ORDER BY views DESC");
$allTimeBowdoin = mysql_query("SELECT date, section_id, priority, author1, author2, author3, title, subhead, pullquote, bowdoin_views FROM article ORDER BY views DESC LIMIT 0, 50");
$latestBowdoin = mysql_query("SELECT section_id, priority, author1, author2, author3, title, subhead, pullquote, bowdoin_views FROM article WHERE date='$latestDate' ORDER BY views DESC");

startcode("The Bowdoin Orient - Most Viewed Pages", false, false, 0,0,0);

?>

<!--start-->

		<font class="pagetitle">Popular Articles</font><br><br>
		
		<br />
		<strong><a href='#' onClick='if (document.getElementById("latest").style.display=="") {document.getElementById("latest").style.display="none";} else {document.getElementById("latest").style.display="";} return false;'>Top 20 Of <?php echo $latestDate;?></a></strong>
		<br />
		<span id="latest">
		<?php
		for ($i = 0; $i < mysql_num_rows($latestArticles); $i++) {
			echo "<h3 style='font-size: 0.9em;'><a href='article.php?date=$latestDate&section=" . mysql_result($latestArticles, $i, "section_id") . "&id=" . mysql_result($latestArticles, $i, "priority") . "'>" . mysql_result($latestArticles, $i, "title") . "</a> (" . intval(mysql_result($latestArticles, $i, "views")) . ")</h3>\n";
			echo "<p style='font-size:0.7em;'>" . mysql_result($latestArticles, $i, "pullquote") . "</p>";
		}
		?>
		</span>
		<br />
		
		<font class="pagetitle">Popular Bowdoin Articles</font><br><br>
		
		<br />
		<strong><a href='#' onClick='if (document.getElementById("latestBowdoin").style.display=="") {document.getElementById("latestBowdoin").style.display="none";} else {document.getElementById("latestBowdoin").style.display="";} return false;'>Top 20 Of <?php echo $latestDate;?></a></strong>
		<br />
		<span id="latestBowdoin" style="display:none;">
		<?php
		for ($i = 0; $i < mysql_num_rows($latestArticles); $i++) {
			echo "<h3 style='font-size: 0.9em;'><a href='article.php?date=$latestDate&section=" . mysql_result($latestArticles, $i, "section_id") . "&id=" . mysql_result($latestArticles, $i, "priority") . "'>" . mysql_result($latestArticles, $i, "title") . "</a> (" . intval(mysql_result($latestArticles, $i, "bowdoin_views")) . ")</h3>\n";
			echo "<p style='font-size:0.7em;'>" . mysql_result($latestArticles, $i, "pullquote") . "</p>";
		}
		?>
		</span>
		<br />
		
<!--		<strong><a href='#' onClick='if (document.getElementById("allTime").style.display=="") {document.getElementById("allTime").style.display="none";} else {document.getElementById("allTime").style.display="";} return false;'>Top 50 Of "All Time"</a></strong> -->

		<br />
		<span id="allTime" style="display:none;">
		<?php
		for ($i = 0; $i < mysql_num_rows($allTimeArticles); $i++) {
			echo "<h3 style='font-size:0.9em;'><a href='article.php?date=" . mysql_result($allTimeArticles, $i, "date") . "&section=" . mysql_result($allTimeArticles, $i, "section_id") . "&id=" . mysql_result($allTimeArticles, $i, "priority") . "'>" . mysql_result($allTimeArticles, $i, "title") . "</a> (" . intval(mysql_result($allTimeArticles, $i, "views")) . ")</h3>\n";
			echo "<p style='font-size:0.7em;'>" . mysql_result($allTimeArticles, $i, "pullquote") . "</p>";
		}
		
		?>
		  
<!--end-->

<?php 

include("stop.php");
?>