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
		<?php if ($type == add || $type == addFromWord) { ?>Add an article<?php } ?>
		<?php if ($type == query) { ?>Search articles to edit<?php } ?>
		<?php if ($type == edit) { ?>Edit an article<?php } ?>
	</font>
    </td>
  </tr>
</table>


<FORM method="POST" action="
	<?php if ($type == add || $type == addFromWord) { ?>article_sql.php?type=add<?php } ?>
	<?php if ($type == query) { ?>article_results.php<?php } ?>
	<?php if ($type == edit) { ?>article_sql.php?type=edit<?php } ?>
">


<table rows=2 cols=2 cellspacing=0 cellpadding=5>
  <tr>
    <td valign="top">

	<table cols=2 cellspacing=0 cellpadding=2>
	  <tr>
	    <td>
		Date:
	    </td>
	    <td>

	<?php if ($type == add || $type == addFromWord) { ?>
		<SELECT name="date">
         	<?php 
		$sqlQuery = "select issue_date from issue ORDER BY issue_date DESC";
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

	<?php if ($type == query) { ?>
	      	<SELECT name="date">
		<OPTION value=""></OPTION>
          	<?php 
		$sqlQuery = "select issue_date from issue";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
		$issueDate = $row["issue_date"];
		?>
	        <OPTION value="<?php echo $issueDate ?>"><?php echo $issueDate ?></OPTION>
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
		?>
		<OPTION 
		<?php
		if ($issueDate2 == $adate) { ?>
			selected
		<?php } ?>
		value="<?php echo $issueDate2 ?>"><?php echo $issueDate2 ?>
		</OPTION>
          	<?php
		}
		?>
	      	</SELECT>
	<?php } ?>

	    </td>
	  </tr>
	  <tr>
	    <td>
		Section:
	    </td>
	    <td>

	<?php if ($type == add || $type == addFromWord) { ?>
		<SELECT name="section">
		<?php 
		$sqlQuery = "select id, name from section where id > 0 and id < 6 order by order_flag";
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
		<SELECT name="section">
		<OPTION value=""></OPTION>
		<?php 
		$sqlQuery = "select id, name from section where id > 0 and id < 6 order by order_flag";
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

	<?php if ($type == edit) { ?> 
		<SELECT name="section">
		<?php 
		$sqlQuery = "select id, name from section where id > 0 and id < 6 order by order_flag";
		$res = mysql_query ($sqlQuery); ?>
		<OPTION value=""></OPTION>
		<?php
		while ($row = mysql_fetch_array($res)) {
		$sectionID = $row["id"];
		$sectionName = $row["name"];
		?>
		<OPTION 
		<?php 
		if ($sectionID == $asection) { ?>
			selected 
		<?php } ?>
		value="<?php echo $sectionID ?>"><?php echo $sectionName ?></OPTION>
		<?php
		}
		?>
		</SELECT>
	<?php } ?>

	    </td>
	  </tr>
	  <tr>
	    <td>
		Priority:
	    </td>
	    <td>

	<?php if ($type == add || $type == addFromWord) { ?>
		<SELECT name="priority">
		<?php
		for ($i = 1; $i < 20; ++$i) { ?>
			<OPTION value="<?php echo $i ?>"><?php echo $i ?></OPTION>
		<?php } ?>
		</SELECT>
	<?php } ?>

	<?php if ($type == query) { ?>
		<SELECT name="priority">
		<OPTION value=""></OPTION>
		<?php
		for ($i = 1; $i < 20; ++$i) { ?>
			<OPTION value="<?php echo $i ?>"><?php echo $i ?></OPTION>
		<?php } ?>
		</SELECT>
	<?php } ?>

	<?php if ($type == edit) { ?> 
		<SELECT name="priority">
		<?php
		for ($i = 1; $i < 20; ++$i) { ?>
			<OPTION 

			<?php if ($i == $apriority) { ?>
				selected 
			<?php } ?>
			value="<?php echo $i ?>"><?php echo $i ?></OPTION>
		<?php } ?>
		</SELECT>
	<?php } ?>

	    </td>
	  </tr>
	  <tr>
	    <td>
		Headline:
	    </td>
	    <td>
		
		<?php if ($type == add || $type == addFromWord) { ?><INPUT type="text" name="title" size="60"><?php } ?>
		<?php if ($type == query) { ?><INPUT type="text" name="title" size="60"><?php } ?>
		<?php if ($type == edit) { 
		
		$sqlQuery = "select title from article
				where 	date = '$adate' and
					priority = '$apriority' and 
					section_id = '$asection'";
		$res = mysql_query ($sqlQuery);

		while ($row = mysql_fetch_array($res)) {
		$title = $row["title"];

		?>

			<INPUT type="text" name="title" value="<?php echo $title ?>" size="60">

		<?php } } ?>


	    </td>
	  </tr>
	  <tr>
	    <td>
		Subhead:
	    </td>
	    <td>

		<?php if ($type == add || $type == addFromWord) { ?><INPUT type="text" name="subhead" size="60"><?php } ?>
		<?php if ($type == query) { ?><INPUT type="text" name="subhead" size="60"><?php } ?>
		<?php if ($type == edit) { 
		
		$sqlQuery = "select subhead from article
				where 	date = '$adate' and
					priority = '$apriority' and 
					section_id = '$asection'";
		$res = mysql_query ($sqlQuery);

		while ($row = mysql_fetch_array($res)) {
		$subhead = $row["subhead"];

		?>
			<INPUT type="text" name="subhead" value="<?php echo $subhead ?>" size="60">

		<?php } } ?>

	    </td>
	  </tr>

	  <tr>
	    <td valign="top">
		Author(s):
	    </td>
	    <td>

	<?php if ($type == add || $type == addFromWord) { ?>
		<SELECT name="author1">
		<?php 
		$sqlQuery = "select id, name from author where id > 0 order by name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$authorID = $row["id"];
			$authorName = $row["name"];
		?>
		<OPTION value="<?php echo $authorID ?>"><?php echo $authorName ?></OPTION>
		<?php
		}
		?>
		</SELECT>

		<SELECT name="author2">
		<?php 
		$sqlQuery = "select id, name from author where id > 0 order by name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$authorID = $row["id"];
			$authorName = $row["name"];
		?>
		<OPTION value="<?php echo $authorID ?>"><?php echo $authorName ?></OPTION>
		<?php
		}
		?>
		</SELECT>

		<SELECT name="author3">
		<?php 
		$sqlQuery = "select id, name from author where id > 0 order by name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$authorID = $row["id"];
			$authorName = $row["name"];
		?>
		<OPTION value="<?php echo $authorID ?>"><?php echo $authorName ?></OPTION>
		<?php
		}
		?>
		</SELECT>
	<?php } ?>

	<?php if ($type == query) { ?>
		<SELECT name="author1">
		<?php 
		$sqlQuery = "select id, name from author where id > 0 order by name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$authorID = $row["id"];
			$authorName = $row["name"];
		?>
		<OPTION value="<?php echo $authorName ?>"><?php echo $authorName ?></OPTION>
		<?php
		}
		?>
		</SELECT>

		<SELECT name="author2">
		<?php 
		$sqlQuery = "select id, name from author where id > 0 order by name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$authorID = $row["id"];
			$authorName = $row["name"];
		?>
		<OPTION value="<?php echo $authorName ?>"><?php echo $authorName ?></OPTION>
		<?php
		}
		?>
		</SELECT>

		<SELECT name="author3">
		<?php 
		$sqlQuery = "select id, name from author where id > 0 order by name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$authorID = $row["id"];
			$authorName = $row["name"];
		?>
		<OPTION value="<?php echo $authorName ?>"><?php echo $authorName ?></OPTION>
		<?php
		}
		?>
		</SELECT>
	<?php } ?>

	<?php if ($type == edit) { ?> 
		<SELECT name="author1">
		<?php 
		$sqlQuery = "select id, name from author where id > 0 order by name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$authorID = $row["id"];
			$authorName = $row["name"];
		$query = "select author1 from article 
				where 	date = '$adate' and
					priority = '$apriority' and 
					section_id = '$asection'";
		$result = mysql_query ($query);
		while ($row = mysql_fetch_array($result)) {
			$author1 = $row["author1"];
		?>
		<OPTION 
		<?php if ($authorID == $author1) { ?>
			selected
		<?php } ?>
		value="<?php echo $authorID ?>"><?php echo $authorName ?></OPTION>
		<?php
		} }
		?>
		</SELECT>

		<SELECT name="author2">
		<?php 
		$sqlQuery = "select id, name from author where id > 0 order by name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$authorID = $row["id"];
			$authorName = $row["name"];
		$query = "select author2 from article 
				where 	date = '$adate' and
					priority = '$apriority' and 
					section_id = '$asection'";
		$result = mysql_query ($query);
		while ($row = mysql_fetch_array($result)) {
			$author2 = $row["author2"];
		?>
		<OPTION 
		<?php if ($authorID == $author2) { ?>
			selected
		<?php } ?>
		value="<?php echo $authorID ?>"><?php echo $authorName ?></OPTION>
		<?php
		} }
		?>
		</SELECT>

		<SELECT name="author3">
		<?php 
		$sqlQuery = "select id, name from author where id > 0 order by name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$authorID = $row["id"];
			$authorName = $row["name"];
		$query = "select author3 from article 
				where 	date = '$adate' and
					priority = '$apriority' and 
					section_id = '$asection'";
		$result = mysql_query ($query);
		while ($row = mysql_fetch_array($result)) {
			$author3 = $row["author3"];
		?>
		<OPTION 
		<?php if ($authorID == $author3) { ?>
			selected
		<?php } ?>
		value="<?php echo $authorID ?>"><?php echo $authorName ?></OPTION>
		<?php
		} }
		?>
		</SELECT>

	<?php } ?>

	    </td>
	  </tr>
	  <tr>
	    <td>
		Author Job:
	    </td>
	    <td>


	<?php if ($type == add || $type == addFromWord) { ?>
		<SELECT name="job">
		<?php 
		$sqlQuery = "select id, name from job order by name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
		$jobID = $row["id"];
		$jobName = $row["name"];
		?>
		<OPTION value="<?php echo $jobID ?>"><?php echo $jobName ?></OPTION>
		<?php 
		}
		?>
		</SELECT>
	<?php } ?>

	<?php if ($type == query) { ?>
		<SELECT name="job">
		<?php 
		$sqlQuery = "select id, name from job order by name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
		$jobID = $row["id"];
		$jobName = $row["name"];
		?>
		<OPTION value="<?php echo $jobName ?>"><?php echo $jobName ?></OPTION>
		<?php 
		}
		?>
		</SELECT>
	<?php } ?>

	<?php if ($type == edit) { ?> 
		<SELECT name="job">
		<?php 
		$sqlQuery = "select id, name from job order by name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$jobID = $row["id"];
			$jobName = $row["name"];
			$query = "select author_job from article 
				where 	date = '$adate' and
					priority = '$apriority' and 
					section_id = '$asection'";
			$result = mysql_query ($query);
			while ($row = mysql_fetch_array($result)) {
				$authorJobID = $row["author_job"];
		?>
		<OPTION 
		
		<?php if ($jobID == $authorJobID)  { ?>
			selected 
		<?php } ?>
		value="<?php echo $jobID ?>"><?php echo $jobName ?></OPTION>
		<?php 
		} }
		?>
		</SELECT>
	<?php } ?>


	    </td>
	  </tr>

	  <tr>
	    <td>
		Series:
	    </td>
	    <td>

	<?php if ($type == add || $type == addFromWord) { ?>
		<SELECT name="series">
		<?php 
		$sqlQuery = "select id, name from series order by name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$seriesID = $row["id"];
			$seriesName = $row["name"];
		?>
		<OPTION value="<?php echo $seriesID ?>"><?php echo $seriesName ?></OPTION>
		<?php 
		}
		?>
		</SELECT>
	<?php } ?>

	<?php if ($type == query) { ?>
		<SELECT name="series">
		<?php 
		$sqlQuery = "select id, name from series order by name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$seriesID = $row["id"];
			$seriesName = $row["name"];
		?>
		<OPTION value="<?php echo $seriesName ?>"><?php echo $seriesName ?></OPTION>
		<?php 
		}
		?>
		</SELECT>
	<?php } ?>

	<?php if ($type == edit) { ?> 
		<SELECT name="series">
		<?php 
		$sqlQuery = "select id, name from series order by name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$seriesID = $row["id"];
			$seriesName = $row["name"];
			$query = "select series from article 
				where 	date = '$adate' and
					priority = '$apriority' and 
					section_id = '$asection'";
			$result = mysql_query ($query);
			while ($row = mysql_fetch_array($result)) {
				$series = $row["series"];
		?>
		<OPTION 
		<?php if ($seriesID == $series)  { ?>
			selected 
		<?php } ?>
		value="<?php echo $seriesID ?>"><?php echo $seriesName ?></OPTION>
		<?php 
		} }
		?>
		</SELECT>
	<?php } ?>


	    </td>
	  </tr>	
