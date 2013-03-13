<?php
session_start();

// If there isn't a redirect specified, then route them to index.php?action=current, where they will be taken to the current poll.
$redirect = "index.php?action=current";
if ($_GET['redirect']) {
	$redirect = $_GET['redirect'];
}

if ($_SESSION['username']) {
	header("Location: $redirect");
	exit;
}
// If they tried to log in
if ($_POST['submit']) {
	$username = $_POST['Field0'];
	$password = $_POST['Field1'];
	if ($username == '' || $password == '') {
		header("Location: login.php?status=missing&redirect=" . $_GET['redirect']);
		exit;
	}

	// Connect to the LDAP server
	$ldapConnection = ldap_connect("ldap.bowdoin.edu", 389);
	if($ldapConnection)
	{
		// Attempt to authenticate user against student records in LDAP
		$errorLevel = error_reporting();
		error_reporting(0);
		$ldapBind = ldap_bind($ldapConnection, "uid=".$username.", ou=Students, ou=People, o=Bowdoin College, c=US", $password); 
		error_reporting($errorLevel);
		if($ldapBind)
		{
			$sr = ldap_search($ldapConnection, "ou=People, o=Bowdoin College, c=US", "uid=".$username);  
			$info = ldap_get_entries($ldapConnection, $sr);
//			print_r($info);
			if($info["count"]!=1)
			{
				header("Location: login.php?status=ldapincorrect&redirect=$redirect");
				exit;
			}

			$_SESSION['username'] = $username;
			ldap_close($ldapConnection);
			header("Location: $redirect");
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
				header("Location: login.php?status=ldapincorrect&redirect=$redirect");
				exit;
			}
			
			$_SESSION['username'] = $username;
			ldap_close($ldapConnection);
			header("Location: $redirect");
			exit;
		}

		header("Location: login.php?status=ldapincorrect&redirect=$redirect");
		exit;
	}
	
	header("Location: login.php?status=ldaperror&redirect=$redirect");
	exit;

}
$status = $_GET['status'];
if ($status == "ldapincorrect") {
	$error = "Incorrect username / password combination.  Please try again.";
}

if ($status == "missing") {
	$error = "Both username and password are required.";
}

if ($status == "ldaperror") {
	$error = "An error occurred trying to log you in. Please try again.";
}

include("../old/start.php");
startcode("The Bowdoin Orient - Polls Login", false, false, $articleDate, $issueNumber, $volumeNumber);
?>
<link rel="stylesheet" href="wufoo.css" type="text/css" />
<div id="container">

<h1 id="logo"><a>Orient Polls Login</a></h1>

<form id="form1" class="wufoo topLabel" enctype="multipart/form-data" method="POST" action="login.php?redirect=<?php echo $redirect;?>">

<div class="info">
	<h2>Authentication</h2>
	<div>
	<p>
	Please note that although authentication using your Bowdoin username and password is required to prevent duplicate entries, your responses are entirely anonymous.
	</p>
	<p class="error"><?php echo $error; ?></p>
	</div>
</div>

<ul>
	<li id="foli0" class="  ">
	<label class="desc" id="title0" for="Field0">Username</label>
	<div class="column">
		<input id="Field0" name="Field0" class="field text" type="text" tabindex="1" />
	</div>
	</li>
	<li id="foli1" class="  ">
	<label class="desc" id="title1" for="Field1">Password</label>
	<div class="column">
		<input id="Field1" name="Field1" class="field text" type="password" tabindex="2" />
	</div>
	</li>
	<li class="buttons">
		<input id="saveForm" name="submit" class="btTxt" type="submit" value="Log In" />
	</li>
</ul>
</form>
</div>
<?php 
include("../stop.php");
?>