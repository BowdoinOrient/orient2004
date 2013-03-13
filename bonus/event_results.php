<HTML>
<HEAD>
<TITLE>BONUS</TITLE>
<link href="orient.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY>
<p><a href="index.php"><img src="logo.jpg" border="0"></a></p>

<?php
mysql_connect("teddy","orientdba","0r1en!") or die(mysql_error() );
mysql_select_db ("DB01Orient");
?>

<?php

	# get submitted variables

	$idate = $_POST['issuedate'];
	$edate = $_POST['eventdate'];
	$priority = $_POST['priority'];
	$etitle = $_POST['title'];
	$edescription = $_POST['description'];
	$etimeplace = $_POST['timeplace'];


$query = "	select
			event.issue_date,
			event.event_date,
			event.event_priority,
			event.title,
			event.description,
			event.timeplace,
			daydate.day
		from
			event
		inner join
			daydate
		on
			(event.event_date = daydate.date)
		where

			event.issue_date LIKE '%$idate' and
			event.event_priority LIKE '%$priority' and
			event.event_date LIKE '%$edate' and
			event.title LIKE '%$etitle%' and
			event.description LIKE '%$edescription%' and
			event.timeplace LIKE '%$etimeplace%'
		order by
			event.issue_date desc, event.event_date, event.event_priority
";


$queryresult = mysql_query ($query);
$numRows = mysql_num_rows ($queryresult);

?>

<table bgcolor="CCCCCC" cellpadding="1" width="100%"><tr><td>
<font class="textbold">&nbsp;Select an event to edit</font><tr><td></table>

<p><b>Your search returned <?php echo $numRows ?> results.</b></p>

<p><table bgcolor="CCCCCC" cellspacing="0" cellpadding="0"><tr><td>
<table cellspacing="1" cellpadding="3">
<tr><td nowrap align="center" bgcolor="FFFFFF"><b>Edit</b></td><td nowrap bgcolor="FFFFFF"><b>Issue Date</b></td><td nowrap bgcolor="FFFFFF"><b>Event Date</b></td><td bgcolor="FFFFFF" nowrap align="center"><b>Day</b></td><td nowrap bgcolor="FFFFFF"><b>Priority</b></td><td bgcolor="FFFFFF"><b>Entry</b></td></tr>



<?php
while ($row = mysql_fetch_array($queryresult)) {	
	$eventTitle = $row["title"];
	$description = $row["description"];
	$timeplace = $row["timeplace"];
	$eventdate = $row["event_date"];
	$issuedate = $row["issue_date"];
	$eventpriority = $row["event_priority"];
	$day = $row["day"];

?>



<tr valign="top">
	<td bgcolor="FFFFFF"><FORM method="POST" action="event.php?type=edit">
	    	<INPUT type="hidden" name="issuedate" value="<?php echo $issuedate ?>">
	    	<INPUT type="hidden" name="eventdate" value="<?php echo $eventdate ?>">
	    	<INPUT type="hidden" name="priority" value="<?php echo $eventpriority ?>">
	    	<INPUT type="submit" name="submit" value="Edit">
	    	</FORM></td>
	<td nowrap bgcolor="FFFFFF"><?php echo $issuedate ?></td>
	<td nowrap bgcolor="FFFFFF"><?php echo $eventdate ?></td>
	<td nowrap bgcolor="FFFFFF" align="center"><?php echo $day ?></td>
	<td nowrap bgcolor="FFFFFF" align="center"><?php echo $eventpriority ?></td>
	<td bgcolor="FFFFFF"><b><?php echo $eventTitle ?></b><br><?php echo $description ?><br><?php echo $timeplace ?></td>
</tr>



<?php
}
?>

</table>
</td></tr></table>

</BODY>
</HTML>