<tr>
	    <td>
		Article Type:
	    </td>
	    <td>

	<?php if ($type == add || $type == addFromWord) { ?>
		<SELECT name="type">
		<?php 
		$sqlQuery = "select id, name from articletype order by name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$typeID = $row["id"];
			$typeName = $row["name"];
		?>
		<OPTION value="<?php echo $typeID ?>"><?php echo $typeName ?></OPTION>
		<?php 
		}
		?>
		</SELECT>&nbsp;(Leave blank if a regular article.)
	<?php } ?>

	<?php if ($type == query) { ?>
		<SELECT name="type">
		<?php 
		$sqlQuery = "select id, name from articletype order by name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$typeID = $row["id"];
			$typeName = $row["name"];
		?>
		<OPTION value="<?php echo $typeName ?>"><?php echo $typeName ?></OPTION>
		<?php 
		}
		?>
		</SELECT>&nbsp;(Leave blank if a regular article.)
	<?php } ?>

	<?php if ($type == edit) { ?> 
		<SELECT name="type">
		<?php 
		$sqlQuery = "select id, name from articletype order by name";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$typeID = $row["id"];
			$typeName = $row["name"];
			$query = "select type from article 
				where 	date = '$adate' and
					priority = '$apriority' and 
					section_id = '$asection'";
			$result = mysql_query ($query);
			while ($row = mysql_fetch_array($result)) {
				$atype = $row["type"];
		?>
		<OPTION 
		<?php if ($typeID == $atype)  { ?>
			selected 
		<?php } ?>
		value="<?php echo $typeID ?>"><?php echo $typeName ?></OPTION>
		<?php 
		} }
		?>
		</SELECT>&nbsp;(Leave blank if a regular article.)
	<?php } ?>

	    </td>
	  </tr>

	  <tr>
	    <td
		<?php if ($type == query) { }
		else { ?>
		 valign="top"
		<?php } ?>	
	       >
	
		Article text:

	    </td>
	    <td>

	<?php if ($type == add) { ?>
		<TEXTAREA name="text" rows="10" cols="80" wrap="soft"></TEXTAREA>
	<?php } ?>

	<?php if ($type == addFromWord) { ?> 
		<TEXTAREA name="text" rows="10" cols="80" wrap="soft"><p align="left"><p align="left">rgwegwegege</p>
</p></TEXTAREA>
	<?php } ?>

	<?php if ($type == query) { ?>
		<INPUT type="text" name="text" size="60">
	<?php } ?>

	<?php if ($type == edit) { ?> 
		<TEXTAREA name="text" rows="10" cols="80" wrap="soft"><?php
			$query = "select text from article 
				where 	date = '$adate' and
					priority = '$apriority' and 
					section_id = '$asection'";
			$result = mysql_query ($query);
			while ($row = mysql_fetch_array($result)) {
				$text = $row["text"];

				echo $text;
			

			} ?></TEXTAREA>
	<?php } ?>


	    </td>
	  </tr>
	  <tr>
	    <td
		<?php if ($type == query) { }
		else { ?>
		 valign="top"
		<?php } ?>	
	       >

		Pull Quote:

	    </td>
	    <td>

	<?php if ($type == add) { ?>
		<TEXTAREA name="pullquote" rows="4" cols="60" wrap="soft"></TEXTAREA>
	<?php } ?>

	<?php if ($type == addFromWord) { ?> 
		<TEXTAREA name="pullquote" rows="4" cols="60" wrap="soft">egege
</TEXTAREA>
	<?php } ?>

	<?php if ($type == query) { ?>
		<INPUT type="text" name="pullquote" size="60">
	<?php } ?>

	<?php if ($type == edit) { ?> 
		<TEXTAREA name="pullquote" rows="4" cols="60" wrap="soft"><?php
			$query = "select pullquote from article 
				where 	date = '$adate' and
					priority = '$apriority' and 
					section_id = '$asection'";
			$result = mysql_query ($query);
			while ($row = mysql_fetch_array($result)) {
				$pullquote = $row["pullquote"];
				echo $pullquote;
			} ?></TEXTAREA>
	<?php } ?>

	    </td>
	  </tr>
	</table>

