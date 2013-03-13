<?PHP
defined('_VALID_INCLUDE') or die(header("Location: index.php"));

define("ONLINE", 1);
define("_THEME","smooth");			//Define a constant theme. Just enter the theme's folder name.
define("LANG", "");					//Define a constant language. Just enter the name of the language's folder.

//define("AUTH","config");			//Logs into MySQL using the detials entered in this config file
define("AUTH","login");				//Actually allows the user to login and out.

if(AUTH == 'config'){
	$_mysql_user = "";				//Your MySQL username.  Only needed if AUTH equals 'config'
	$_mysql_pass = "";				//Your MySQL password.  Only needed if AUTH equals 'config'
	$_mysql_host = "localhost";		//Your MySQL server address, usually 'localhost'.  Only needed if auth equals 'config'
} else {
	define("ALLOW_REMOTE_ADMIN",1);	//Allows users to login with their own server, username, and password.  Only needed if AUTH equals 'login'

	$_mysql_host = array();
	
	$_mysql_host[] = 'localhost';
	//$_mysql_host[] = '';			//Add as many of these lines as you like.  Entering the server address in the quotes.
}
?>