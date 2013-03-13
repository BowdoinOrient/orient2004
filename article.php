<?php
include("template/top.php");

// First update the 'read' count of this article.
// Check to make sure it's "ready", and that this actually qualifies as a view.

$commentQuery = 
	"SELECT
		username,
		email,
		comment,
		id,
		comment_date,
		realname
	FROM
		comment
	WHERE
		deleted='n' AND 
		article_date = '$date' AND 
		article_section = '$section' AND 
		article_priority = '$priority'
	ORDER BY
		id ASC
	";
	$comments = mysql_query($commentQuery);	
	$numComments = mysql_num_rows($comments);

$readyQuery = 
	"SELECT
		issue.ready
	FROM
		article,
		issue
	WHERE
		article.date = '$date' AND
		article.section_id = '$section' AND
		article.priority = '$priority' AND
		issue.issue_date = article.date
	";
if (mysql_result(mysql_query($readyQuery), 0, 'ready') == 'y') {
	$countPage = 
	"UPDATE
		article
	SET
		article.views = article.views + 1
	WHERE
		article.date = '$date'
		AND article.section_id = '$section'
		AND article.priority = '$priority'
	";
	mysql_query($countPage);
	// Now add to Bowdoin views
	if (strpos(gethostbyaddr($_SERVER['REMOTE_ADDR']), "bowdoin") !== false) {
		$countPage = 
		"UPDATE
			article
		SET
			bowdoin_views = bowdoin_views + 1
		WHERE
			date = '$date'
			AND section_id = '$section'
			AND priority = '$priority'
		";
		mysql_query($countPage);
	}
}

// This grabs the information about the article.  More queries to come.
$articleQuery = 
	"SELECT
		s.name AS sectionname,
		ar.priority,
		ar.author1,		
		a1.name AS author1name,
		a1.photo AS author1photo,
		ar.author2,
		a2.name AS author2name,
		a2.photo AS author2photo,
		ar.author3,
		a3.name AS author3name,
		a3.photo AS author3photo,		
		j.name AS jobname,		
		ar.title AS title,
		ar.subhead,		
		ar.text,
		at.id AS typenumber,
		at.name AS type,
		series.name AS series,
		series.id AS series_id,
		s.order_flag
	FROM 
		section s,
		article ar,
		author a1,
		author a2,
		author a3,
		job j,
		articletype at,
		series
	WHERE
		ar.author_job = j.id AND
		ar.section_id = s.id AND
		ar.author1 = a1.id AND
		ar.author2 = a2.id AND 
		ar.author3 = a3.id AND
		ar.type = at.id AND
		ar.series = series.id AND
		ar.date = '$date' AND
		ar.section_id = '$section' AND 
		ar.priority = '$priority'
	";

$result = mysql_query ($articleQuery);
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
	$articleTypeNumber = $row["typenumber"];
	$articleType = $row["type"];
	$articleSubhead = $row["subhead"];	
	$articleTitle = $row["title"];	
	$articleText = $row["text"];
	$articleSeries = $row["series"];
	$seriesID = $row["series_id"];
	$orderFlag = $row["order_flag"];
} else {
	header("Location: index.php");
	exit;
}

