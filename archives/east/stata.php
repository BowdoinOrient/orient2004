<?php 
header("Content-Type:text/html;charset=windows-1251");
if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER']!='stats' || $_SERVER['PHP_AUTH_PW']!='stats')
   {
   header("WWW-Authenticate: Basic realm=\"[Adminka]\"");
   header("HTTP/1.0 401 Unauthorized");
   exit("<b>Access Denied</b>");
   }
  print "<html>\n";
  print "<style type=\"text/css\">  .stil1 {	font-size: small  }\n";
  print ".stil2 {	color: red  }\n";
  print ".stil3 {	color: #FFFF66  }\n";
  print ".stil4 {	color: white }\n";
  print "a {	color: #FFFF99; text-decoration: none;} </style>\n";
  print "<body class=\"stil1\" bgcolor=\"#333333\">\n";
 // print "<font  color =\"red\">\n";
  print "<a href=?mode=bots>Bots</a>||";
  print "<a href=?mode=human>Humans</a>||";
  print "<a href=?mode=noref>All Rest</a><br>\n";
$mode=isset($_POST[mode]) ? $_POST[mode] : $_GET[mode];  
switch ($mode)
{
  case 'bots':      
    if (file_exists('bots.data'))
    {
    	$file =fopen('bots.data','r');
    	if ($file)
    	{
    		while (!feof($file))
    		{
    			$str = explode('|',fgets($file));
    			print_data($str[0],$str[1],$str[2],$str[3],$str[4]);
    		}
    		fclose($file);
    	}
    }
    break;
  case 'human':
    if (file_exists('human.data'))
    {
        $file =fopen('human.data','r');
    	if ($file)
    	{
    		while (!feof($file))
    		{
    			$str = explode('|',fgets($file));
    			print_data($str[0],$str[1],$str[2],$str[3],$str[4]);
    		}
    		fclose($file);
    	}
    }
  	break;
  case 'noref':
    if (file_exists('noref.data'))
    {
       $file =fopen('noref.data','r');
    	if ($file)
    	{
    		while (!feof($file))
    		{
    			$str = explode('|',fgets($file));
    			print_data($str[0],$str[1],$str[2],$str[3],$str[4]);
    		}
    		fclose($file);
    	}
    }
  	break;
  }
  print "</body>";
  print "</html>";
  
  function print_data($dtime11,$ip11,$agent11,$uri11,$ref11)
  {
    print "<span class='stil2'>$dtime11</span>-IP:<span class='stil3'>
           $ip11</span>|Agent:<span class='stil4'>$agent11</span>|URL:<span class='stil2'>
           $uri11</span>|Referrer:<a href='$ref11'' target='_blank'>
           $ref11</a>".'<br>'."\n";
  }
?>