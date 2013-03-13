<?PHP
session_start();
ob_start();

define('_VALID_INCLUDE', TRUE);

require("includes/required.php");

if((!@mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS))){
	if(AUTH == 'login'){
		header("Location: login.php");
	} else {
		$_SESSION['error'] = @mysql_error();

		header("Location: error.php");
	}
} else {
	header("Location: main.php");
}
?>