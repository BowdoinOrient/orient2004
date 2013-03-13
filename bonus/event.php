<?php

# connect to DB
mysql_connect("teddy","orientdba","0r1en!") or die(mysql_error() );
mysql_select_db ("DB01Orient");

# get next issue date
$sqlQuery = "	SELECT
			DATE_FORMAT(DATE_ADD(NOW(),INTERVAL ID DAY), '%Y-%m-%d') AS DATE
		FROM
			`days`
		WHERE
			DATE_FORMAT(DATE_ADD(NOW(), INTERVAL ID DAY), '%W') ='Friday' LIMIT 0, 30
";
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
$idate = $_POST['issuedate'];
$edate = $_POST['eventdate'];
$epriority = $_POST['priority'];

$query = "	SELECT
			event.issue_date,
			event.event_date,
			event.event_priority,
			event.title,
			event.description,
			event.timeplace,
			daydate.day
		FROM
			event
		INNER JOIN
			daydate on (event.event_date = daydate.date)
		WHERE
			event.issue_date = '$idate' and
			event.event_priority = '$epriority' and
			event.event_date = '$edate'
";

$queryresult = mysql_query ($query);

if ($row = mysql_fetch_array($queryresult)) {	
	$eventTitle = $row["title"];
	$eventdate = $row["event_date"];
	$issuedate = $row["issue_date"];
	$eventpriority = $row["event_priority"];
	$description = $row["description"];
	$timeplace = $row["timeplace"];
}

# Change quotes
if ($type == edit) {
$old = array("\"");
$new = array("&quot;");
$eventTitleNew = str_replace($old, $new, $eventTitle);
$descriptionNew = str_replace($old, $new, $description);
$timeplaceNew = str_replace($old, $new, $timeplace);
}

?>

<HTML>
<HEAD>
<TITLE>BONUS</TITLE>
<link href="orient.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY>

<p>
<a href="index.php"><img src="logo.jpg" border="0"></a>
</p>

<table bgcolor="CCCCCC" cellpadding="1" width="100%">
  <tr>
    <td>
	<font class="textbold">&nbsp;
		<?php if ($type == add) { ?>Add an event<?php } ?>
		<?php if ($type == query) { ?>Search events to edit<?php } ?>
		<?php if ($type == edit) { ?>Edit an event<?php } ?>
	</font>
    </td>
  </tr>
</table>


<FORM method="POST" action="
	<?php if ($type == add) { ?>event_sql.php?type=add<?php } ?>
	<?php if ($type == query) { ?>event_results.php<?php } ?>
	<?php if ($type == edit) { ?>event_sql.php?type=edit<?php } ?>
">

