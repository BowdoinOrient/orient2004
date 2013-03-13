<?php
include("template/top.php");
$title = "Edit Photo";
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
		<h2 class='articlesection'>Main Orient Settings</h2>
		
		<?php
		$notSubmitted = true;
		if ($_POST['submit'] == "Edit Photo") {
			if ($_POST['pwd'] != $adminPassword) {
				$errors = "Your password was incorrect.";
			}
			$url = $_POST['url'];
			$datePos = strpos($url, "/images/") + 8;
			$fileNamePos = strpos($url, "/", $datePos);
			$date = substr($url, $datePos, (strlen(substr($url, $datePos)) - strlen(substr($url, $fileNamePos))));
			$fileName = substr($url, $fileNamePos + 1);
			if (!$date or !$fileName or !$datePos or !$fileNamePos) {
				$errors = "The url entered, <a href='$url'>$url</a>, was malformed.  Please try again.";
			} else {
				$notSubmitted = false;
				$needToEdit = true;
				$query = "
					SELECT
						credit,
						caption,
						photographer, 
						large_filename
					FROM
						photo
					WHERE
						article_date = '$date' AND
						(
							thumb_filename = '$fileName' OR
							article_filename = '$fileName' OR
							large_filename = '$fileName' OR
							sfeature_filename = '$fileName' OR
							ffeature_filename = '$fileName'
						)
				";
				$result = mysql_query($query);

				if (mysql_num_rows($result) != 1) {
					$errors = "There was an error with the url entered, <a href='$url'>$url</a>.  Are you sure it actually points to an article?";
				}

				$photoCap = mysql_result($result, 0, "caption");
				$photoCred = mysql_result($result, 0, "credit");
				$photographer = mysql_result($result, 0, "photographer");
				$large_filename = mysql_result($result, 0, "large_filename");
			}
		} else if ($_POST['submit'] == "Commit Changes") {
			$date = $_POST['date'];
			$large_filename = $_POST['large_filename'];
			$photoCap = mysql_real_escape_string($_POST['photoCap']);
			$photographer = mysql_real_escape_string($_POST['photographer']);
			$photoCred = mysql_real_escape_string($_POST['photoCred']);

			$query = "
				SELECT
					id
				FROM
					photo
				WHERE
					article_date = '$date' AND
					large_filename = '$large_filename'
			";
			$result = mysql_query($query);
			if (mysql_num_rows($result) != 1) {
				$errors = "There was an error editing the photo.  Please try again.";
			}

			if (!$errors) {
				$query = "
				UPDATE
					photo
				SET
					backup_caption = caption ,
					photographer = $photographer, 
					credit = '$photoCred' ,
					caption = '$photoCap'
				WHERE
					article_date = '$date' AND
					large_filename = '$large_filename'
				";
				mysql_query($query);
				$editedPhoto = true;
				$notSubmitted = false;
			}

		}
		
		if ($errors or $notSubmitted) {
			if ($errors) {
				echo "<p class='error'>$errors</p>";
			} ?>
				<form action="editphoto.php" method="post" />
				<table>
				<tr><td><label>URL of photo (actual link to photo): <input type="text" name="url" id="url" /></label></td></tr>
				<tr><td><label>Password: <input type="password" name="pwd" id="pwd" /></label></td></tr>
				<tr><td><input name="submit" type="submit" value="Edit Photo" /></td></tr>
				</table>
				</form>

			<?php } else if ($needToEdit) { ?>

				<p class='error'>Warning: All edits are final.  There is no "undo" once you commit.</p>
				<form action="editphoto.php" method="post" />
				<div>
				<img src="images/<?php echo $date . "/" . $large_filename; ?>" />
				</div>

				<div>
				<h3>Photographer</h3>
				<select name='photographer'>
				<?php 
					$photographerQuery = "SELECT * FROM author ORDER BY name DESC";
					$photographerResults = mysql_query($photographerQuery);
					for ($i = 0; $i < mysql_num_rows($photographerResults); $i++) {
						$selected = "";
						if (mysql_result($photographerResults, $i, "id") == $photographer) {
							$selected = " selected='selected' ";
						}
						echo "\t<option value='" . mysql_result($photographerResults, $i, "id") . "'$selected>" . mysql_result($photographerResults, $i, "name") . "</option>";
					}
				?>
				</select>
				</div>

				<div>
				<h3>Photo Caption</h3>
				<textarea style="width: 100%;" rows="3" name="photoCap"><?php echo $photoCap; ?></textarea>
				</div>

				<div>
				<h3>Photo Credit</h3>
				<input type="text" name="photoCred" style="width: 100%;" value="<?php echo $photoCred;?>" />
				</div>


				<input type="hidden" name="date" value="<?php echo $date;?>" />
				<input type="hidden" name="large_filename" value="<?php echo $large_filename;?>" />
				<br />
				<br />
				<input name="submit" type="submit" onClick="return confirm('WARNING: All changes are final!\nAre you sure you want to make these changes?');" value="Commit Changes" />
				</form>

			<?php } else if ($editedPhoto) { ?>
				<p>You successfully edited the photo. <img src='images/<?php echo $date . "/" . $large_filename;?>' /></p>

			<?php } ?>
		
	</div>
	
	<div class='span-5 last'>
		<?php include("template/currentorient.php"); ?>
	</div>
</div>
<?php include("template/footer.php"); ?>
</div>

<?php include("template/bottom.php"); ?>