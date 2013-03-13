<?php
include("template/top.php");
$date = mysql_real_escape_string($_POST['date']);
$id = mysql_real_escape_string($_POST['priority']);
$section = mysql_real_escape_string($_POST['section']);
$comment = mysql_real_escape_string($_POST['commentID']);
if (!$date or !$id or !$section or !$comment) {
	echo "Something odd happened.  Please try again.\n";
	$message = "Something odd happened.\ndate: $date\nid: $id\nsection: $section\ncomment: $comment\n\n" . print_r($_SERVER, true);
	$subject = "Orient Comment Report";
	$from = "From: OrientBot <orient@bowdoin.edu>";
	$to = "seth.glickman@bowdoin.edu, seth.glickman@gmail.com, cybertaur1@gmail.com";
	// Disabled until cdlib's crawler stops hitting this page every 15 minutes, sending me emails.  Which might be never.
	// mail($to, $subject, $message, $from);
	exit();
}


$query = "SELECT * FROM comment WHERE id=$comment";
$row = mysql_fetch_array(mysql_query($query));

if ($row['article_date'] == $date and $row['article_section'] == $section and $row['article_priority'] == $id) {
	$message = "A comment has been reported offensive.\nAuthor: " . stripslashes($row['username']) . "\nThe comment: " . stripslashes($row['comment']) . "\nYou can read it in context here: http://orient.bowdoin.edu/orient/" . articleEmailLink($date, $section, $id) . " .\nIf you find it offensive, go to http://orient.bowdoin.edu/orient/" . commentLink($date, $section, $id) . " to moderate comments for this article.";
	$subject = "Orient Comment Report";
	$from = "From: OrientBot <orient@bowdoin.edu>";
	$to = "seth.glickman@bowdoin.edu, seth.glickman@gmail.com, cybertaur1@gmail.com, akommel@bowdoin.edu, orient@bowdoin.edu, akommel@bowdoin.edu";
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