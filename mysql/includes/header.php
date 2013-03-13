<?PHP
session_start();
ob_start();

define('_VALID_INCLUDE', TRUE);

if(isset($_SESSION['backup_export_to'])){
	if($_SESSION['backup_export_to'] == "file"){
		header('Content-Type: application/octetstream');
		header('Content-Disposition: filename="backup.sql"');
		echo $_SESSION['backup_sql'];
		unset($_SESSION['backup_export_to']);
		unset($_SESSION['backup_sql']);
		exit;
	}
}

require("includes/required.php");

$connection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
if(!$connection){
	$_SESSION['mysql_error'] = mysql_error();

	if(AUTH == 'config'){
		header("Location: error.php");
	} else {
		header("Location: login.php");
	}
}

$db_list = @mysql_list_dbs($connection);

function checkPrimary(){
	$get_indexes = "SHOW INDEX FROM `".$_SESSION['table']."`";
	$result = @mysql_query($get_indexes);
	while($row = mysql_fetch_assoc($result)){
		if($row['Key_name'] == "PRIMARY"){
			return true;
		}
	}
	return false;
}
function StripMagicQuotes($arr) { 
  reset($arr); 
  while(list($key,$value) = each($arr) ) { 
    if(is_array($value)) { 
      $arr[$key] = StripMagicQuotes($value); 
    } else { 
      if(is_string($value)) 
        $arr[$key] = stripslashes($value); 
    } 
  } 
  return $arr; 
}
if(get_magic_quotes_gpc() > 0) { 
  $_POST = StripMagicQuotes($_POST); 
  $_GET = StripMagicQuotes($_GET); 
}
function stringIt($var){
	$new_var = (ini_get("magic_quotes_gpc") == 1 || ini_get("magic_quotes_gpc") == "on" || get_magic_quotes_gpc() > 0)?stripslashes($var):$var;
	$new_var = htmlspecialchars($new_var);
	return $new_var;
}
function stringItvTwo($var){
	$new_var = (ini_get("magic_quotes_gpc") == 1 || ini_get("magic_quotes_gpc") == "on" || get_magic_quotes_gpc() > 0)?stripslashes($var):$var;
	$new_var = urlencode($new_var);
	return $new_var;
}
?>