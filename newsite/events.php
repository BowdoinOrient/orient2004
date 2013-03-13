<?php
include("template/top.php");
if ($_GET['nyroModalSel']) {
	// This is for AJAX calls from the sidebar.
	// If there isn't this GET variable, then display the full events page.
	$day = $_GET['nyroModalSel'];
	$events = getEvents($day);
	$getDate = getEvents($day);
	if ($row = mysql_fetch_array($getDate)) {
		$eventDate = $row['edate'];
		$eventDayname = $row['day'];
	}
?>
<div id='<?php echo $day; ?>'>
	<div class='eventsoverlay' style='width: 800px;'>
		<div class='eventsoverlaydate'>
			<h2 class='bottom'><?php echo $eventDayname; ?></h2>
			<h3 class='top'><?php echo $eventDate; ?></h3>
		</div>
		<hr />
		<?php
			$i = 0;
			while ($row = mysql_fetch_array($events) and $i < 2) {
				$eventTitle = $row['title'];
				$eventDescription = $row['description'];
				$eventTimeplace = $row['timeplace'];
				echoEvent($eventTitle, $eventDescription, $eventTimeplace);
				$i++;
			}
			if ($row) {
				echo "<a href='events.php#" . $day . "'>More events...</a>";
			}
		?>
	</div>
</div>

<?php } else { 
	$title = "The Bowdoin Orient - Events";
	$days = array();
	$days[0] = 'Friday';
	$days[1] = 'Saturday';
	$days[2] = 'Sunday';
	$days[3] = 'Monday';
	$days[4] = 'Tuesday';
	$days[5] = 'Wednesday';
	$days[6] = 'Thursday';
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
			<div class='span-16'>
				<h2 class='articlesection'>Events on Campus This Week</h2>
				<?php
				foreach ($days as $day) {
					$events = getEvents($day);
					$getDate = getEvents($day);
					if ($row = mysql_fetch_array($getDate)) {
						$edate = $row['edate'];
						$dayname = $row['day'];
					}
					if ($day != "Friday") { ?>
						<div class='spacer'></div>
					<?php } ?>
					<a name='<?php echo $dayname; ?>'></a><h2 class='articletitle bottom'><?php echo $dayname; ?></h2>
					<h3 class='articledate top'><?php echo $edate; ?></h3>
					<hr />
					<?php
					while ($row = mysql_fetch_array($events)) {
						$eventTitle = $row['title'];
						$eventDescription = $row['description'];
						$eventTimeplace = $row['timeplace'];
						echoEvent($eventTitle, $eventDescription, $eventTimeplace);
 					} 
				} ?>
			</div>
			
			<div class='span-5 last'>
				<?php include("template/currentorient.php"); ?>
			</div>
		</div>
		<?php include("template/footer.php"); ?>
		<?php include("template/bottom.php"); ?>
<?php } ?>