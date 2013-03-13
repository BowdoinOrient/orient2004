<?php
include("template/top.php");

if (!$seriesID) {
	header("Location: index.php");
	exit;
}

$nameQuery = 
	"SELECT
		name
	FROM
		series
	WHERE 
		id='$seriesID'
	";
$nameResults = mysql_query($nameQuery);
if ($row = mysql_fetch_array($nameResults)) {
	$seriesName = $row["name"];
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
		a3.name AS author3,
		ar.series
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
		ar.series = '$seriesID' AND
		i.issue_date = ar.date AND
		i.ready = 'y'
	ORDER BY
		ar.date DESC,
		ar.title
	";

$articleResults = mysql_query($articleQuery);

$title = "The Bowdoin Orient - $seriesName";
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
	<div class='span-16 authorpage'>
		<h2 class='articlesection'><?php echo $seriesName; ?></h2>
			<h3 class='authorpagesection'>Articles</h3>
				<?php
				while ($row = mysql_fetch_array($articleResults)) {
					echoAuthorArticle($row);
				}
				spacer();
				?>
				<p>For articles published before April 2, 2004, use the <a href='archives.php'>archives</a>.</p>
			
	</div>
	
	<div class='span-5 last'>
		<?php include("template/currentorient.php"); ?>
	</div>
</div>
<?php include("template/footer.php"); ?>
</div>

<?php include("template/bottom.php"); ?>