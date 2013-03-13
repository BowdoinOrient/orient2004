<?php

# Get next Friday's date.  
$sqlQuery = "SELECT DATE_FORMAT(DATE_ADD(NOW(), INTERVAL ID DAY), '%Y-%m-%d') AS DATE FROM `days` WHERE DATE_FORMAT(DATE_ADD(NOW(), INTERVAL ID DAY), '%W') ='Friday' LIMIT 0, 30"; 

# Connect to DB.
mysql_connect("teddy","orientdba","0r1en!") or die(mysql_error() );
mysql_select_db ("DB01Orient");


$result = mysql_query ($sqlQuery);
if ($row = mysql_fetch_array($result)) {
	$nextfriday = $row["DATE"];
}
else {
	$nextfriday = "2000-01-01";
}


# set and get variables for mode
$type = $_GET['type'];

# get submitted variables

$photoID = $_POST['photoid'];

$adate = $_POST['adate'];
$asection = $_POST['asection'];
$apriority = $_POST['apriority'];


?>
<HTML>
<HEAD>
<TITLE>BONUS</TITLE>
<link href="orient.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY>
<p><a href="index.php"><img src="logo.jpg" border="0"></a></p>

<table bgcolor="CCCCCC" cellpadding="1" width="100%">
  <tr>
    <td>
	<font class="textbold">&nbsp;
		<?php if ($type == add || $type == addFromArticle) { ?>Add a photo<?php } ?>
		<?php if ($type == query) { ?>Search photos to edit<?php } ?>
		<?php if ($type == edit) { ?>Edit a photo<?php } ?>
	</font>
    </td>
  </tr>
</table>


<FORM method="POST" action="
	<?php if ($type == add || $type == addFromArticle) { ?>photo_sql.php?type=add<?php } ?>
	<?php if ($type == query) { ?>photo_results.php<?php } ?>
	<?php if ($type == edit) { ?>photo_sql.php?type=edit<?php } ?>
