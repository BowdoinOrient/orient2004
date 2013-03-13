<?php
include("start.php");

#change first false to true gives date
#change second false to true gives "In the current Orient"
startcode("The Bowdoin Orient - Events", false, false, $articleDate, $issueNumber, $volumeNumber);
?>

<!-- Start -->

<font class="pagetitle">EVENTS</font> 
            <p><font class="textbold">On campus this week...</font></p>

<?php
$day[0] = 'Friday';
$day[1] = 'Saturday';
$day[2] = 'Sunday';
$day[3] = 'Monday';
$day[4] = 'Tuesday';
$day[5] = 'Wednesday';
$day[6] = 'Thursday';

for ($i = 0; $i < 8; ++$i) {


$query = "	select
			date_format(event.event_date, '%M %e, %Y') as edate,
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
			event.issue_date = '$date' and
			daydate.day = '$day[$i]'
		order by
			event.event_date, event.event_priority
";

$queryresult = mysql_query ($query);
$queryresult2 = mysql_query ($query);

?>



<?php
if ($row = mysql_fetch_array($queryresult)) {	
	$eventDate = $row["edate"];
	$eventDayname = $row["day"];
?>

<table width="100%" bgcolor="cccccc" border="0" cellpadding="7" cellspacing="0">
<tr><td>
<font class="textboldcaps"><?php echo $eventDayname ?></font><br>
<font class="text"><?php echo $eventDate ?></font><br>
</td></tr>
</table>

<?php
}
?>



<?php
while ($row2 = mysql_fetch_array($queryresult2)) {	
	$eventTitle = $row2["title"];
	$eventDescription = $row2["description"];
	$eventTimeplace = $row2["timeplace"];
?>
                <p>
		<font class="textbold"><?php echo $eventTitle ?></font><br>
		<font class="text"><?php echo $eventDescription ?></font><?php echo ($eventDescription) ? "<br>" : ""; ?>
		<font class="text"><?php echo $eventTimeplace ?></font><?php echo ($eventTimeplace) ? "<br>" : ""; ?>
		</p>
<?php
} }
?>




<!-- Stop -->

<?php
include("stop.php");
?>