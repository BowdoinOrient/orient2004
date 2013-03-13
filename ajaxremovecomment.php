<?php
include("template/top.php");
$date = mysql_real_escape_string($_POST['date']);
$id = mysql_real_escape_string($_POST['priority']);
$section = mysql_real_escape_string($_POST['section']);
$comment = mysql_real_escape_string($_POST['commentID']);
$password = mysql_real_escape_string($_POST['pwd']);
$adminPassword = getSetting("password");

if ($password != $adminPassword) {
	echo "Error: Password is incorrect.";
	exit;
}
$query = "SELECT * FROM comment WHERE id=$comment";
$row = mysql_fetch_array(mysql_query($query));
if ($row['article_date'] == $date and $row['article_section'] == $section and $row['article_priority'] == $id) {
	$query = "UPDATE  comment SET deleted='y' WHERE id=$comment LIMIT 1";
	if (mysql_query($query)) {
		echo $comment;
	} else {
		echo "Error: unable to delete comment.";
	}
} else {
	echo "Error: parameters seem fishy.";
}
?>