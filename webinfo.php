<?php
include("template/top.php");
$title = "About the Orient";
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
		<h2 class='articlesection'>Website Information</h2>

		<h3 class='articletitle'>General Information</h3>
		<p>The website of <em>The Bowdoin Orient</em> was redesigned in 2004, and again in 2009.</p>
		<p>We encourage comments on the website, suggestions for future improvements, and reports on any errors you encounter.</p>
		<p>If the website does not look quite right, upgrading to a <a href='browserupgrade.php'>newer or more standards-compliant web browser</a> may fix the problem.</p>
		<p>To contact the webmaster, please email <a href='mailto:orientweb@bowdoin.edu'>orientweb@bowdoin.edu.</a></p>
		<p>The website was designed and maintained by a number of people over the years, including Mark Hendrickson, James Baumberger, Vic Kotecha, and Seth Glickman.</p>
	</div>
	
	<div class='span-5 last'>
		<?php include("template/currentorient.php"); ?>
	</div>
</div>
<?php include("template/footer.php"); ?>
</div>

<?php include("template/bottom.php"); ?>