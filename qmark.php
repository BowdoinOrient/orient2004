<?php
include("template/top.php");
$title = "Broken Text";
startPage();
?>

<!-- Side Links (3 blocks) -->
<div class='span-3 menudiv'>
	<?php include("template/mainlinks.php"); ?>
	<div class='spacer'>
	</div>

	<?php include("template/events.php"); ?>
	<div class='spacer'>
	</div>

	<?php include("template/otherlinks.php"); ?>
</div>

<!-- The rest of the page is to the right of the link bar -->
<div class='span-21 last'>
	<div class='span-16 information'>
		<h2 class='articlesection'>Question marks.</h2>

		<h3 class='articletitle'>?[0-9a-zA-Z]</h3>
		
		<?php

include("start.php");
$query = <<<EOT
SELECT
	CONCAT("http://orient.bowdoin.edu/orient/article.php?date=", date, "&section=", section_id, "&id=", priority) AS url,
	title
FROM
	article
WHERE
	title RLIKE "\\\?[0-9a-zA-Z]([^a]|a[^t]|at[^e])" OR
	subhead RLIKE "\\\?[0-9a-zA-Z]([^a]|a[^t]|at[^e])" OR
	pullquote RLIKE "\\\?[0-9a-zA-Z]([^a]|a[^t]|at[^e])" OR
	text RLIKE "\\\?[0-9a-zA-Z]([^a]|a[^t]|at[^e])"
ORDER BY date
EOT;

$res = mysql_query($query);
// echo $query . " results: " . mysql_num_rows($res);
echo "<ol>";
while ($r = mysql_fetch_array($res)) {
	echo "<li><a href='" . $r['url'] . "'>" . $r['title'] . "</a></li>";
}
echo "</ol>";
?>
	</div>
	
	<div class='span-5 last'>
		<?php include("template/currentorient.php"); ?>
	</div>
</div>
<?php include("template/footer.php"); ?>
</div>

<?php include("template/bottom.php"); ?>