<?php
include("template/top.php");
$title = "Finalize Issue";
$adminPassword = getSetting('password', 'bobby!');
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
		<h2 class='articlesection'>Finalize Issue</h2>
		
		<?php
		if ($_POST['pwd'] != $adminPassword) {
			// If they haven't put in the password
			if ($_POST['pwd']) {
				$errorMessage = "The wrong password was put in.  Please try again.";
			}
			
			if ($errorMessage) {
				echo "<p class='error'>$errorMessage</p>";
			}
			
			$volumeResults = mysql_query("SELECT id, numeral FROM volume ORDER BY id DESC LIMIT 0, 1");
			$lastVolume = mysql_result($volumeResults, 0, "numeral");
			$lastVolId = mysql_result($volumeResults, 0, "id");
			$nextIssue = mysql_result(mysql_query("SELECT issue_number FROM issue WHERE volume_id=$lastVolId ORDER BY issue_number DESC LIMIT 0, 1"), 0) + 1;
			$currDay = date("w");
			if ($currDay > 5) {
				$currDay -= 7;
			}
			$daysUntilFriday = 5 - $currDay;
			$year = date("Y");
			$month = date("m");
			$daysInMonth = date("t");
			$currentDay = date("d");
			$friday = $currentDay + $daysUntilFriday;
			if ($currentDay + $daysUntilFriday > $daysInMonth) {
				$friday -= $daysInMonth;
				$month++;
			}
			$nextFriday = "$year-$month-$friday";
			
			?>
			
			<form action='finalizeissue.php' method='POST'>
				<table>
				<tr><td><label for='date'>Date:</label></td><td><input type="text" name="date" id="date" value='<?php echo $nextFriday;?>' /></td></tr>
				<tr><td><label for='pwd'>Password:</label></td><td><input type="password" name="pwd" id="pwd" /></td></tr>
				</table>
				<input type="submit" value="Finalize Issue" />
			</form>
			
<?php } else { 

		// They've put in the proper password, we finalize the specified issue.
		$query = "UPDATE issue SET ready='y' WHERE issue_date='".$_POST['date']."'";
		mysql_query($query);
		$finalizedIssue = true;
		
		
	?>
		<h3 class='articletitle'>Success: the <?php echo $_POST['date'];?> issue has been finalized! Go hug a tree.</h3>
		
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