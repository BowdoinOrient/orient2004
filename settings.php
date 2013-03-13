<?php
include("template/top.php");
$title = "Main Orient Settings";
$frontPage = getSetting("numArticles", '', true);
$mostViewed = getSetting("mostViewed", '', true);
$adminPassword = getSetting('password', 'bobby!');
$break = getSetting('break', '');
$breakMessage = getSetting('breakMessage', '');
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
		<h2 class='articlesection'>Main Orient Settings</h2>
		
		<?php
		if ($_POST['pwd'] != $adminPassword) {
			// If they haven't put in the password
			if ($_POST['pwd']) {
				$errorMessage = "The wrong password was put in.  Please try again.";
			}
			
			if ($errorMessage) {
				echo "<p class='error'>$errorMessage</p>";
			}
			?>
			
			
			<form action='settings.php' method='POST'>
				<label>Number of articles on front page: <input type='text' name='numArticles' id='numArticles' value='<?php echo $frontPage; ?>' /></label>
				<br />
				<label>Number of most-viewed articles on front page: <input type='text' name='mostViewed' id='mostViewed' value='<?php echo $mostViewed; ?>' /></label>
				<br />
				<label>Page Header Title (blank if none): <input type='text' name='break' id='break' value='<?php echo $break; ?>' /></label>
				<br />
				<strong>Page Header Text (blank if none):</strong>
				<br /><textarea name='breakMessage' id='breakMessage'><?php echo $breakMessage; ?></textarea>
				<br />
				<label>New Password (blank if unchanged): <input type='password' name='newpwd1' id='newpwd1' /></label>
				<br />
				<label>Password Confirmation (blank if unchanged): <input type='password' name='newpwd2' id='newpwd2' /></label>
				<br />
				<label>Old Password: <input type='password' name='pwd' id='pwd' /></label>
				<br />
				<input name='submit' type='submit' />
			</form>
			
<?php } else { 
		// They've put in the proper password, now changes get made.
		if ($_POST['numArticles']) {
			setSetting('numArticles', $_POST['numArticles'], true);
		}
		if ($_POST['mostViewed']) {
			setSetting('mostViewed', $_POST['mostViewed'], true);
		}
		setSetting('break', $_POST['break']);
		setSetting('breakMessage', $_POST['breakMessage']);
		if ($_POST['newpwd1']) {
			if ($_POST['newpwd1'] == $_POST['newpwd2']) {
				setSetting('password', $_POST['newpwd1']);
			} else {
				$errorMessage = "The two passwords did not match.";
			}
		}
	?>
		<h3 class='articletitle'>Changes made</h3>
		
			<?php if ($errorMessage) { ?><p class='error'><?php echo $errorMessage?></p><?php } ?>
			
<?php } ?>
		
	</div>
	
	<div class='span-5 last'>
		<?php include("template/currentorient.php"); ?>
	</div>
</div>
<?php include("template/footer.php"); ?>
</div>

<?php include("template/bottom.php"); ?>