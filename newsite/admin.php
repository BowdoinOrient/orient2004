<?php
include("template/top.php");
$title = "The Bowdoin Orient - Admin";
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
		<h2 class='articlesection'>Administrative Tasks</h2>
				<h3><a href='editphoto.php'>Edit a Photo</a></h3>
				<h3><a href='editarticle.php'>Edit an Article</a></h3>
				<h3><a href='settings.php'>Edit Settings</a></h3>
				<h3><a href='newissue.php'>Add New Issue</a></h3>
	</div>
	
	<div class='span-5 last'>
		<?php include("template/currentorient.php"); ?>
	</div>
</div>
<?php include("template/footer.php"); ?>
</div>

<?php include("template/bottom.php"); ?>