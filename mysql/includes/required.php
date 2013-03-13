<?PHP
error_reporting(E_ALL ^ E_NOTICE);

defined('_VALID_INCLUDE') or die(header("Location: ../index.php"));

define("VERSION","1.5.5"); //Do not change this!

require("config.php");

if(!empty($_COOKIE['language']) && !isset($_SESSION['language'])){
	$_SESSION['language'] = $_COOKIE['language'];
}
if(!empty($_COOKIE['theme']) && !isset($_SESSION['theme'])){
	$_SESSION['theme'] = $_COOKIE['theme'];
}

if(LANG == ""){
	if(!isset($_SESSION['language'])){
		include("lang/english/lang.php");
		$_LANG = "english";
	} else {
		include("lang/".$_SESSION['language']."/lang.php");
		$_LANG = $_SESSION['language'];
	}
} else {
	if(file_exists("lang/".strtolower(LANG)."/lang.php")){
		include("lang/".strtolower(LANG)."/lang.php");
		$_LANG = LANG;
	} else {
		include("lang/english/lang.php");
		$_LANG = "english";
	}
}
require("checklang.php");

if(isset($_SESSION['theme'])){
	$_THEME = $_SESSION['theme'];
} else {
	$_THEME = _THEME;
	$_THEME = (!empty($_THEME))?$_THEME:"smooth";
}

function xml2array($xml){
	$xmlary = array();

	if ((strlen($xml) < 256) && is_file($xml))
		$xml = file_get_contents($xml);
 
	$ReElements = '/<(\w+)\s*([^\/>]*)\s*(?:\/>|>(.*)<\/\s*\\1\s*>)/s';
	$ReAttributes = '/(\w+)=(?:"|\')([^"\']*)(:?"|\')/';
 
	preg_match_all($ReElements, $xml, $elements);
	foreach($elements[1] as $ie => $xx){
	$xmlary[$ie]["name"] = $elements[1][$ie];
		if ($attributes = trim($elements[2][$ie])) {
			preg_match_all($ReAttributes, $attributes, $att);
			foreach ($att[1] as $ia => $xx)
			// all the attributes for current element are added here
				$xmlary[$ie]["attributes"][$att[1][$ia]] = $att[2][$ia];
		} // if $attributes
		
		// get text if it's combined with sub elements
		$cdend = strpos($elements[3][$ie], "<");
		if ($cdend > 0) {
			$xmlary[$ie]["text"] = substr($elements[3][$ie], 0, $cdend-1);
		} // if cdend
		  
		if (preg_match($ReElements, $elements[3][$ie]))       
			$xmlary[$ie]["elements"] = xml2array($elements[3][$ie]);
		else if ($elements[3][$ie]){
			$xmlary[$ie]["text"] = $elements[3][$ie];
		}
	}
	
	return $xmlary;
}
if(empty($_SESSION['theme_name'])){
	$xml = "themes/".$_THEME."/theme.xml";
	if(file_exists($xml)){
		$xml = file_get_contents($xml);
		$xmlary = xml2array($xml);
		foreach($xmlary[0]['elements'] as $element){
			if($element['name'] == 'name'){
				$theme_name = $element['text'];
			}
		}
		$_SESSION['theme_name'] = (!empty($theme_name))?$theme_name:"Set Theme";
	} else {
		$_SESSION['theme_name'] = "Set Theme";
	}
}
if(empty($_SESSION['lang_name'])){
	$xml = "lang/".$_LANG."/lang.xml";
	if(file_exists($xml)){
		$xml = file_get_contents($xml);
		$xmlary = xml2array($xml);
		foreach($xmlary[0]['elements'] as $element){
			if($element['name'] == 'name'){
				$lang_name = $element['text'];
			}
		}
		$_SESSION['lang_name'] = (!empty($lang_name))?$lang_name:"Set Language";
	} else {
		$_SESSION['lang_name'] = "Set Language";
	}
}

define("MYSQL_USER",(AUTH == 'config')?$_mysql_user:$_SESSION['username']);
define("MYSQL_PASS",(AUTH == 'config')?$_mysql_pass:$_SESSION['password']);
define("MYSQL_HOST",(AUTH == 'config')?$_mysql_host:$_SESSION['host']);

if(ONLINE == 0){
	$_SESSION['error'] = MQA_OFFLINE_ERROR_TEXT;
	
	if(strrpos($_SERVER['PHP_SELF'],"error.php") === false) header("Location: error.php");
}
?>