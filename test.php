<?php
include("dbconnect.php");
include("template/functions.php");
$r = getSectionArticles(1, "2009-01-23");
	$query = 
	"SELECT
		section_id,
		priority,
		a1.name AS author1,
		a2.name AS author2,
		a3.name AS author3,
		job.name AS jobname,
		article.title,
		article.pullquote,
		series.name AS series,
		articletype.name AS type
	FROM
		article
	INNER JOIN job ON article.author_job = job.id
	INNER JOIN series ON article.series = series.id
	INNER JOIN articletype ON article.type = articletype.id
	INNER JOIN author a1 ON article.author1 = a1.id
	INNER JOIN author a2 ON article.author2 = a2.id
	INNER JOIN author a3 ON article.author3 = a3.id
	WHERE article.date = '2009-01-23' ";
	if ($noneditorials) {
		$query .= "AND article.type != '2' ";
	}
	$query .= 
	"AND article.section_id = 1
	ORDER BY article.priority
	";
//	$r = mysql_query($query);
//	echo $query;
	$r = mysql_query("SELECT * FROM article WHERE date='2009-01-23' AND article.section_id=1");

while ($row = mysql_fetch_array($r)) {
	print_r($row);
	echo "<br /><br /><br />";
}
?>