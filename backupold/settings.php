<?php

include("start.php");
$frontPage = mysql_result(mysql_query("SELECT * FROM settings WHERE name='numArticles'"), 0, "int_value");
$mostViewed = mysql_result(mysql_query("SELECT * FROM settings WHERE name='mostViewed'"), 0, "int_value");

startcode("The Bowdoin Orient - Most Viewed Pages", false, false, 0,0,0);

?>

<!--start-->
<?php if ($_POST['pwd'] != "bobby!") { ?>
		<font class="pagetitle">Orient Settings</font><br><br>
		
		<br />
		<form action="settings.php" method="post" >
		<table>
		<tr><td><strong>Number of articles to display on the front page</strong></td>
		<td><input id="numArticles" name="numArticles" type='text' value="<?php echo $frontPage;?>" /></td>
		</tr>
		<tr><td><strong>Number of Most-Viewed Articles to display</strong></td>
		<td><input id='mostViewed' name='mostViewed' type='text' value='<?php echo $mostViewed;?>' /></td>
		</tr>
<!--
		<tr>
			<td><label onClick="setVacation(0);">Summer Vacation <input type="checkbox" name="summerBreak" id="summerBreak"></label> <label onClick="setVacation(1);">Fall Break <input type="checkbox" name="fallBreak" id="fallBreak"></label>
			<br /><label onClick="setVacation(1);">Winter Break <input type="checkbox" name="winterBreak" id="winterBreak"></label> <label onClick="setVacation(1);">Spring Break <input type="checkbox" name="springBreak" id="springBreak"></label>
			</td>
		</tr>

-->		
		<tr><td><strong>Password:</strong></td><td><input type="password" id='pwd' name="pwd" /></td></tr>
		<tr><td><input name='submit' id='submit' type="submit" value="Submit Changes"></td></tr>
		</table>
		</form>
<?php } else {
		$frontPage = $_POST['numArticles'];
		$mostViewed = $_POST['mostViewed'];
		
		if ($frontPage) {
			mysql_query("UPDATE settings SET int_value=$frontPage WHERE name='numArticles'");
		} else {
			$errors = "Error: Number of Articles not set.";
		}
		
		if ($mostViewed) {
			mysql_query("UPDATE settings SET int_value=$mostViewed WHERE name='mostViewed'");
		} else {
			$errors .= "<br />Error: Number of Most-Viewed Articles not set.";
		}
		?>
		<font class="pagetitle">Orient Settings</font><br><br>
		<p>Settings changed successfully.</p>
		<p style='color: red;'><?php echo $errors; ?></p>
		<br />
		<form action="settings.php" method="post" >
		<table>
		<tr><td><strong>Number of articles to display on the front page</strong></td>
		<td><input id="numArticles" name="numArticles" value="<?php echo $frontPage;?>" /></td>
		</tr>
		<tr><td><strong>Number of Most-Viewed Articles to display</strong></td>
		<td><input id='mostViewed' name='mostViewed' type='text' value='<?php echo $mostViewed;?>' /></td>
		</tr>
		<tr>
			<td><label onClick="setVacation(0);">Summer Vacation <input type="checkbox" name="summerBreak" id="summerBreak"></label> | <label onClick="setVacation(1);">Fall Break <input type="checkbox" name="fallBreak" id="fallBreak"></label> | <label onClick="setVacation(1);">Winter Break <input type="checkbox" name="winterBreak" id="winterBreak"></label> | <label onClick="setVacation(1);">Spring Break <input type="checkbox" name="springBreak" id="springBreak"></label>
			</td>
		</tr>
		<tr><td><strong>Password:</strong></td><td><input type="password" id='pwd' name="pwd" /></td></tr>
		<tr><td><input name='submit' id='submit' type="submit" value="Submit Changes"></td></tr>
		</table>
		</form>
		
<?php } ?>
		

<!--end-->

<?php 

include("stop.php");
?>