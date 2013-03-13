<?php
include("start.php");
#change first false to true gives date
#change second false to true gives "In the current Orient"
startcode("The Bowdoin Orient - Error", false, false, $articleDate, $issueNumber, $volumeNumber);
?>

<!-- Start -->
     <font class="pagetitle">Error</font> 
            <p><font class="textbold">Page Not Found</font></p>
            <p><font class="text">If you feel you have received this page in error, 
              please contact the webmaster: <a href="mailto:orientweb@bowdoin.edu">orientweb@bowdoin.edu</a>.</font></p>
			 <p><font class="text">If you need help finding a page, try one of the following:<br>
			 <a href="/orient/search.php">Search the <i>Orient</i></a><br>
			  <a href="/orient/archives.php">Browse the archives</a></font></p>
			  
            <p>&nbsp;</p>
<p><font class="text"><a href="javascript:history.go(-1)">Return to previous page</a></font></p>
<p><font class="text"><a href="/orient/">Return to the homepage</a></font></p>

			



	
			


<!-- Stop -->

<?php
include("stop.php");
?>