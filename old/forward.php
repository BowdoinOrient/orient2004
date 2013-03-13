<?php
if(strcmp($_GET["url"], "") != 0) {
	# Have url argument
	$forwardLocation = $_GET["url"];
}
else { if(strcmp($forwardLocation, "") == 0) {
	$forwardLocation = "http://orient.bowdoin.edu/orient/error.php";
}}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="refresh" content="0;URL=<?php echo $forwardLocation ?>">
</head>

<body bgcolor="#FFFFFF"> 
</body>
</html>
