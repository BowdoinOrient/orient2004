<?php
include('start.php');
$query = "SELECT * FROM issue ORDER BY issue_date DESC LIMIT 0, 2";
$result = mysql_query($query);
echo "Number of ready articles: " . mysql_num_rows($result) . ".";
echo "<pre>";

while ($row = mysql_fetch_array($result)) {
echo $row["title"];
print_r($row);
echo "<br /><br />";
}

echo "</pre>";

include('stop.php');

?>