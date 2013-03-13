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
			event.event_date = '$todaysDate'
		order by
			event.event_date, event.event_priority
";

$queryResult = mysql_query ($query);
$nrows = mysql_num_rows ($queryResult);

?>

<tr> 
<td colspan=2 valign=top>

<table width="100%" cellspacing="0" cellpadding="0">
<tr><td>

<font class="frontevent"><b>TODAY</b></font>

</td>

<td><div align="right"><font class="fronteventgrey"><?php echo $todaysDate ?>&nbsp;&nbsp;</font></div></td>
</tr></table>

</td>
</tr>


<?php	

for ($i=0;$i<$nrows;$i++) {

if ($row = mysql_fetch_array($queryResult)) {	
	$eventDate = $row["edate"];
	$tDate = $row["tdate"];
	$eventDayname = $row["day"];
	$eventTitle = $row["title"];
	$eventTimeplace = $row["timeplace"];

?>





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

else { ?>

                      <tr> 
                        <td width="3%" valign="top"><font class="articleoptionsdot">&#8226;</font></td>
                        <td width="97%">
              

		<font class="frontevent">	
		<i>No events scheduled.</i>
		</font>
		
			</td>
                      </tr>



<?php } } 

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
			event.event_date = '$tomorrowsDate'
		order by
			event.event_date, event.event_priority
";

$queryResult = mysql_query ($query);

?>

<tr> 
<td colspan=2 valign=top>

<table width="100%" cellspacing="0" cellpadding="0">
<tr><td>

<font class="frontevent"><b>TOMORROW</b></font>

</td>

<td><div align="right"><font class="fronteventgrey"><?php echo $tomorrowsDate ?>&nbsp;&nbsp;</font></div></td>
</tr></table>

</td>
</tr>


<?php
while ($row = mysql_fetch_array($queryResult)) {	
	$eventDate = $row["edate"];
	$tDate = $row["tdate"];
	$eventDayname = $row["day"];
	$eventTitle = $row["title"];
	$eventTimeplace = $row["timeplace"];
?>





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


			<div align="right"><font class="photoenlarge"><a class="photoenlarge" href="/orient/events.php">Details and future events...</a></font></div>

			</td>
		      </tr>


</table>


</td></tr></table>


<?php ######events on homepage start ?>