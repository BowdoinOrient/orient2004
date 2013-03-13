<?php
include("start.php");
#change first false to true gives date
#change second false to true gives "In the current Orient"
startcode("The Bowdoin Orient - Archives", false, false, $articleDate, $issueNumber, $volumeNumber);
?>

<!-- Start -->

           <font class="pagetitle">Archives</font>
<?php
$volumeIDs = mysql_query("SELECT id, numeral FROM volume WHERE id > 2 ORDER BY id ASC");
$year = 2003;

$echoBuffer = "";

while ($volumeID = mysql_fetch_array($volumeIDs)) {
	$pBuffer = "";
	$volID = $volumeID["id"];
	$volNumeral = $volumeID["numeral"];
	$year++;
	$sqlQuery = "
		SELECT
			date_format(issue.issue_date, '%M %e, %Y') as fancydate,
			issue_date,
			volume_id,
			issue_number
		FROM
			issue
		WHERE
			ready = 'y' AND
			volume_id = '$volID'
		ORDER BY
			issue_date DESC
		";
	$result = mysql_query($sqlQuery);
	
	$pBuffer = "<p><font class='textbold'>$year-" . ($year + 1) . ": Volume $volNumeral</font></p><p>";
	while ($row = mysql_fetch_array($result)) {
		$fancyDate = $row["fancydate"];
		$issueDate = $row["issue_date"];
		$pBuffer .= "<font class='text'><a href='issuearchive.php?date=$issueDate'>$fancyDate</a></font><br />";
	}
	$pBuffer .= "</p>";
	$echoBuffer = $pBuffer . $echoBuffer;
}

echo $echoBuffer;

?>

<!-- This code was here before I put in the dynamic archive gatherer... now you don't have to update it every year.  Preserved in case something goes wrong. -->

<!--
<p><font class="textbold">2007-2008: Volume CXXXVII</font></p><p>
<?php

# Archives query

$sqlQuery = "
	select 
		date_format(issue.issue_date, '%M %e, %Y') as fancydate,
		issue_date,
		volume_id,
		issue_number
	from
		issue
	where
		ready = 'y' and
		volume_id = '6'
	order by
		issue_date desc
";

$result = mysql_query($sqlQuery);

while($row = mysql_fetch_array($result)) {
	$fancyDate = $row["fancydate"];
	$issueDate = $row["issue_date"];

?>
            <font class="text"><a href="issuearchive.php?date=<?php echo $issueDate ?>"><?php echo $fancyDate ?></a></font><br>
<?php
}
?>

<p><font class="textbold">2006-2007: Volume CXXXVI</font></p><p>
<?php

# Archives query

$sqlQuery = "
	select 
		date_format(issue.issue_date, '%M %e, %Y') as fancydate,
		issue_date,
		volume_id,
		issue_number
	from
		issue
	where
		ready = 'y' and
		volume_id = '5'
	order by
		issue_date desc
";

$result = mysql_query($sqlQuery);

while($row = mysql_fetch_array($result)) {
	$fancyDate = $row["fancydate"];
	$issueDate = $row["issue_date"];

?>
            <font class="text"><a href="issuearchive.php?date=<?php echo $issueDate ?>"><?php echo $fancyDate ?></a></font><br>
<?php
}
?>

<p><font class="textbold">2005-2006: Volume CXXXV</font></p><p>
<?php

# Archives query

$sqlQuery = "
	select 
		date_format(issue.issue_date, '%M %e, %Y') as fancydate,
		issue_date,
		volume_id,
		issue_number
	from
		issue
	where
		ready = 'y' and
		volume_id = '4'
	order by
		issue_date desc
";

$result = mysql_query($sqlQuery);

while($row = mysql_fetch_array($result)) {
	$fancyDate = $row["fancydate"];
	$issueDate = $row["issue_date"];

?>
            <font class="text"><a href="issuearchive.php?date=<?php echo $issueDate ?>"><?php echo $fancyDate ?></a></font><br>
<?php
}
?>

<p><font class="textbold">2004-2005: Volume CXXXIV</font></p><p>
<?php

# Archives query

$sqlQuery = "
	select 
		date_format(issue.issue_date, '%M %e, %Y') as fancydate,
		issue_date,
		volume_id,
		issue_number
	from
		issue
	where
		ready = 'y' and
		volume_id = '3'
	order by
		issue_date desc
";

$result = mysql_query($sqlQuery);

while($row = mysql_fetch_array($result)) {
	$fancyDate = $row["fancydate"];
	$issueDate = $row["issue_date"];

?>
            <font class="text"><a href="issuearchive.php?date=<?php echo $issueDate ?>"><?php echo $fancyDate ?></a></font><br>
<?php
}
?>

-->


<p><font class="textbold">2003-2004: Volume CXXXIII</font></p><p>
<?php

# Archives query

$sqlQuery = "
	select 
		date_format(issue.issue_date, '%M %e, %Y') as fancydate,
		issue_date,
		volume_id,
		issue_number
	from
		issue
	where
		ready = 'y' and
		volume_id = '2'
	order by
		issue_date desc
";

$result = mysql_query($sqlQuery);

while($row = mysql_fetch_array($result)) {
	$fancyDate = $row["fancydate"];
	$issueDate = $row["issue_date"];

?>
            <font class="text"><a href="issuearchive.php?date=<?php echo $issueDate ?>"><?php echo $fancyDate ?></a></font><br>
<?php
}
?>
			
			<font class="text">
			  
              

              <a href="/orient/archives/2004-03-05/main.htm">March 5, 2004</a><br>
              <a href="/orient/archives/2004-02-27/main.htm">February 27, 2004</a><br>
              <a href="/orient/archives/2004-02-20/main.htm">February 20, 2004</a><br>
              <a href="/orient/archives/2004-02-13/main.htm">February 13, 2004</a><br>
              <a href="/orient/archives/2004-02-06/main.htm">February 6, 2004</a><br>
              <a href="/orient/archives/2004-01-30/main.htm">January 30, 2004</a><br>
              <a href="/orient/archives/2003-12-05/main.htm">December 5, 2003</a><br>
              <a href="/orient/archives/2003-11-21/main.htm"> November 21, 2003</a><br>
              <a href="/orient/archives/2003-11-14/main.htm"> November 14, 2003</a><br>
              <a href="/orient/archives/2003-11-07/main.htm">November 7, 2003</a><br>
              <a href="/orient/archives/2003-10-31/main.htm">October 31, 2003</a><br>
              <a href="/orient/archives/2003-10-24/main.htm">October 24, 2003</a><br>
              <a href="/orient/archives/2003-10-10/main.htm">October 10, 2003</a><br>
              <a href="/orient/archives/2003-10-03/main.htm">October 3, 2003</a><br>
              <a href="/orient/archives/2003-09-26/main.htm">September 26, 2003</a><br>
	      <a href="/orient/archives/2003-09-19/main.htm">September 19, 2003</a><br>
	      <a href="/orient/archives/2003-09-12/main.htm">September 12, 2003</a><br>

            </font></p>
			
			<p><font class="text">For archives before September 12, 2003, <a href="/orient/archives/index.htm#archive">click here</a>.</font></p>



<!-- Stop -->

<?php
include("stop.php");
?>