<?php
include("template/top.php");

// First update the 'read' count of this article.
// Check to make sure it's "ready", and that this actually qualifies as a view.

$commentQuery = 
	"SELECT
		username,
		email,
		comment,
		id
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
	
	if ($numComments == 0) {
		header("Location: " . articleLink($date, $section, $priority));
		exit;
	}

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

$title = $articleTitle;
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
			<div class='span-16'>
					<div class='comments-div'>
							<div id='viewcomments'>
								<h4>Comments</h4>
								<?php
									$counter = 0;
									while ($row = mysql_fetch_array($comments)) {
										$counter = $counter % 2;
										echo "<div class='comment comment$counter' commentid='" . $row['id'] . "'>";
											echo "<a href='#' class='commentaction' onclick='removeComment(this); return false;'>Remove</a> ";
											echo "<p class='bottom'>";
											if ($row['email']) {
												echo "<a href='mailto:" . $row['email'] . "'>";
											}
											echo $row['username'] . ":";
											if ($row['email']) {
												echo "</a>";
											}
											echo "</p>";
											echo "<p class='bottom'>" . stripslashes($row['comment']) . "</p>";
										echo "</div>";
										$counter++;
									}
								?>
							</div>
						<?php 
						spacer(); ?>
						<p id='comment-error' class='error'></p>
						<p id='comment-success' class='success'></p>
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