<?php
include("template/top.php");
$title = "Browser upgrade";
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
		<h2 class='articlesection'>Browser Upgrade</h2>

		<h3 class='articletitle'>Web Browsers</h3>
		<p>If this website doesn't appear to be displaying correctly, you may need to upgrade to a modern browser.
		Our recommendations include <a href='http://www.mozilla.com/'>Firefox</a>, <a href='http://www.apple.com/safari/download/'>Safari</a>, <a href='http://www.microsoft.com/windows/downloads/ie/getitnow.mspx'>Internet Explorer 7</a> or above, or <a href='http://www.opera.com/'>Opera</a>.  In addition to displaying the page incorrectly, older browsers such as Internet Explorer 6 pose significant security threats to your computer, so you should be upgrading regularly.
		</p>
	</div>
	
	<div class='span-5 last'>
		<?php include("template/currentorient.php"); ?>
	</div>
</div>
<?php include("template/footer.php"); ?>
</div>

<?php include("template/bottom.php"); ?>