<?php
include("start.php");

if ($_POST['pwd'] == "bobby") {
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
	$date = $_POST['date'];
	$dateYear = substr($date, 0, 4);
	$dateMonth = substr($date, 5, 2);
	$dateDay = substr($date, 8);
	for ($i = 0; $i <= 8; $i++) {
		$newTime = mktime(0, 0, 0, intval($dateMonth), intval($dateDay + $i), intval($dateYear));
		$newDate = date("Y-m-d", $newTime);
		$query = "SELECT * FROM daydate WHERE date='$newDate'";
		if (mysql_num_rows(mysql_query($query)) == 0) {
			$query = "INSERT INTO daydate (`date`, `day`) VALUES ('$newDate', '" . date("l", $newTime) . "');";
			mysql_query($query);
		}
	}
	
} else {
	
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
	
}

startcode("The Bowdoin Orient - Add New Issue", false, false, 0,0,0);

?>

<!--start-->
	<?php if (!$newIssue) { ?>
	<h3>Create new issue in database</h3>
	<p>Only change the Volume and Issue number if it's the first issue of a new volume.  If it is, the issue number will be 1, and the volume number will be the next Roman Numeral.</p>
	<div>
	<form action="new.php" method="POST">
	<table>
	<tr><td>Date:</td><td><input type="text" name="date" id="date" value='<?php echo $nextFriday;?>' /></td></tr>
	<tr><td>Volume:</td><td><input type="text" name="volume" id="volume" value='<?php echo $lastVolume; ?>' /></td></tr>
	<tr><td>Issue number:</td><td><input type="text" name="issue" id="issue" value='<?php echo $nextIssue;?>' /></td></tr>
	<tr><td>Password:</td><td><input type="password" name="pwd" id="pwd" /></td></tr>
	</table>
	<input type="submit" value="Add Issue" />
	</form>
	</div>

	<?php echo "<p>Volume $lastVolume ($lastVolId), Issue $nextIssue.</p>"; ?>
	
	<?php } else { ?>
	
	<h3>Congratulations, you've created an issue for <?php echo $_POST['date'];?>!</h3>
	
	<?php } ?>

<!--end-->

<?php 

include("stop.php");
?>