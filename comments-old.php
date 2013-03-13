<?php
include("template/top.php");
$title = "Recent Comments";
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
		<h2 class='articlesection'>Recent Comments</h2>

		
		<br>
		
		<?php

include("start.php");
$commentQuery = "SELECT * FROM comment, article WHERE deleted='n' AND article.date=comment.article_date AND article.priority=comment.article_priority AND article.section_id=comment.article_section ORDER BY id DESC LIMIT 0, 20";
$comments = mysql_query($commentQuery);
?>
	
		<span id="latest" style='font-size: 0.9em;'>
		<?php
		while ($r = mysql_fetch_array($comments)) {
			echo "<div><b>" . $r['realname'] . "</b> on <a href='article.php?date=" . $r['article_date'] . "&section=" . $r['article_section'] . "&id=" . $r['article_priority'] . 
				"'>" . $r['TITLE'] . "</a> <span class='commentdate'>" . date(" (M j, Y, g:i a)", strtotime($r['comment_date'])) . "</span><br /><p>" . implode("</p><p>", explode("\n", substr($r['comment'], 0, 750)));
			if(strlen($r['comment']) > 750) echo "...";
			echo "</div><hr />";
		}
		?>
		</span>
		<br />
		

	</div>
	
	<div class='span-5 last'>
		<?php include("template/currentorient.php"); ?>
	</div>
</div>
<?php include("template/footer.php"); ?>
</div>

<?php include("template/bottom.php"); ?>