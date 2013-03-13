<?php
include("template/top.php");
$title = "Recent Comments";
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
	<div class='span-16 information'>
		
		<h2 class='articlesection'>Recent Comments</h2>
		
		<script type="text/javascript" src="http://disqus.com/forums/bowdoinorient/combination_widget.js?num_items=20&hide_mods=0&color=grey&default_tab=recent&excerpt_length=200"></script>
		
	</div>
	
	<div class='span-5 last'>
		<?php include("template/currentorient.php"); ?>
	</div>
</div>
<?php include("template/footer.php"); ?>
</div>

<?php include("template/bottom.php"); ?>