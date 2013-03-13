<?php
include("start.php");
#change first false to true gives date
#change second false to true gives "In the current Orient"
startcode("The Bowdoin Orient - Weather", false, false, $articleDate, $issueNumber, $volumeNumber);
?>

<!-- Start -->


  <font class="sectiontitle">NEWS</font>
                 <p><font class="articleheadline">Today's Weather</font><br>
                    <font class="articlesubhead">Current weather in Brunswick, Maine</font><br>
                    <font class="articledate">Updated live</font></p><p>
                    
	
<script src='http://voap.weather.com/weather/oap/USME0056?template=GENXH&par=1004869678&unit=0&key=ad696f72f6523f99e983e14723510cba'></script>



<!-- Stop -->

<?php
include("stop.php");
?>