</td>
<td valign="top">

</td>
</tr>
<tr>
<td colspan = 2>
</td>
</tr>
</table>

<?php if ($type == add || $type == addFromWord) { ?>
<INPUT type="submit" name="preview" value="Add Article">
<?php } ?>

<?php if ($type == query) { ?>
<INPUT type="submit" name="preview" value="Search Articles">
<?php } ?>

<?php if ($type == edit) { ?>
<table>
  <tr>
    <td>

	<INPUT type="hidden" name="adate" value="<?php echo $adate ?>">
	<INPUT type="hidden" name="asection" value="<?php echo $asection ?>">
	<INPUT type="hidden" name="apriority" value="<?php echo $apriority ?>">
	<INPUT type="submit" name="preview" value="Edit Article"></FORM>

    </td>
    <td>
	&nbsp;&nbsp;
    </td>
    <td>
	<FORM method="POST" action="article_sql.php?type=delete" onSubmit="return confirm('Are you sure you want to DELETE this article?');">
	<INPUT type="hidden" name="adate" value="<?php echo $adate ?>">
	<INPUT type="hidden" name="asection" value="<?php echo $asection ?>">
	<INPUT type="hidden" name="apriority" value="<?php echo $apriority ?>">
	<INPUT type="submit" name="preview" value="Delete Article"></FORM>
    </td>
  </tr>
</table>
<?php } ?>

</FORM>
</BODY>
</HTML>
