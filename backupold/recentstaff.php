<?php
include("start.php");
startcode("The Bowdoin Orient - Staff and Writers", false, false, $articleDate, $issueNumber, $volumeNumber);

$lastVolQuery = "SELECT id, numeral FROM volume ORDER BY id DESC LIMIT 0,1";
$lastVolResults = mysql_query($lastVolQuery);
$lastVolumeID = mysql_result($lastVolResults, 0, "id");
$lastVolumeNumeral = mysql_result($lastVolResults, 0, "numeral");

?>

            <p><font class="textbold">Current Staff Pages</font></p>
			<p><font class="text">This is a list of everyone who has contributed to the Volume <b><?php echo $lastVolumeNumeral;?></b> of <i>The Orient</i> (the most recent volume).  If you do not see the name you are looking for, you can try the <a href="fullstaff.php">Full Contributor Page</a>, or the <a href="search.php">search page</a>.</p>
            
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr valign="top"> 
    <td><p align="left"><font class="text">
<?php

$sqlQuery = "
	select
		author.name,
		author.id
	from
		author,
		article,
		issue
	where
		name != '' and
		article.date = issue.issue_date and
		issue.volume_id = $lastVolumeID
		and (article.author1 = author.id or article.author2 = author.id or article.author3 = author.id) and
		active = 'y'
	GROUP BY 
		author.id
	order by
		name
";
$result = mysql_query($sqlQuery);
while($row = mysql_fetch_array($result)) {
	$authorName = $row["name"];
	$authorID = $row["id"];
?>
        <a href="authorpage.php?authorid=<?php echo $authorID ?>"><?php echo $authorName ?></a><br />
<?php
}
?>
</font></p></td>
  </tr>
</table>


<?php
include("stop.php");
?>