<?php
# Issue Query
#pre: $date
#post: $articleDate, $issueNumber, $volumeNumber
$sqlQuery = "
	select
		date_format(issue.issue_date, '%M %e, %Y') as date,
		issue.issue_number,
		volume.numeral
	from issue
	inner join volume on issue.volume_id = volume.id
	where issue.issue_date = '$date'
";

$res = mysql_query ($sqlQuery);

if ($row = mysql_fetch_array($res)) {
	$articleDate = $row["date"];
	$issueNumber = $row["issue_number"];
	$volumeNumber = $row["numeral"];
}
function displayIssueAndDate($volumeNumber, $issueNumber, $articleDate) {
?>
<div align="right"><font class="headertext"> 
              <?php echo "Volume $volumeNumber, Number $issueNumber" ?><br>
              <?php echo $articleDate ?>
</font></div>
<?php
}
?>