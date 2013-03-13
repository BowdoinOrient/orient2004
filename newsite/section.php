<?php
	include("template/top.php");
	if (!$sectionID) {
		$sectionID = $_GET['section'];
	}
	if (!$sectionID) {
		$section = 1;
	}
	$query = 
	"SELECT name
	FROM section
	WHERE id = $sectionID
	";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	$sectionname = $row['name'];
	$title = "The Bowdoin Orient - $sectionname";
	startPage();
	?>
		<!-- Side Links (4 blocks) -->
		<div class='span-3 menudiv'>
			<?php include("template/mainlinks.php"); ?>
		
			<div class='spacer'>
			</div>
		
			<?php include("template/events.php"); ?>
		
			<div class='spacer'>
			</div>
		
			<?php include("template/otherlinks.php"); ?>
		
			<div class='spacer'>
			</div>
		</div>
		
		<!-- The rest of the page is to the right of the link bar -->
		<div class='span-16 sections'>
			
		<h2 class='sectiontitle'><?php echo strtoupper($sectionname); ?></h2>

		<?php
			$articles = getSectionArticles($sectionID, $date);
			while ($row = mysql_fetch_array($articles)) {
				echoSectionArticle($row);
			}
		?>

		</div>
		
		<div class='span-5 last'>
			<?php include("template/currentorient.php"); ?>
		</div>
		
		
		<?php include("template/footer.php"); ?>
<?php
	include("template/bottom.php");
?>