<?php
include("template/top.php");
$title = "Add New Issue";
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
		<h2 class='articlesection'>Add New Issue</h2>
		
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
			
			<p>Only change the Volume and Issue number if it's the first issue of a new volume. If it is, the issue number will be 1, and the volume number will be the next Roman Numeral.</p>
			<form action='newissue.php' method='POST'>
				<table>
				<tr><td><label for='date'>Date:</label></td><td><input type="text" name="date" id="date" value='<?php echo $nextFriday;?>' /></td></tr>
				<tr><td><label for='volume'>Volume:</label></td><td><input type="text" name="volume" id="volume" value='<?php echo $lastVolume; ?>' /></td></tr>
				<tr><td><label for='issue'>Issue number:</label></td><td><input type="text" name="issue" id="issue" value='<?php echo $nextIssue;?>' /></td></tr>
				<tr><td><label for='pwd'>Password:</label></td><td><input type="password" name="pwd" id="pwd" /></td></tr>
				</table>
				<input type="submit" value="Add Issue" />
			</form>
			
<?php } else { 
		// They've put in the proper password, we add a new issue.
		$volResults = mysql_query("SELECT id FROM volume WHERE numeral='" . $_POST['volume']. "'");
		if (mysql_num_rows($volResults) == 0) {
			// this means add a new volume to the volumes table.
			$volID = mysql_result(mysql_query("SELECT id FROM volume ORDER BY id DESC LIMIT 0, 1"), 0, "id") + 1;
			$query = "INSERT into volume VALUES($volID, '" . $_POST['volume'] . "')";
			mysql_query($query);
		} else {
			$volID = mysql_result(mysql_query("SELECT id FROM volume WHERE numeral='" . $_POST['volume']. "'"), 0, "id");
		}
		$query = "INSERT into issue VALUES('" . $_POST['date'] . "', $volID, " . $_POST['issue'] . ", 'n', 3)";
		mysql_query($query);
		$newIssue = true;
		$idate = $_POST['date'];
		$dateYear = substr($idate, 0, 4);
		$dateMonth = substr($idate, 5, 2);
		$dateDay = substr($idate, 8);
		for ($i = 0; $i <= 8; $i++) {
			$newTime = mktime(0, 0, 0, intval($dateMonth), intval($dateDay + $i), intval($dateYear));
			$newDate = date("Y-m-d", $newTime);
			$query = "SELECT * FROM daydate WHERE date='$newDate'";
			if (mysql_num_rows(mysql_query($query)) == 0) {
				$query = "INSERT INTO daydate (`date`, `day`) VALUES ('$newDate', '" . date("l", $newTime) . "');";
				mysql_query($query);
			}
		}
		
	?>
		<h3 class='articletitle'>Congratulations, you've created an issue for <?php echo $_POST['date'];?>!</h3>
		
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