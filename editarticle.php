<?php
include("template/top.php");
$title = "Edit Article";
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
	if ($_POST['submit'] == "Edit Article") {
		if ($_POST['pwd'] != $adminPassword) {
			$errors = "Your password was incorrect.";
		}
		$url = $_POST['url'];
		$datePos = strpos($url, "date=");
		$sectionPos = strpos($url, "&section=");
		$idPos = strpos($url, "&id=");
		$date = substr($url, $datePos + 5, $sectionPos - $datePos - 5);
		$section = substr($url, $sectionPos + 9, $idPos - $sectionPos - 9);
		$id = substr($url, $idPos + 4, strlen($url) - $idPos - 4);
		if (!$id or !$section or !$date or !$datePos or !$sectionPos or !$idPos) {
			$errors = "The url entered, <a href='$url'>$url</a>, was malformed.  Please try again.";
		} else {
		
			$authorResults = mysql_query("SELECT * FROM author ORDER BY name ASC");
			$authorOptions = "<option value='1'>NONE</option>\n";
			for ($a = 0; $a < mysql_num_rows($authorResults); $a++) {
				$authorOptions .= "<option value='" . mysql_result($authorResults, $a, "id") . "'>" . mysql_result($authorResults, $a, "name") . "</option>\n";
			}
			$notSubmitted = false;
			$needToEdit = true;
			$query = "
				SELECT
					*
				FROM
					article
				WHERE
					date = '$date' AND
					section_id = $section AND
					priority = $id
			";
			$result = mysql_query($query);
			
			if (mysql_num_rows($result) != 1) {
				$errors = "There was an error with the url entered, <a href='$url'>$url</a>.  Are you sure it actually points to an article?";
			}
			
			$articleText = mysql_result($result, 0, "text");
			$articlePull = mysql_result($result, 0, "pullquote");
			$arTitle = mysql_result($result, 0, "title");
			$articleSub = mysql_result($result, 0, "subhead");
			$author1 = mysql_result($result, 0, "author1");
			$author2 = mysql_result($result, 0, "author2");
			$author3 = mysql_result($result, 0, "author3");
			$author4 = mysql_result($result, 0, "author4");
			$author5 = mysql_result($result, 0, "author5");
			$author6 = mysql_result($result, 0, "author6");
			$author7 = mysql_result($result, 0, "author7");
			$author8 = mysql_result($result, 0, "author8");
			$author9 = mysql_result($result, 0, "author9");
			$author10 = mysql_result($result, 0, "author10");
			$arSeries = mysql_result($result, 0, "series");
			$arType = mysql_result($result, 0, "type");
			$views = mysql_result($result, 0, "views");
			$bowdoinViews = mysql_result($result, 0, "bowdoin_views"); 
		}
	} else if ($_POST['submit'] == "Delete Article") {
		$date = $_POST['date'];
		$section = $_POST['section'];
		$id = $_POST['priority'];

		$query = "DELETE FROM article WHERE 
			date = '$date' AND
			section_id = $section AND
			priority = $id";
		$result = mysql_query($query);
		$deletedArticle = true;
		$notSubmitted = false;
		
	} else if ($_POST['submit'] == "Commit Changes") {
		$date = $_POST['date'];
		$section = $_POST['section'];
		$id = $_POST['priority'];
		$title = mysql_real_escape_string($_POST['arTitle']);
		$articleText = mysql_real_escape_string($_POST['articleText']);
		$articlePull = mysql_real_escape_string($_POST['pullQuote']);
		$articleSub = mysql_real_escape_string($_POST['articleSub']);
		$author1 = mysql_real_escape_string($_POST['author1']);
		$author2 = mysql_real_escape_string($_POST['author2']);
		$author3 = mysql_real_escape_string($_POST['author3']);
		$author4 = mysql_real_escape_string($_POST['author4']);
		$author5 = mysql_real_escape_string($_POST['author5']);
		$author6 = mysql_real_escape_string($_POST['author6']);
		$author7 = mysql_real_escape_string($_POST['author7']);
		$author8 = mysql_real_escape_string($_POST['author8']);
		$author9 = mysql_real_escape_string($_POST['author9']);
		$author10 = mysql_real_escape_string($_POST['author10']);
		$arSeries = mysql_real_escape_string($_POST['arSeries']);
		$arType = mysql_real_escape_string($_POST['arType']);
		$views = mysql_real_escape_string($_POST['views']);
		$bowdoinViews = mysql_real_escape_string($_POST['bowdoinViews']);
		
		$query = "
			SELECT
				text
			FROM
				article
			WHERE
				date = '$date' AND
				section_id = $section AND
				priority = $id
		";
		$result = mysql_query($query);
		if (mysql_num_rows($result) != 1) {
			$errors = "There was an error editing the article.  Please try again.";
		}
		
		if (!$errors) {
            $oldText = mysql_real_escape_string(mysql_result($result, 0, "text"));
			$query = "
			UPDATE
				article
			SET
				backuptext = '$oldText' ,
				author1 = '$author1' ,
				author2 = '$author2' ,
				author3 = '$author3' ,
				author4 = '$author4' ,
				author5 = '$author5' ,
				author6 = '$author6' ,
				author7 = '$author7' ,
				author8 = '$author8' ,
				author9 = '$author9' ,
				author10 = '$author10' ,
				series = $arSeries ,
				type = $arType ,
				text = '$articleText' ,
				pullquote = '$articlePull' ,
				title = '$title',
				subhead = '$articleSub'
			WHERE
				date = '$date' AND
				section_id = $section AND
				priority = $id
			";
			mysql_query($query);
			$editedArticle = true;
			$notSubmitted = false;
		}
		
	}

	if ($errors or $notSubmitted) {
		if ($errors) {
			echo "<p class='error'>$errors</p>"; 
		} ?>
			<form action='editarticle.php' method='POST'>
				<table>
				<tr><td><label for='url'>URL of article:</label></td><td><input type="text" name="url" id="url" /></td></tr>
				<tr><td><label for='pwd'>Password:</label></td><td><input type="password" name="pwd" id="pwd" /></td></tr>
				</table>
				<input name="submit" type="submit" value="Edit Article" />
			</form>
			
<?php } else if ($needToEdit) { ?>
	<p class='error'>Warning: All edits are final.  There is no "undo" once you commit.</p>
	
		<form action="editarticle.php" method="post" />

		<div>
		<h3>Headline</h3>
		<input type="text" name="arTitle" style="width: 100%;" value="<?php echo $arTitle;?>" />
		</div>

		<div>
		<h3>Subhead</h3>
		<textarea style="width: 100%;" rows="3" name="articleSub"><?php echo $articleSub; ?></textarea>
		</div>

		<div>
		<h3>Author(s)</h3>
		<a href="#" onClick="addAuthor(); return false;">Add Author</a>
		<br />
		<a href='#' onClick="removeAuthor(); return false;">Remove Author</a>
		<br />
		<br />
		<span id='author1span'>
		Author 1: <select id='author1' name='author1'>
		<?php echo $authorOptions; ?>
		</select></span>
		<span style='display:none;' id='author2span'>
		<br />
		Author 2: <select id='author2' name='author2'>
		<?php echo $authorOptions; ?>
		</select></span>
		<span style='display:none;' id='author3span'>
		<br />
		Author 3: <select id='author3' name='author3'>
		<?php echo $authorOptions; ?>
		</select></span>
		<span style='display:none;' id='author4span'>
		<br />
		Author 4: <select id='author4' name='author4'>
		<?php echo $authorOptions; ?>
		</select></span>
		<span style='display:none;' id='author5span'>
		<br />
		Author 5: <select id='author5' name='author5'>
		<?php echo $authorOptions; ?>
		</select></span>
		<span style='display:none;' id='author6span'>
		<br />
		Author 6: <select id='author6' name='author6'>
		<?php echo $authorOptions; ?>
		</select></span>
		<span style='display:none;' id='author7span'>
		<br />
		Author 7: <select id='author7' name='author7'>
		<?php echo $authorOptions; ?>
		</select></span>
		<span style='display:none;' id='author8span'>
		<br />
		Author 8: <select id='author8' name='author8'>
		<?php echo $authorOptions; ?>
		</select></span>
		<span style='display:none;' id='author9span'>
		<br />
		Author 9: <select id='author9' name='author9'>
		<?php echo $authorOptions; ?>
		</select></span>
		<span style='display:none;' id='author10span'>
		<br />
		Author 10: <select id='author10' name='author10'>
		<?php echo $authorOptions; ?>
		</select></span>
		</div>

		<div>
		<h3>Series</h3>
		<select name='arSeries'>
		<?php
		$seriesResults = mysql_query("SELECT * FROM series");
		for ($a = 0; $a < mysql_num_rows($seriesResults); $a++) {
			$selectedSeries = "";
			if ($arSeries == mysql_result($seriesResults, $a, "id")) {
				$selectedSeries = " selected='selected' ";
			}
			echo "<option value='" . mysql_result($seriesResults, $a, "id") . "'$selectedSeries>" . mysql_result($seriesResults, $a, "name") . "</option>\n";
		}
		?>
		</select>
		</div>

		<div>
		<h3>Article Type (Leave blank if normal article)</h3>
		<select name='arType'>
		<?php
			$articleTypes = mysql_query("SELECT * FROM articletype");
			for ($a = 0; $a < mysql_num_rows($articleTypes); $a++) {
				$selectedType = "";
				if ($arType == mysql_result($articleTypes, $a, "id")) {
					$selectedType = " selected='selected' ";
				}
				echo "<option value='" . mysql_result($articleTypes, $a, "id") . "'$selectedType>" . mysql_result($articleTypes, $a, "name") . "</option>\n";
			}
		?>
		</select>
		</div>

		<div>
		<h3>Article Text</h3>
		<textarea style="width: 100%;" rows="20" name="articleText"><?php echo $articleText; ?></textarea>
		</div>

		<div>
		<h3>Article PullQuote</h3>
		<textarea style="width: 100%;" rows="3" name="pullQuote"><?php echo $articlePull; ?></textarea>
		</div>

		<input type="hidden" name="date" value="<?php echo $date;?>" />
		<input type="hidden" name="section" value="<?php echo $section;?>" />
		<input type="hidden" name="priority" value="<?php echo $id; ?>" />
		<input name="submit" type="submit" onClick="return confirm('WARNING: All changes are final!\nAre you sure you want to make these changes?');" value="Commit Changes" />
		<input name="submit" type="submit" onClick="return confirm('WARNING: You cannot undelete an article!\nAre you sure you want to delete this one?');" value="Delete Article" />
		</form>


		<script type="text/javascript">
			authors = 1;

			function addAuthor() {
				if (authors > 9) {
					return false;
				}
				authors++;
				document.getElementById("author"+authors+"span").style.display = "";
			}

			function removeAuthor() {
				if (authors < 2) {
					return false;
				}
				document.getElementById("author"+authors+"span").style.display = "none";
				document.getElementById("author" + authors).value = 1;
				authors--;
			}

	<?php

			for($a = 0; $a < 10; $a++) {
				if ($a != 0 and mysql_result($result, 0, "author".($a+1)) > 1) {
					echo "\t\taddAuthor();\n";
					echo "\t\tdocument.getElementById('author" . ($a + 1) . "').value=" . mysql_result($result, 0, "author".($a+1)) . ";\n";
				}
				if ($a == 0) {			
					echo "\t\tdocument.getElementById('author" . ($a + 1) . "').value=" . mysql_result($result, 0, "author".($a+1)) . ";\n";
				}
			}


			?>

		</script>
	
<?php
	  } else if ($editedArticle) { ?>
		<p class='error'>You successfully edited <a href="article.php?date=<?php echo $date;?>&section=<?php echo $section;?>&id=<?php echo $id;?>"><?php echo stripslashes($title);?></a></p>
		<p>With query: <?php echo $query; ?></p>

	<?php } else if ($deletedArticle) { ?>
		<p class='error'>You deleted the article. <a href='editarticle.php'>Edit another</a>?</p>
	<?php } ?>
		
	</div>
	
	<div class='span-5 last'>
		<?php include("template/currentorient.php"); ?>
	</div>
</div>
<?php include("template/footer.php"); ?>
</div>
<script>
$("#url").focus();
</script>
<?php include("template/bottom.php"); ?>