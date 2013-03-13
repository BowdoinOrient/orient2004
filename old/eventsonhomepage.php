<?php ######events on homepage start ?>


<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr><td>


                    <table width="100%" border="0" cellpadding="1" cellspacing="0">
                      <tr> 
                        <td colspan="2" valign="top"><img src="/orient/images/events.jpg"></td>
                      </tr>


<?php

$todaysDate = date("Y-m-d");

$tomorrowsDate = date ("Y-m-d", mktime (0,0,0,date("m"),(date("d")+1),date("Y")));

$todaysDateLong = date("l, F j, Y");

$query = "	select
			date_format(event.event_date, '%M %e, %Y') as edate,
			event.event_priority,
			event.title,
			event.description,
			event.timeplace,
			daydate.day,
			event.event_date as tdate
		from
			event
		inner join
			daydate
		on
			(event.event_date = daydate.date)
		where
			event.issue_date = '$date' and
			(event.event_date = '$todaysDate' or event.event_date = '$tomorrowsDate')
		order by
			event.event_date, event.event_priority
";

$queryResult = mysql_query ($query);

?>

<?php
while ($row = mysql_fetch_array($queryResult)) {	
	$eventDate = $row["edate"];
	$tDate = $row["tdate"];
	$eventDayname = $row["day"];
	$eventTitle = $row["title"];
	$eventTimeplace = $row["timeplace"];
?>

                      <tr> 
                        <td colspan=2 valign=top>

<table width="100%" cellspacing="0" cellpadding="0">
<tr><td>

<font class="frontevent">

<?php if ($tDate == $todaysDate) { ?>
<b>TODAY</b>
<?php } 

else if ($tDate == $tomorrowsDate) { ?>
<b>TOMORROW</b>
<?php } ?>



</font>

</td>
<td><div align="right"><font class="fronteventgrey"><?php echo $eventDate ?>&nbsp;&nbsp;</font></div></td>
</tr></table>

			</td>
                      </tr>

                      <tr> 
                        <td width="3%" valign="top"><font class="articleoptionsdot">&#8226;</font></td>
                        <td width="97%">
              

		<font class="frontevent">	
		<?php echo $eventTitle ?><br>
		<?php echo $eventTimeplace ?>
		</font>
		
			</td>
                      </tr>



<?php
}
?>

                      <tr> 
                        <td colspan="2" valign="top">

			<div align="right"><font class="fronteventlink"><a class="fronteventlink" href="/orient/events.php">Details and more events...</a></font></div>

			</td>
		      </tr>


</table>


</td></tr></table>


<?php ######events on homepage start ?>