">


  <table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr> 
      <td valign="top">Issue Date: </td>
      <td valign="top">

	<?php if ($type == add) { ?>
		<SELECT name="date">
         	<?php 
		$sqlQuery = "select issue_date from issue order by issue_date DESC";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
		$issueDate2 = $row["issue_date"];
		?>
         	 <OPTION 
		<?php if ($issueDate2 == $nextfriday) { ?>
		selected
		<?php } ?>

		value="<?php echo $issueDate2 ?>"><?php echo $issueDate2 ?></OPTION>
          	<?php
		}
		?>
        	</SELECT>
	<?php } ?>


	<?php if ($type == addFromArticle) { ?>
		<SELECT name="date">
         	<?php 
		$sqlQuery = "select issue_date from issue";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
		$issueDate2 = $row["issue_date"];
		?>
         	 <OPTION 
		<?php if ($issueDate2 == $adate) { ?>
		selected
		<?php } ?>

		value="<?php echo $issueDate2 ?>"><?php echo $issueDate2 ?></OPTION>
          	<?php
		}
		?>
        	</SELECT>
	<?php } ?>

	<?php if ($type == query) { ?>
		<SELECT name="date">
		<OPTION value=""></OPTION>
         	<?php 
		$sqlQuery = "select issue_date from issue";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
		$issueDate2 = $row["issue_date"];
		?>
         	 <OPTION value="<?php echo $issueDate2 ?>"><?php echo $issueDate2 ?></OPTION>
          	<?php
		}
		?>
        	</SELECT>
	<?php } ?>

	<?php if ($type == edit) { ?> 
		<SELECT name="date">
         	<?php 
		$sqlQuery = "select issue_date from issue";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$issueDate2 = $row["issue_date"];
				$query = "select article_date from photo where id = '$photoID'";
				$result = mysql_query ($query);
				while ($row = mysql_fetch_array($result)) {
					$articleDate = $row["article_date"];
		?>
         	 <OPTION 
		<?php if ($issueDate2 == $articleDate) { ?>
		selected
		<?php } ?>
		value="<?php echo $issueDate2 ?>"><?php echo $issueDate2 ?></OPTION>
          	<?php
		} }
		?>
        	</SELECT>
	<?php } ?>

      </td>
    </tr>
    <tr> 
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp; </td>
    </tr>
    <tr> 
      <td valign="top"><strong>ATTACH TO ARTICLE</strong></td>
      <td valign="top">&nbsp; </td>
    </tr>
    <tr> 
      <td valign="top">Section: </td>
      <td valign="top"><SELECT name="section">
	<?php if ($type == add) { ?>
          	<?php 
		$sqlQuery = "select id, name from section where id < 6 order by order_flag";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$sectionID = $row["id"];
			$sectionName = $row["name"];
		?>
		          <OPTION value="<?php echo $sectionID ?>"><?php echo $sectionName ?></OPTION>
		<?php
		}
		?>
		</SELECT><font class="smalltext">&nbsp;(Leave blank if just a feature photo. Enter section below.)</font>
	<?php } ?>

	<?php if ($type == addFromArticle) { ?>
          	<?php 
		$sqlQuery = "select id, name from section where id < 6 order by order_flag";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$sectionID = $row["id"];
			$sectionName = $row["name"];
		?>
		        <OPTION 
			<?php if ($sectionID == $asection) { ?>
				selected
			<?php } ?>			
			value="<?php echo $sectionID ?>"><?php echo $sectionName ?></OPTION>
		<?php
		}
		?>
		</SELECT>
	<?php } ?>

	<?php if ($type == query) { ?>
          	<?php 
		$sqlQuery = "select id, name, shortname from section where id < 6 order by order_flag";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$sectionID = $row["id"];
			$sectionName = $row["name"];
			$shortName = $row["shortname"];
		?>
		        <OPTION value="<?php echo $shortName ?>"><?php echo $sectionName ?></OPTION>
		<?php
		}
		?>
		</SELECT><font class="smalltext">&nbsp;(Leave blank if just a feature photo. Enter section below.)</font>
	<?php } ?>

	<?php if ($type == edit) { ?> 
          	<?php 
		$sqlQuery = "select id, name from section where id < 6 order by order_flag";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$sectionID = $row["id"];
			$sectionName = $row["name"];
				$query = "select article_section from photo where id = '$photoID'";
				$result = mysql_query ($query);
				while ($row = mysql_fetch_array($result)) {
					$articleSectionID = $row["article_section"];
		?>
		<OPTION 
		<?php if ($sectionID == $articleSectionID) { ?>
		selected
		<?php } ?>
		value="<?php echo $sectionID ?>"><?php echo $sectionName ?></OPTION>
		<?php
		} }
		?>
		</SELECT><font class="smalltext">&nbsp;(Leave blank if just a feature photo. Enter section below.)</font>
	<?php } ?>




      </td>
    </tr>
    <tr> 
      <td valign="top"> Article Priority: </td>
      <td valign="top">

	<?php if ($type == add) { ?>
		<SELECT name="priority">
        	<?php
		for($i = 1; $i < 30; ++$i) {
		?>
          	<OPTION value="<?php echo $i ?>"><?php echo $i ?></OPTION>
          	<?php
		}
		?>
        	</SELECT>
	<?php } ?>

	<?php if ($type == addFromArticle) { ?>
		<SELECT name="priority">
        	<?php
		for($i = 1; $i < 30; ++$i) {
		?>
          	<OPTION 
			<?php if ($i == $apriority) { ?>
				selected
			<?php } ?>
		value="<?php echo $i ?>"><?php echo $i ?></OPTION>
          	<?php
		}
		?>
        	</SELECT>
	<?php } ?>

	<?php if ($type == query) { ?>
		<SELECT name="priority">
		<OPTION value=""></OPTION>
        	<?php
		for($i = 1; $i < 30; ++$i) {
		?>
          	<OPTION value="<?php echo $i ?>"><?php echo $i ?></OPTION>
          	<?php
		}
		?>
        	</SELECT>
	<?php } ?>

	<?php if ($type == edit) { ?> 
		<SELECT name="priority">
        	<?php
		for($i = 1; $i < 30; ++$i) {
		?>
          	<OPTION 
		
		<?php
		$query = "select article_priority from photo where id = '$photoID'";
		$result = mysql_query ($query);
		while ($row = mysql_fetch_array($result)) {
			$articlePriority = $row["article_priority"];
			if ($i == $articlePriority) { ?>
				selected
			<?php } ?>
		value="<?php echo $i ?>"><?php echo $i ?></OPTION>
          	<?php
		} }
		?>
        	</SELECT>
	<?php } ?>

	</td>
    </tr>
    <tr> 
      <td valign="top">Priority of photo in article: </td>
      <td valign="top">

	<?php if ($type == add || $type == addFromArticle) { ?>
		<SELECT name="article_photo_priority">
        	<?php
		for($i = 1; $i < 30; ++$i) {
		?>
          	<OPTION value="<?php echo $i ?>"><?php echo $i ?></OPTION>
          	<?php
		}
		?>
        	</SELECT><font class="smalltext">&nbsp;(Only change if there will be more than 
        	one photo attached to a particular article.)</font>
	<?php } ?>

	<?php if ($type == query) { ?>
		<select name="article_photo_priority">
		<option value=""></option>
          	<?php
		for($i = 1; $i < 30; ++$i) {
		?>
         	<option value="<?php echo $i ?>"><?php echo $i ?></option>
          	<?php
		}
		?>
        	</select><font class="smalltext">&nbsp;(Only change if there will be more than 
        	one photo attached to a particular article.)</font>
	<?php } ?>

	<?php if ($type == edit) { ?> 
		<SELECT name="article_photo_priority">
        	<?php
		for($i = 1; $i < 30; ++$i) {
		?>
          	<OPTION 
		<?php
		$query = "select article_photo_priority from photo where id = '$photoID'";
		$result = mysql_query ($query);
		while ($row = mysql_fetch_array($result)) {
			$articlePhotoPriority = $row["article_photo_priority"];
			if ($i == $articlePhotoPriority) { ?>
				selected
			<?php } ?>
		value="<?php echo $i ?>"><?php echo $i ?></OPTION>
          	<?php
		} }
		?>
        	</SELECT><font class="smalltext">&nbsp;(Only change if there will be more than 
        	one photo attached to a particular article.)</font>
	<?php } ?>

	</td>
    </tr>
    <tr> 
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr> 
      <td valign="top"><strong>MAKE A FETAURE PHOTO</strong></td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr> 
      <td valign="top"> Is photo a feature photo? </td>
      <td valign="top">

	<?php if ($type == add || $type == addFromArticle) { ?>
		<SELECT name="feature">
          	<OPTION value="n">No</OPTION>
          	<OPTION value="y">Yes</OPTION>
        	</SELECT>
	<?php } ?>

	<?php if ($type == query) { ?>
		<SELECT name="feature">
          	<OPTION value=""></OPTION>
          	<OPTION value="n">No</OPTION>
          	<OPTION value="y">Yes</OPTION>
        	</SELECT>
	<?php } ?>

	<?php if ($type == edit) { ?>
		<SELECT name="feature">
		<OPTION 
		<?php
		$query = "select feature from photo where id = '$photoID'";
		$result = mysql_query ($query);
		if ($row = mysql_fetch_array($result)) {
			$feature = $row["feature"];
			if ($feature == 'n') { ?>
			selected
			<?php } ?>
			value="n">No</OPTION>
			<OPTION 
			<?php if ($feature == 'y') { ?>
			selected
			<?php } ?>
          		value="y">Yes</OPTION>			
		<?php } ?>
        	</SELECT>
	<?php } ?>

	</td>
    </tr>
    <tr> 
      <td valign="top"> If yes, then in what section? </td>
      <td valign="top">

	<?php if ($type == add || $type == addFromArticle) { ?>
		<SELECT name="feature_section">
          	<?php 
		$sqlQuery = "select id, name from section where id < 6 or id = 10 order by order_flag";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$sectionID = $row["id"];
			$sectionName = $row["name"];
		?>
    	      	<OPTION value="<?php echo $sectionID ?>"><?php echo $sectionName ?></OPTION>
          	<?php
		}
		?>
        	</SELECT>
	<?php } ?>

	<?php if ($type == query) { ?>
		<SELECT name="feature_section">
          	<?php 
		$sqlQuery = "select id, name, shortname from section where id < 6 or id = 10 order by order_flag";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$sectionID = $row["id"];
			$sectionName = $row["name"];
			$shortName = $row["shortname"];
		?>
    	      	<OPTION value="<?php echo $shortName ?>"><?php echo $sectionName ?></OPTION>
          	<?php
		}
		?>
        	</SELECT>
	<?php } ?>

	<?php if ($type == edit) { ?>
		<SELECT name="feature_section">
          	<?php 
		$sqlQuery = "select id, name from section where id < 6 or id = 10 order by order_flag";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$sectionID = $row["id"];
			$sectionName = $row["name"];

			$query = "select feature_section from photo where id = '$photoID'";
			$result = mysql_query ($query);
			while ($row = mysql_fetch_array($result)) {
				$featureSectionID = $row["feature_section"];
		?>
    	      	<OPTION 
		<?php if ($sectionID == $featureSectionID) { ?>
		selected
		<?php } ?>
		value="<?php echo $sectionID ?>"><?php echo $sectionName ?></OPTION>
          	<?php
		} }
		?>
        	</SELECT>			
	<?php } ?>

	</td>
    </tr>
    <tr> 
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr> 
      <td valign="top"><strong>ATTACH TO SLIDESHOW</strong></td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr> 
      <td valign="top">Slideshow Name: </td>
      <td valign="top">

	<?php if ($type == add || $type == addFromArticle) { ?>
		<select name="slideshow">
          	<?php 
		$sqlQuery = "select id, name, date from slideshow order by date, name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$slideshowID = $row["id"];
			$slideshowName = $row["name"];
			$slideshowDate = $row["date"];
		?>
          	<option value="<?php echo $slideshowID ?>"><?php echo $slideshowDate ?>
		<?php if ($slideshowID != 0) { echo ": "; } ?><?php echo $slideshowName ?></option>
          	<?php
		}
		?>
        	</select>
	<?php } ?>

	<?php if ($type == query) { ?>
		<select name="slideshow">
          	<?php 
		$sqlQuery = "select id, name, date from slideshow order by date, name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$slideshowID = $row["id"];
			$slideshowName = $row["name"];
			$slideshowDate = $row["date"];
		?>
          	<option value="<?php echo $slideshowName ?>"><?php echo $slideshowDate ?>
		<?php if ($slideshowID != 0) { echo ": "; } ?><?php echo $slideshowName ?></option>
          	<?php
		}
		?>
        	</select>
	<?php } ?>

	<?php if ($type == edit) { ?>
		<select name="slideshow">
          	<?php 
		$sqlQuery = "select id, name, date from slideshow order by date, name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$slideshowID = $row["id"];
			$slideshowName = $row["name"];
			$slideshowDate = $row["date"];

			$query = "select slideshow_id from photo where id = '$photoID'";
			$result = mysql_query ($query);
			while ($row = mysql_fetch_array($result)) {
				$photoSlideshowID = $row["slideshow_id"];
		?>
          	<option 
		<?php if ($slideshowID == $photoSlideshowID) { ?>
		selected
		<?php } ?>
		value="<?php echo $slideshowID ?>"><?php echo $slideshowDate ?>
		<?php if ($slideshowID != 0) { echo ": "; } ?><?php echo $slideshowName ?></option>
          	<?php
		} }
		?>
        	</select>		
	<?php } ?>

	</td>
    </tr>
    <tr> 
      <td valign="top">Slideshow Priority: </td>
      <td valign="top">

	<?php if ($type == add || $type == addFromArticle) { ?>
		<SELECT name="slideshow_photo_priority">
		<OPTION value=""></OPTION>
          	<?php
		for($i = 1; $i < 30; ++$i) {
		?>
          	<OPTION value="<?php echo $i ?>"><?php echo $i ?></OPTION>
          	<?php
		}
		?>
        	</SELECT>
	<?php } ?>

	<?php if ($type == query) { ?>
		<SELECT name="slideshow_photo_priority">
		<OPTION value=""></OPTION>
          	<?php
		for($i = 1; $i < 30; ++$i) {
		?>
          	<OPTION value="<?php echo $i ?>"><?php echo $i ?></OPTION>
          	<?php
		}
		?>
        	</SELECT>
	<?php } ?>

	<?php if ($type == edit) { ?>
		<SELECT name="slideshow_photo_priority">
		<OPTION value=""></OPTION>
          	<?php
		for($i = 1; $i < 30; ++$i) {
		?>
          	<OPTION 
		<?php
		$query = "select slideshow_photo_priority from photo where id = '$photoID'";
		$result = mysql_query ($query);
		while ($row = mysql_fetch_array($result)) {
			$slideshowPhotoPriority = $row["slideshow_photo_priority"];
			if ($i == $slideshowPhotoPriority) { ?>
				selected
			<?php } ?>
		value="<?php echo $i ?>"><?php echo $i ?></OPTION>
          	<?php
		} }
		?>
        	</SELECT>		
	<?php } ?>

	</td>
    </tr>
    <tr> 
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr> 
      <td valign="top"><strong>PHOTO INFORMATION</strong></td>
      <td valign="top">&nbsp;</td>
    </tr>
    <tr> 
      <td valign="top"> Photo Filename: </td>
      <td valign="top">

	<?php if ($type == add || $type == addFromArticle) { ?>
		<input type="text" name="photofilename" size="40"> <font class="smalltext">&nbsp;(Remember to add .jpg to the end of the filename.)</font>
	<?php } ?>

	<?php if ($type == query) { ?>
		<input type="text" name="photofilename" size="40"> <font class="smalltext">
	<?php } ?>

	<?php if ($type == edit) { ?>
		<input type="text" name="photofilename" value="<?php
		$query = "select article_filename from photo where id = '$photoID'";
		$result = mysql_query ($query);
		while ($row = mysql_fetch_array($result)) {
			$filename = $row["article_filename"];
			# remove article_ from filename
				$old = array("article_");
				$new = array("");
				$newFilename = str_replace($old, $new, $filename);
			echo $newFilename; } ?>" size="40"><font class="smalltext">&nbsp;(Remember to add .jpg to the end of the filename.)</font>		
	<?php } ?>

	</td>
    </tr>
    <tr> 
      <td valign="top"> Photographer: </td>
      <td valign="top">

	<?php if ($type == add || $type == addFromArticle) { ?>
		<SELECT name="photographer">
          	<?php 
		$sqlQuery = "select id, name from author where id > 0 order by name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$photographerID = $row["id"];
			$photographerName = $row["name"];
		?>
          	<OPTION value="<?php echo $photographerID ?>"><?php echo $photographerName ?></OPTION>
         	<?php
		}
		?>
        	</SELECT><font class="smalltext">&nbsp;(Enter either a staff photographer here 
        	or a manual credit below, but not both.)</font></td>	<?php } ?>

	<?php if ($type == query) { ?>
		<SELECT name="photographer">
          	<?php 
		$sqlQuery = "select id, name from author where id > 0 order by name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$photographerID = $row["id"];
			$photographerName = $row["name"];
		?>
          	<OPTION value="<?php echo $photographerName ?>"><?php echo $photographerName ?></OPTION>
         	<?php
		}
		?>
        	</SELECT><font class="smalltext">&nbsp;(Enter either a staff photographer here 
        	or a manual credit below, but not both.)</font></td>	<?php } ?>

	<?php if ($type == edit) { ?>
		<SELECT name="photographer">
          	<?php 
		$sqlQuery = "select id, name from author where id > 0 order by name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$photographerID = $row["id"];
			$photographerName = $row["name"];

			$query = "select photographer from photo where id = '$photoID'";
			$result = mysql_query ($query);
			while ($row = mysql_fetch_array($result)) {
				$photographer = $row["photographer"];
		?>
          	<OPTION 
		<?php if ($photographerID == $photographer) { ?>
		selected
		<?php } ?>
		value="<?php echo $photographerID ?>"><?php echo $photographerName ?></OPTION>
         	<?php
		} }
		?>
        	</SELECT><font class="smalltext">&nbsp;(Enter either a staff photographer here 
        	or a manual credit below, but not both.)</font></td>	
	<?php } ?>

    </tr>
    <tr> 
      <td valign="top">&nbsp;&nbsp;&nbsp;OR Manual Photo Credit: </td>
      <td valign="top">

	<?php if ($type == add || $type == addFromArticle) { ?>
		<input type="text" name="photocredit" size="60">
	<?php } ?>

	<?php if ($type == query) { ?>
		<input type="text" name="photocredit" size="60">
	<?php } ?>

	<?php if ($type == edit) { ?>
		<input type="text" name="photocredit" size="60" value="<?php
		$query = "select credit from photo where id = '$photoID'";
		$result = mysql_query ($query);
		while ($row = mysql_fetch_array($result)) {
			$credit = $row["credit"];
			echo $credit; } ?>">	
	<?php } ?>

	</td>
    </tr>
    <tr> 
      <td valign="top"> Photo Caption: </td>
      <td valign="top">

	<?php if ($type == add || $type == addFromArticle) { ?>
		<TEXTAREA name="photocaption" rows="4" cols="60" wrap="soft"></TEXTAREA>
	<?php } ?>

	<?php if ($type == query) { ?>
		<input type="text" name="photocaption" size="60">
	<?php } ?>

	<?php if ($type == edit) { ?>
				<TEXTAREA name="photocaption" rows="4" cols="60" wrap="soft"><?php
		$query = "select caption from photo where id = '$photoID'";
		$result = mysql_query ($query);
		while ($row = mysql_fetch_array($result)) {
			$caption = $row["caption"];
			echo $caption; } ?></TEXTAREA>
	<?php } ?>

 

      </td>
    </tr>
  </table>

<?php if ($type == add || $type == addFromArticle) { ?>
<INPUT type="submit" name="preview" value="Add Photo">
<?php } ?>

<?php if ($type == query) { ?>
<INPUT type="submit" name="preview" value="Search Photos">
<?php } ?>

<?php if ($type == edit) { ?>
<table>
  <tr>
    <td>

	<INPUT type="hidden" name="photoid" value="<?php echo $photoID ?>">
	<INPUT type="submit" name="preview" value="Edit Photo"></FORM>

    </td>
    <td>
	&nbsp;&nbsp;
    </td>
    <td>
	<FORM method="POST" action="photo_sql.php?type=delete" onSubmit="return confirm('Are you sure you want to DELETE this photo?');">
	<INPUT type="hidden" name="photoid" value="<?php echo $photoID ?>">
	<INPUT type="submit" name="preview" value="Delete Photo"></FORM>
    </td>
  </tr>
</table>
<?php } ?>

</FORM>
</BODY>
</HTML>