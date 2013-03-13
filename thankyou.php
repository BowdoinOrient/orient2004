<?php
include("template/top.php");
$title = "The Bowdoin Orient - Subscribe";
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
		<h2 class='articlesection'>Subscribe</h2>
		
		<div class='advertise information'>
			<h3 class='articletitle'>Thank you!</h3>
			<p>Thank you for your subscription! Purchases like yours help keep the Bowdoin Orient in print.</p>
			<p>Feel free to read the current issue <a href='index.php'>here</a> or browse through our <a href='archives.php'>archives</a>.</p>
			
		</div>
	</div>
	
	<div class='span-5 last'>
		<?php include("template/currentorient.php"); ?>
	</div>
</div>
<?php include("template/footer.php"); ?>
</div>

<?php include("template/bottom.php"); ?>