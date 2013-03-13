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
              
            <?php
            $query = "SELECT article_filename, large_filename, thumb_filename, caption, name FROM photo, author WHERE photo.photographer = author.id AND article_date='$date';";
            $photoResults = mysql_query($query);
            ?>
            <p><font class="text">
            <?php 
            while ($row = mysql_fetch_array($photoResults)) {
            	$largeName = "../images/$date/" . $row["large_filename"];
            	$thumbName = "../images/$date/" . $row["thumb_filename"];
            	$articleName = "../images/$date/" . $row["article_filename"];
            	$authorName = $row["name"];
            	$caption = $row["caption"];
            	$title = $caption . "<br />" . (strcmp($authorName, "") != 0 ? $authorName . ", Bowdoin Orient<br />" : "");
            	echo "<a href='$largeName' rel='lightbox[slideshow]' title=\"$title\" style='border:0px solid black;'><img src='$thumbName' style='border: 2px solid black; margin: 5px;' /></a>";
            }
            ?>
<!-- <?php
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
?> -->
</p>
			  
			  <p>&nbsp;</p>
			  



<!-- Stop -->

<?php
include("stop.php");
?>