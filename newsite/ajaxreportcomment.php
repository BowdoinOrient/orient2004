<?php
include("template/top.php");
$date = mysql_real_escape_string($_POST['date']);
$id = mysql_real_escape_string($_POST['priority']);
$section = mysql_real_escape_string($_POST['section']);
$comment = mysql_real_escape_string($_POST['commentID']);

$query = "SELECT * FROM comment WHERE id=$comment";
$row = mysql_fetch_array(mysql_query($query));

if ($row['article_date'] == $date and $row['article_section'] == $section and $row['article_priority'] == $id) {
	$message = "A comment has been reported offensive.\nAuthor: " . stripslashes($row['username']) . "\nThe comment: " . stripslashes($row['comment']) . "\nYou can read it in context here: http://orient.bowdoin.edu/orient/newsite/" . articleLink($date, $section, $id) . " .\nIf you find it offensive, go to http://orient.bowdoin.edu/orient/newsite/" . commentLink($date, $section, $id) . " to moderate comments for this article.";
	$subject = "Orient Comment Report";
	$from = "From: OrientBot <orient@bowdoin.edu>";
	$to = "seth.glickman@bowdoin.edu, seth.glickman@gmail.com, cybertaur1@gmail.com, adamkommel@gmail.com, orient@bowdoin.edu";
	if (mail($to, $subject, $message, $from)) {
		echo "Sent!";
	} else {
		echo "Not sent!";
	}
	
} else {
	echo "PROBLEM";
	print_r($query);
	print_r($row);
}
?>