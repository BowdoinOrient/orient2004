<?php
$sqlQuery = "select issue_date from `issue` where ready='y' order by  `VOLUME_ID` desc, `ISSUE_NUMBER` desc";
$res = mysql_query ($sqlQuery);
if ($row = mysql_fetch_array($res)) {
	$currentDate = $row["issue_date"];
}
else {
include("error.php");
}

?>