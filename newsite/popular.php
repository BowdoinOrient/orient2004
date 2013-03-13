<?php
include("template/top.php");
$title = "Popular articles";
startPage();
?>

<!-- Side Links (3 blocks) -->
<div class='span-3 menudiv'>
	<?php include("template/mainlinks.php"); ?>
	<div class='spacer'>
	</div>

	<?php include("template/events.php"); ?>
	<div class='spacer'>
	</div>

	<?php include("template/otherlinks.php"); ?>
</div>

<!-- The rest of the page is to the right of the link bar -->
<div class='span-21 last'>
	<div class='span-16 information'>
		<h2 class='articlesection'>Popular!</h2>

		<h3 class='articletitle'>Popular articles</h3>
		
		<?php

include("start.php");
$dateQuery = "SELECT issue_date FROM issue ORDER BY issue_date DESC LIMIT 0, 1";
$latestDate = mysql_result(mysql_query($dateQuery), 0);

$allTimeArticles = mysql_query("SELECT date, section_id, priority, author1, author2, author3, title, subhead, pullquote, views FROM article ORDER BY views DESC LIMIT 0, 50");
$latestArticles = mysql_query("SELECT section_id, priority, author1, author2, author3, title, subhead, pullquote, views FROM article WHERE date='$latestDate' ORDER BY views DESC");
?>
	
			<strong><a href='#' onClick='if (document.getElementById("latest").style.display=="") {document.getElementById("latest").style.display="none";} else {document.getElementById("latest").style.display="";} return false;'>Top 20 Of <?php echo $latestDate;?></a></strong>
		<br />
		<span id="latest">
		<?php
		for ($i = 0; $i < mysql_num_rows($latestArticles); $i++) {
			echo "<h4><a href='article.php?date=$latestDate&section=" . mysql_result($latestArticles, $i, "section_id") . "&id=" . mysql_result($latestArticles, $i, "priority") . "'>" . mysql_result($latestArticles, $i, "title") . "</a> (" . intval(mysql_result($latestArticles, $i, "views")) . ")</h4>\n";
			echo "<div><p>" . mysql_result($latestArticles, $i, "pullquote") . "</p></div>";
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
			echo "<div style='font-size:0.7em;'><p>" . mysql_result($allTimeArticles, $i, "pullquote") . "</p></div>";
		}
		
		?>

	</div>
	
	<div class='span-5 last'>
		<?php include("template/currentorient.php"); ?>
	</div>
</div>
<?php include("template/footer.php"); ?>
</div>

<?php include("template/bottom.php"); ?>