<table rows=2 cols=2 cellspacing=0 cellpadding=5>
  <tr>
    <td valign="top">

	<table cols=2 cellspacing=0 cellpadding=2>
	  <tr>
	    <td>

	      Issue Date:

	    </td>
	    <td>

	<?php if ($type == add) { ?>
		<SELECT name="issuedate">
         	<?php 
		$sqlQuery = "select issue_date from issue";
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
	      	<SELECT name="issuedate">
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
	      	<SELECT name="issuedate">
         	<?php 
		$sqlQuery = "select issue_date from issue";
		$res = mysql_query ($sqlQuery);
		while ($row = mysql_fetch_array($res)) {
			$issueDate2 = $row["issue_date"];
		?>
		<OPTION 
		<?php
		if ($issueDate2 == $issuedate) { ?>
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

	      Event Date:

	    </td>
	    <td>

	<?php if ($type == add) { ?>
		<SELECT name="eventdate">
		<?php 
		$sqlQuery2 = "select date from daydate order by date";
		$res2 = mysql_query ($sqlQuery2);
		while ($row2 = mysql_fetch_array($res2)) {
		$eventDate2 = $row2["date"];
		?>
		<OPTION 
		<?php if ($eventDate2 == $nextfriday) { ?>
		selected
		<?php } ?>
		
		value="<?php echo $eventDate2 ?>"><?php echo $eventDate2 ?></OPTION>
		<?php
		}
		?>
		</SELECT>
	<?php } ?>

	<?php if ($type == query) { ?>
		<SELECT name="eventdate">
		<OPTION value=""></OPTION>
		<?php 
		$sqlQuery2 = "select date from daydate order by date";
		$res2 = mysql_query ($sqlQuery2);
		while ($row2 = mysql_fetch_array($res2)) {
		$eventDate = $row2["date"];
		?>
		<OPTION value="<?php echo $eventDate ?>"><?php echo $eventDate ?></OPTION>
		<?php
		}
		?>
		</SELECT>
	<?php } ?>

	<?php if ($type == edit) { ?> 
	      	<SELECT name="eventdate">
		<?php 
		$sqlQuery2 = "select date from daydate order by date";
		$res2 = mysql_query ($sqlQuery2);
		while ($row2 = mysql_fetch_array($res2)) {
			$eventDate2 = $row2["date"];
		?>
		<OPTION 
		<?php
		if ($eventDate2 == $eventdate) { ?>
			selected
		<?php } ?>
		value="<?php echo $eventDate2 ?>"><?php echo $eventDate2 ?>
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
		Priority:
	    </td>
	    <td>

	<?php if ($type == add) { ?>
		<SELECT name="priority">
		<OPTION value="1">1</OPTION>
		<OPTION value="2">2</OPTION>
		<OPTION value="3">3</OPTION>
		<OPTION value="4">4</OPTION>
		<OPTION value="5">5</OPTION>
		<OPTION value="6">6</OPTION>
		<OPTION value="7">7</OPTION>
		<OPTION value="8">8</OPTION>
		<OPTION value="9">9</OPTION>
		<OPTION value="10">10</OPTION>
		<OPTION value="11">11</OPTION>
		<OPTION value="12">12</OPTION>
		<OPTION value="13">13</OPTION>
		<OPTION value="14">14</OPTION>
		<OPTION value="15">15</OPTION>
		<OPTION value="16">16</OPTION>
		<OPTION value="17">17</OPTION>
		<OPTION value="18">18</OPTION>
		</SELECT>
	<?php } ?>

	<?php if ($type == query) { ?>
		<SELECT name="priority">
		<OPTION value=""></OPTION>
		<OPTION value="1">1</OPTION>
		<OPTION value="2">2</OPTION>
		<OPTION value="3">3</OPTION>
		<OPTION value="4">4</OPTION>
		<OPTION value="5">5</OPTION>
		<OPTION value="6">6</OPTION>
		<OPTION value="7">7</OPTION>
		<OPTION value="8">8</OPTION>
		<OPTION value="9">9</OPTION>
		<OPTION value="10">10</OPTION>
		<OPTION value="11">11</OPTION>
		<OPTION value="12">12</OPTION>
		<OPTION value="13">13</OPTION>
		<OPTION value="14">14</OPTION>
		<OPTION value="15">15</OPTION>
		<OPTION value="16">16</OPTION>
		<OPTION value="17">17</OPTION>
		<OPTION value="18">18</OPTION>
		</SELECT>
	<?php } ?>

	<?php if ($type == edit) { ?> 
		<SELECT name="priority">
          	<?php
		for($i = 1; $i < 30; ++$i) {
		?>
          	<OPTION 
		<?php
		if ($i == $eventpriority) { ?>
			selected
		<?php } ?>
		value="<?php echo $i ?>"><?php echo $i ?>
		</OPTION>
          	<?php } ?>
	        </SELECT>
	<?php } ?>

	    </td>
	  </tr>
	  <tr>
	    <td>
		Title:
	    </td>
	    <td>
		<?php if ($type == add) { ?><INPUT type="text" name="title" size="60"><?php } ?>
		<?php if ($type == query) { ?><INPUT type="text" name="title" size="60" value=""><?php } ?>
		<?php if ($type == edit) { ?><INPUT type="text" name="title" size="60" value="<?php echo $eventTitleNew ?>"><?php } ?>
	    </td>
	  </tr>
	  <tr>
	    <td>
		Description:
	    </td>
	    <td>

		<?php if ($type == add) { ?><TEXTAREA name="description" rows="4" cols="60" wrap="soft"></TEXTAREA><?php } ?>
		<?php if ($type == query) { ?><INPUT type="text" name="description" size="60" value=""><?php } ?>
		<?php if ($type == edit) { ?><TEXTAREA name="description" rows="4" cols="60" wrap="soft"><?php echo $descriptionNew ?></TEXTAREA><?php } ?>
	    </td>
	  </tr>
     	  <tr>
	    <td>
		Time/Place:
	    </td>
	    <td>

		<?php if ($type == add) { ?><INPUT type="text" name="timeplace" size="60"><?php } ?>
		<?php if ($type == query) { ?><INPUT type="text" name="timeplace" size="60" value=""><?php } ?>
		<?php if ($type == edit) { ?><INPUT type="text" name="timeplace" size="60" value="<?php echo $timeplaceNew ?>"><?php } ?>
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
<p>

<?php if ($type == add) { ?>
<INPUT type="submit" name="preview" value="Add Event">
<?php } ?>

<?php if ($type == query) { ?>
<INPUT type="submit" name="preview" value="Search Events">
<?php } ?>

<?php if ($type == edit) { ?>
<table>
  <tr>
    <td>

	<INPUT type="hidden" name="oissuedate" value="<?php echo $idate ?>">
	<INPUT type="hidden" name="oeventdate" value="<?php echo $edate ?>">
	<INPUT type="hidden" name="opriority" value="<?php echo $epriority ?>">
	<INPUT type="submit" name="preview" value="Edit Event"></FORM>

    </td>
    <td>
	&nbsp;&nbsp;
    </td>
    <td>
	<FORM method="POST" action="event_sql.php?type=delete" onSubmit="return confirm('Are you sure you want to DELETE this event?');">
	<INPUT type="hidden" name="oissuedate" value="<?php echo $idate ?>">
	<INPUT type="hidden" name="oeventdate" value="<?php echo $edate ?>">
	<INPUT type="hidden" name="opriority" value="<?php echo $epriority ?>">
	<INPUT type="submit" name="preview" value="Delete Event"></FORM>
    </td>
  </tr>
</table>
<?php } ?>

</p>
</BODY>
</HTML>