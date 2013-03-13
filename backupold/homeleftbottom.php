<?php #PDF start
if(strcmp($ignoreHomeLink,"no")!=0) {
?>

<?php
$sqlQuery1 = "select issue_date from `issue` where ready='y' order by  `VOLUME_ID` desc, `ISSUE_NUMBER` desc";
$res1 = mysql_query ($sqlQuery1);
if ($row1 = mysql_fetch_array($res1)) {
	$currentDate1 = $row1["issue_date"];
}
else {
include("error.php");
}
?>
<div align="center">
<!--
<img src="/orient/images/frontpage.jpg"><p>
<a href="/orient/related/<?php echo $currentDate1 ?>/frontpage.pdf"><img src="/orient/related/<?php echo $currentDate1 ?>/minifrontpage.jpg" border="1" class="thumb"></a><p><font class="pdf"><a class="pdf" href="/orient/related/<?php echo $currentDate1 ?>/frontpage.pdf">View in PDF Format</a></font><br>
<font class="adobereader">(<a class="adobereader" href="http://www.adobe.com/products/acrobat/readermain.html">requires Adobe Reader</a>)</font><br>

</p> 
<hr border=0 width=100&>
-->
<p align="center">

<img src="/orient/images/weathercenter.jpg"><p>
<a href="http://www.weatherforyou.com/weather/Maine/Brunswick.html"><img src="http://www.weatherforyou.net/fcgi-bin/hw3/hw3.cgi?config=png&forecast=hourly&place=Brunswick&state=me&alt=hwihourlyvert2&hwvbg=transparent&hwvtc=black" border="0" width="95" height="135"></a>
</p>

              
</div>

<?php #PDF end
}
?>