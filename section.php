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
		<?php
		$featurePhotoResults = getSectionFeaturePhoto($sectionID, $date);
		if (mysql_num_rows($featurePhotoResults) == 0) { ?>
		<div class='span-16 sections'>
		<?php } else { ?>
		<div class='span-12 sections'>
		<?php } ?>
			
		<h2 class='sectiontitle'><?php echo strtoupper($sectionname); ?></h2>

		<?php
			$articles = getSectionArticles($sectionID, $date);
			while ($row = mysql_fetch_array($articles)) {
				echoSectionArticle($row);
			}
		?>

		</div>
		<?php if (mysql_num_rows($featurePhotoResults) > 0) { 
		  $featurePhoto = mysql_fetch_array($featurePhotoResults);
          $photoCredit = $featurePhoto['photographer'];
		if ($photoCredit) {
			$photoCredit .= ", The Bowdoin Orient";
			$photographerlink = true;
		} else {
			$photoCredit = $featurePhoto['credit'];
		}
		$photoCaption = $featurePhoto["caption"];
		$photoCaption = str_replace("<b>", "<span class=\"caps\">", $photoCaption);
		$photoCaption = str_replace("</b>", "</span>", $photoCaption);
		$photoCaption = str_replace("'", "&#39;", $photoCaption);

        ?>
		<div class='span-9 section-feature-photo last'>
		      <a href='images/<?php echo "$date/" . $featurePhoto['large_filename']; ?>' class='lightbox' ><img src='<?php echo "images/$date/" . $featurePhoto['sfeature_filename']; ?>'></a>
    		  <div class='photocredit last'>
    		  <a href='authorpage.php?authorid=<?php echo $featurePhoto['id']; ?>'><?php echo $photoCredit; ?></a>
    		  </div>
    		  <div class='photocaption last'>
    		      <?php echo $photoCaption; ?>
    		  </div>
        </div>
		<?php } else { ?>
		<div class='span-5 last'>
			<?php include("template/currentorient.php"); ?>
		</div>
		<?php } ?>
		
		
		<?php include("template/footer.php"); ?>
<?php
	include("template/bottom.php");
?>