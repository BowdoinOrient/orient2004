<?php
include("template/top.php");
$title = "The Bowdoin Orient - Photos";
startPage();
$photoQuery = 
	"SELECT 
		date_format(article.date, '%M %e, %Y') AS formatteddate, 
		article_filename, 
		large_filename, 
		thumb_filename, 
		article_filename,
		caption, 
		name AS photographer, 
		credit,
		article.title, 
		article.section_id, 
		article.priority AS articlepriority 
	FROM 
		photo, 
		author, 
		article 
	WHERE 
		photo.photographer = author.id 
		AND article_date = '$date' 
		AND article.date = article_date 
		AND article.priority = photo.article_priority 
		AND article.section_id = photo.article_section 
	ORDER BY 
		article.section_id DESC, 
		article.priority DESC
	";
$photos = mysql_query($photoQuery);
$photos2 = mysql_query($photoQuery);
$row = mysql_fetch_array($photos2);
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
	<div class='span-16 information'>
		<h2 class='articlesection'>Photos from <?php echo $row['formatteddate']; ?></h2>
		<div class='photos'>
		<?php
		$title = "";
		while($row = mysql_fetch_array($photos)) {
			
			// Removes duplicates... not sure why they're there in the first place, but whatever.
			if ($oldfilename == $row['large_filename']) {
				continue;
			} else {
				$oldfilename = $row['large_filename'];
			}
			if ($title != $row['title']) {
				if ($title) {
					spacer();
				}
				$title = $row['title'];
				echo "<h3 class='articletitle'><a href='" . articleLink($date, $row['section_id'], $row['articlepriority']) . "'>$title</a></h3>\n";
			}
			$credit = $row['photographer'];
			if ($credit) {
				$credit .= ", Bowdoin Orient";
			} else {
				$credit = $row['credit'];
			}
			echo "<a class='lightbox' rel='lightbox' title='" . getLightboxTitle($row['caption'], $credit) . "' href='images/$date/" . $row['large_filename'] . "'><img src='images/$date/" . $row['article_filename'] . "'></a> ";
		}
		
		
		?>
		</div>
	</div>
	
	<div class='span-5 last'>
		<?php include("template/currentorient.php"); ?>
	</div>
</div>
<?php include("template/footer.php"); ?>
</div>

<?php include("template/bottom.php"); ?>