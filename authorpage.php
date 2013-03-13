<?php
include("template/top.php");

if($_GET["name"] == "evangershkovich") {
	$authorID = 709;
}

if (!$authorID) {
	header("Location: staff.php");
	exit;
}

$infoQuery = 
	"SELECT
		au.name AS authorname,
		j.name AS job
	FROM
		author au,
		job j
	WHERE
		au.job = j.id AND
		au.id = '$authorID'
	";

$infoResults = mysql_query($infoQuery);
if ($row = mysql_fetch_array($infoResults)) {
	$authorName = $row['authorname'];
}

$articleQuery = 
	"SELECT
		ar.title,
		ar.date,
		date_format(ar.date, '%M %e, %Y') AS fancydate,
		ar.section_id,
		ar.priority,
		j.name AS jobname,
		a1.name AS author1,
		a2.name AS author2,
		a3.name AS author3
	FROM 
		article ar,
		author a1,
		author a2,
		author a3,
		job j,
		issue i
	WHERE
		j.id = ar.author_job AND
		a1.id = ar.author1 AND
		a2.id = ar.author2 AND
		a3.id = ar.author3 AND
		i.issue_date = ar.date AND
		i.ready = 'y' AND
		(
		ar.author1 = '$authorID' OR
		ar.author2 = '$authorID' OR
		ar.author3 = '$authorID'
		)
	ORDER BY
		ar.date DESC,
		ar.title
	";
$articleResults = mysql_query($articleQuery);

$photoQuery = 
	"SELECT
		DISTINCT p.large_filename,
		p.thumb_filename,
		p.caption,
		a.name AS photographer,
		p.credit,
		p.article_date
	FROM
		author a,
		photo p
	WHERE 
		(
		(p.photographer = a.id) AND
		(p.photographer = '$authorID')
		)
	ORDER BY 
		p.article_date DESC
	";
$photoResults = mysql_query($photoQuery);

if (mysql_num_rows($articleResults) > 0) {
	$anyarticles = true;
}

if (mysql_num_rows($photoResults) > 0) {
	$anyphotos = true;
}


$title = "The Bowdoin Orient - $authorName";
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
	<div class='span-16 authorpage'>
		<h2 class='articlesection'><?php echo $authorName; ?></h2>
		<?php 
		if ($anyphotos) { ?>
			<h3 class='authorpagesection'>Photos</h3>
				<?php
				$first = true;
				while ($row = mysql_fetch_array($photoResults)) {
					if ($row['article-date'] == $date and $row['thumb_filename'] == $thumbfilename) {
						continue;
					}
					$date = $row['article_date'];
					$largefilename = $row['large_filename'];
					if ($first) {
						$first = false;
						$credit = $row['photographer'];
						if ($credit) {
							$credit .= ", Bowdoin Orient";
						} else {
							$credit = $row['credit'];
						}						
						echo "<h3 class='articletitle'><a href='images/$date/$largefilename' rel='lightbox[gallery]' class='lightbox' title='" . getLightboxTitle($row['caption'], $credit) . "'><strong>Slideshow:</strong> All (" . mysql_num_rows($photoResults) . ") photos taken by $authorName</a></h3>";
					} else {
						echoAuthorPhoto($row, true);
					}
				}
				
				?>
<?php } 	if ($anyarticles) { ?>
					<h3 class='authorpagesection'>Articles</h3>
						<?php
						while ($row = mysql_fetch_array($articleResults)) {
							echoAuthorArticle($row);
						}
						spacer();
						?>
						<p>For articles published before April 2, 2004, use the <a href='archives.php'>archives</a>.</p>
				<?php } ?>
				
	</div>
	
	<div class='span-5 last'>
		<?php include("template/currentorient.php"); ?>
	</div>
</div>
<?php include("template/footer.php"); ?>
</div>

<?php include("template/bottom.php"); ?>