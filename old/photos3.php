<?php
include("start.php");
#change first false to true gives date
#change second false to true gives "In the current Orient"
startcode("The Bowdoin Orient - Photos", true, false, $articleDate, $issueNumber, $volumeNumber);

?>

<!-- Start -->
           <font class="sectiontitle">Photos</font>
			
			<p><font class="textbold">Photos 
              from <?php echo $articleDate ?></font></p>
            <p><font class="text"><a href='javascript: rs("ss","slideshowwindow.php?date=<?php echo $date ?>",600,600);' class="more"><strong>Slideshow:</strong> All photos from this issue</a><br>
<?php
$sqlQuery = "
	select
		name,
		id
	from
		slideshow
	where
		date = '$date'
";

$result = mysql_query($sqlQuery);

while($row = mysql_fetch_array($result)) {
	$slideshowID = $row["id"];
	$slideshowname = $row["name"];
?>
              <a href='javascript: rs("ss","slideshowwindow.php?date=<?php echo "$date&slideshowid=$slideshowID" ?>",600,600);' class="more"><strong>Slideshow:</strong> <?php echo $slideshowname ?><i> (Web extra)</i></a><br>
<?php
}
?>
</p>
			  
			  <p>&nbsp;</p>
			  



<!-- Stop -->

<?php
include("stop.php");
?>