<?php
include("template/top.php");
$title = "A Survey by The Bowdoin Orient";
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
		<iframe src="https://docs.google.com/spreadsheet/embeddedform?formkey=dGpmQWFnSzlkdmx5SERucXJyQVppbnc6MA" width="760" height="2100" frameborder="0" marginheight="0" marginwidth="0">Loading...</iframe>
	</div>
</div>
<?php include("template/footer.php"); ?>
</div>

<?php include("template/bottom.php"); ?>