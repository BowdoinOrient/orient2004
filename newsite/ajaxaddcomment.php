<?php
include("template/top.php");
$date = mysql_real_escape_string($_POST['date']);
$id = mysql_real_escape_string($_POST['id']);
$section = mysql_real_escape_string($_POST['section']);
$username = mysql_real_escape_string($_POST['username']);
$email = mysql_real_escape_string($_POST['email']);
$comment = str_replace("\n","<br />",htmlspecialchars(mysql_real_escape_string($_POST['comment'])));
$password = mysql_real_escape_string($_POST['password']);

// For the moment, you need to log in with a valid Bowdoin username and password.

if (!$comment) {
	echo "Please enter a comment.";
	exit;
}

if (!$username) {
	echo "Please enter your username.";
	exit;
}

if (!$password) {
	echo "Please enter your password.";
	exit;
}

// Make sure it's a valid article - this really shouldn't ever be a problem unless someone's doing something fishy
$articleQuery = 
	"SELECT
		*
	FROM
		article
	WHERE
		date = '$date' AND
		section_id='$section' AND 
		priority = '$id'
	";
$articleResult = mysql_query($articleQuery);
if (mysql_num_rows($articleResult) == 0) {
	echo "There was a problem submitting your comment.  It appears you're trying to submit a comment for a non-existing article.";
	exit;
}

// We don't want duplicate comments, especially since users can't delete their own comments or alter them. ...yet.
$dupeQuery = 
	"SELECT
		comment,
		username
	FROM
		comment
	WHERE
		article_date='$date' AND
		article_section='$section' AND 
		article_priority = '$id'
	";
$dupes = mysql_query($dupeQuery);
while ($row = mysql_fetch_array($dupes)) {
	if ($row['comment'] == $comment and $row['username'] == $username) {
		echo "There was a problem submitting your comment.  It appears to be an exact duplicate of an already existing comment.";
		exit;
	}
}

// Connect to the LDAP server
$ldapConnection = ldap_connect("ldap.bowdoin.edu", 389);
if($ldapConnection) {
	// Attempt to authenticate user against student records in LDAP
	$errorLevel = error_reporting();
	error_reporting(0);
	$ldapBind = ldap_bind($ldapConnection, "uid=".$username.", ou=Students, ou=People, o=Bowdoin College, c=US", $password); 
	error_reporting($errorLevel);
	if($ldapBind) {
		$sr = ldap_search($ldapConnection, "ou=People, o=Bowdoin College, c=US", "uid=".$username);  
		$info = ldap_get_entries($ldapConnection, $sr);
//		print_r($info);
		if($info["count"]!=1) {
			echo "Your username, password, or potentially both were incorrect.  Please try again with a valid Bowdoin ID.";
			exit;
		}

		ldap_close($ldapConnection);
		// Add comment
		addComment($username, $username . "@bowdoin.edu", $comment, $date, $section, $id);
		exit;

	}
	
	// Attempt to authenticate user against employee records in LDAP
	error_reporting(0);
	$ldapBind = ldap_bind($ldapConnection, "uid=".$username.", ou=Employees, ou=People, o=Bowdoin College, c=US", $password);
	error_reporting($errorLevel);
	if($ldapBind)
	{
		$sr = ldap_search($ldapConnection, "ou=People, o=Bowdoin College, c=US", "uid=".$username);  
		$info = ldap_get_entries($ldapConnection, $sr);
		if($info["count"]!=1)
		{
			echo "Your username, password, or potentially both were incorrect.  Please try again with a valid Bowdoin ID.";
			exit;
		}
		
		ldap_close($ldapConnection);
		addComment($username, $username . "@bowdoin.edu", $comment, $date, $section, $id);
		exit;
	}

	echo "Your username, password, or potentially both were incorrect.  Please try again with a valid Bowdoin ID.";
	exit;
}


function addComment($username, $email, $comment, $date, $section, $id) {
	$commentSecret = rand(0, 1000);
	$commentQuery = 
		"INSERT INTO
			comment
			(`article_date`, `article_section`, `article_priority`, `username`, `email`, `comment`, `secret`, `comment_date`)
		VALUES
			('$date', '$section', '$id', '$username', '$email', '$comment', '$commentSecret', NOW())
		";
	if ($results = mysql_query($commentQuery)) {
		$commentID = mysql_insert_id();
		$message = "A comment has been added.\nAuthor: " . stripslashes($username) . "\nThe comment: " . stripslashes($comment) . "\nYou can read it in context here: http://orient.bowdoin.edu/orient/newsite/" . articleLink($date, $section, $id) . " .\n";
		$subject = "Orient Comment Report";
		$from = "From: OrientBot <orient@bowdoin.edu>";
		$to = "seth.glickman@bowdoin.edu, seth.glickman@gmail.com, cybertaur1@gmail.com, adamkommel@gmail.com, orient@bowdoin.edu";
		mail($to, $subject, $message, $from);
		echo "Success: $commentID,$commentSecret";
	} else {
		echo "There was a problem submitting your comment.  Please try again.";
	}
}

?>