$title = $articleTitle." - The Bowdoin Orient";
startPage();
?>

		<!-- Side Links (3 blocks) -->
		<div class='span-3 menudiv'>
			<?php include("template/mainlinks.php"); ?>
			<div class='spacer'>
			</div>

			<?php include("template/otherlinks.php"); ?>
		</div>

		<!-- The rest of the page is to the right of the link bar -->
		<div class='span-21 last'>
			<div class='span-16'>
				<h2 class='articlesection'><?php echo $sectionName; ?></h2>
				<h3 class='articletype bottom'><?php echo $articleType; ?></h3>
				<h2 class='articletitle top bottom'><?php echo $articleTitle; ?></h2>
				<?php if ($articleSubhead) { 
					echo "<h2 class='articlesubhead top bottom'>" . $articleSubhead . "</h2>";
				}
				?>
				
				<?php 
					// If it's part of a series, link to the entire series.
					if ($articleSeries) { ?>
						<p><a href='seriespage.php?seriesid=<?php echo $seriesID; ?>'><?php echo strtoupper($articleSeries); ?></a></p>
					<?php } ?>
				
				<div style="float:right">
				<div style="margin-bottom:5px">
				<a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="bowdoinorient">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
				</div>
				<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Forient.bowdoin.edu%2Forient%2Farticle.php%3Fdate%3D<?=$date?>%26section%3D<?=$section?>%26id%3D<?=$priority?>&amp;layout=button_count&amp;show-faces=true&amp;width=120&amp;action=recommend&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:120px; height:25px"></iframe>
				</div>
				
				<h3 class='articledate top'><?php echo $articleDate; ?></h3>
				
				<div class='articleauthor'><?php echo authorsLinks($articleAuthor1, $articleAuthor2, $articleAuthor3, $articleAuthorID1, $articleAuthorID2, $articleAuthorID3, $articleJob); ?></div>
				
				<div class='articletext'>
					<?php
					// Displays photos / documents / embeddables.
					echoMedia($date, $section, $priority);
					echo $articleText; ?>
					<?php
					$morestories = getSectionArticles($section, $currentDate);
					?>
					<div class='comments-div'>
						<!--<hr />-->
						<a name='comments'></a>
						<!--<h3>Comments</h3>-->
						<!--
						<div style="margin-bottom:5px">
						<a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="bowdoinorient">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
						</div>
						-->
						<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Forient.bowdoin.edu%2Forient%2Farticle.php%3Fdate%3D<?=$date?>%26section%3D<?=$section?>%26id%3D<?=$priority?>&amp;layout=standard&amp;show-faces=true&amp;width=450&amp;action=recommend&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:450px; height:75px"></iframe>
						<hr/>
						
						
						<div id="disqus_thread"></div>
						<script type="text/javascript">
						  
						  var disqus_identifier = '<?php echo $date.'&'.$section.'&'.$priority ?>'; 
						  var disqus_title = '<?php echo $articleTitle ?>';
						  
						  (function() {
						   var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
						   dsq.src = 'http://bowdoinorient.disqus.com/embed.js';
						   (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
						  })();
						</script>
						<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript=bowdoinorient">comments powered by Disqus.</a></noscript>
						<a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>

						
						
						<?php if ($numComments == 0) { ?>
							<!--<div id='nocomments'>There are no comments for this article yet.</div>-->
						<?php } else { ?>
							<div id='comment-disclaimer'>
								Please note that comments do not in any way reflect the opinion of <em>The Orient</em>, nor of Bowdoin College.
							<br />
							<a href='#' id='view-comments' onclick='showComments(); return false;'>Click here to view all comments (<?php echo $numComments; ?>)</a>
							</div>
							<?php } ?>
							<div id='comments'>
								
								<?php
									$counter = 0;
									while ($row = mysql_fetch_array($comments)) {
										$counter = $counter % 2;
										echo "<div class='comment comment$counter' commentid='" . $row['id'] . "'>";
											echo "<a href='#' class='commentaction' onclick='reportComment(this); return false;'>Report</a> ";
											echo "<p class='bottom edit'>";
											if ($row['email']) {
												echo "<a href='mailto:" . $row['email'] . "'>";
											}
											echo $row['realname'];
											if ($row['email']) {
												echo "</a>";
											}
											// the time on the server is a little off
											$offset = 60 * 23;
											// Not anymore.
											$offset = 0;											
											$commentDate = strtotime($row['comment_date']) + $offset;
											echo "<span class='commentdate'>" . date(" (M j, Y, g:i a)", $commentDate) . "</span>";
											echo "</p>";
											echo "<div class='bottom edit_area'><p>" . stripslashes(implode("</p><p>", explode("\n", $row['comment']))) . "</p></div>";
										echo "</div>";
										$counter++;
									}
								?>
							</div>
						<?php spacer(); ?>
						<p id='comment-error' class='error'></p>
						<p id='comment-success' class='success'></p>
						<?php //commentForm(); ?>
					</div>
					<?php
					// Display article options
					echoArticleOptions($date, $section, $priority, $articleTitle);
					?>
					<hr />
					<ul class='morestories'>
						<li>IN <em><?php echo strtoupper($sectionName); ?></em> THIS WEEK...</li>
						<?php echo more_news($morestories, $priority, ($date != $currentDate)); ?>
					</ul>
				</div>
			</div>
			
			<div class='span-5 last'>
				<?php include("template/currentorient.php"); ?>	
			</div>
			
		</div>
		<?php include("template/footer.php"); ?>
<?php
include("template/bottom.php");
?>