<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>BONUS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="orient.css" rel="stylesheet" type="text/css">
</head>

<body>
<p><a href="index.php"><img src="logo.jpg" border="0"></a></p>
<table width="775" border="0" cellspacing="0" cellpadding="5">
  <tr> 
    <td class="index" width="83" align="left" valign="top" bgcolor="#CCCCCC"><p><strong>Articles<br>
        </strong></p></td>
    <td class="index" width="564" bgcolor="#CCCCCC">

	<table><tr><td width="150">Article:</td><td>
	<a href="article.php?type=add">Add</a> | 
	<a href="article.php?type=query">Edit/delete</a><br>
	</td></tr></table>

	<table><tr><td width="150">Related Document:</td><td>
     	<a href="document.php?type=add">Add</a> | 
	Edit/delete<br>
	</td></tr></table>

	<table><tr><td width="150">Related Link:</td><td>
	<a href="linkupload.htm">Add</a> | 
	Edit/delete<br>
	</td></tr></table>

	<table><tr><td width="150">Series:</td><td>
	<a href="seriesupload.htm">Add</a> | 
	Edit/delete<br>
	</td></tr></table>

    </td>
    <td class="index" width="8" rowspan="6" bgcolor="#FFFFFF">&nbsp;</td>
    <td class="index" width="80" rowspan="6" align="left" valign="top" bgcolor="#CCCCCC"><p><strong>Preview</strong></p>



<?php
# Connect to DB.
mysql_connect("teddy","orientdba","0r1en!") or die(mysql_error() );
mysql_select_db ("DB01Orient");

# Get next Friday's date.  
$sqlQuery = "SELECT DATE_FORMAT(DATE_ADD(NOW(), INTERVAL ID DAY), '%Y-%m-%d') AS DATE FROM `days` WHERE DATE_FORMAT(DATE_ADD(NOW(), INTERVAL ID DAY), '%W') ='Friday' LIMIT 0, 30"; 

$result = mysql_query ($sqlQuery);
if ($row = mysql_fetch_array($result)) {
	$nextfriday = $row["DATE"];
}
else {
	$nextfriday = "2000-01-01";
}

?>







     <p><a href="http://orient.bowdoin.edu/orient/index.php?date=<?php echo $nextfriday?>">Homepage</a><br>
        <a href="http://orient.bowdoin.edu/orient/section.php?section=1&date=<?php echo $nextfriday?>">News</a><br>
        <a href="http://orient.bowdoin.edu/orient/section.php?section=3&date=<?php echo $nextfriday?>">Features</a><br>
        <a href="http://orient.bowdoin.edu/orient/section.php?section=2&date=<?php echo $nextfriday?>">Opinion</a><br>
        <a href="http://orient.bowdoin.edu/orient/section.php?section=4&date=<?php echo $nextfriday?>">Arts</a><br>
        <a href="http://orient.bowdoin.edu/orient/section.php?section=5&date=<?php echo $nextfriday?>">Sports</a><br>
	<a href="http://orient.bowdoin.edu/orient/events.php?date=<?php echo $nextfriday?>">Events</a><br>
	<a href="http://orient.bowdoin.edu/orient/photos.php?date=<?php echo $nextfriday?>">Photos</a><br>
		</p></td>
  </tr>
  <tr> 
    <td class="index" align="left" valign="top"><strong>Photos<br>
      </strong></td>
    <td class="index">

	<table><tr><td width="150">Photo:</td><td>
	<a href="photo.php?type=add">Add</a> |
	<a href="photo.php?type=query">Edit/delete</a>
	</td></tr></table>

	<table><tr><td width="150">Slideshow:</td><td>
	<a href="slideshowupload.htm">Add</a> | 
	Edit/delete
	</td></tr></table>

    </td>
  </tr>
  <tr> 
    <td class="index" align="left" valign="top" bgcolor="#CCCCCC"><strong>Events<br>
      </strong></td>
    <td class="index" bgcolor="#CCCCCC">

	<table><tr><td width="150">Event:</td><td>
	<a href="event.php?type=add">Add</a> | 
	<a href="event.php?type=query">Edit/delete</a>
	</td></tr></table>

    </td>
  </tr>
  <tr> 
    <td class="index" align="left" valign="top"><strong>St<a class="sound" href="#" onClick="EvalSound('sound2')">a</a>ff<br>
      </strong></td>
    <td class="index">

	<table><tr><td width="150">Staff member:</td><td>
	<a href="staffupload.htm">Add</a> | 
	Edit/delete
	</td></tr></table>

    </td>
  </tr>
  <tr> 
    <td class="index" align="left" valign="top" bgcolor="#CCCCCC"><strong>P<a class="sound" href="#" onClick="EvalSound('sound1')">u</a>blish<br>
      </strong></td>
    <td class="index" bgcolor="#CCCCCC">

	<table><tr><td width="150">New Issue:</td><td>
	<a href="publish.htm">Publish</a>
	</td></tr></table>


   </td>
  </tr>
  <tr> 
    <td class="index" align="left" valign="top" bgcolor="#FFFFFF">
      </strong></td>
    <td class="index" bgcolor="#FFFFFF">

<p align="right"><font class="smalltext" color="666666">Copyright &copy; 2004, The Bowdoin Orient</font></p>



   </td>
  </tr>
</table>


</body>
</html>

<script>
function EvalSound(soundobj) {
  var thissound= eval("document."+soundobj);
  thissound.Play();
}
</script>
<embed src="grape.wav" autostart=false hidden=true name="sound1" enablejavascript="true">
<embed src="bonus.wav" autostart=false hidden=true name="sound2" enablejavascript="true">