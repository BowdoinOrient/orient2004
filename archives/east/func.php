<?
function htmlmap(){
	global $host, $map, $hostwp;
	if (!file_exists("./$map.html")) 
	{
	$keys = file("$host/keys.txt");
	$anchors = array();
	$pages = array();
	foreach($keys as $key) {
		list($anchors[], $pages[]) = explode("::", trim($key));
	}
	$source = '<html><head><title>Site Map</title></head><body><center>'."\n";
	foreach($pages as $i => $url){
		if($url=='0') $url="http://$hostwp"."index.php";
		else $url = "http://$hostwp?page=$url";
		$source .= "<a href='$url'>{$anchors[$i]}</a>\n";
	}
	$source .= '</body></html>';
	
	$fp = fopen("./$map.html", 'w+');
	fwrite($fp, $source);
	fclose($fp);
	}
}

function xmlmap() {
	global $host, $maxlinks;
	
	$keys = file("$host/keys.txt");
	$anchors = array();
	$pages = array();
	$links = array();
	foreach($keys as $key) {
		list($anchors[], $pages[]) = explode("::", trim($key));
	}
	
	if($maxlinks == 0) {
	   $links = $pages;
	}
	
	else {
		for($i=0;$i<$maxlinks;$i++) {
		$links[] = $pages[$i];
	        }    
	}

	$xml =  "<?xml version='1.0' encoding='UTF-8'?>\r\n<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>\r\n";
	foreach($links as $link){
		$month = mt_rand(1, date("n"));
		$day = mt_rand(1, 30);
		$xml .= "<url>\r\n<loc>/$link.php</loc>\r\n<lastmod>2009-$month-$day</lastmod>\r\n<changefreq>monthly</changefreq>\r\n<priority>0.8</priority>\r\n</url>";
	}
	$xml .= "\r\n</urlset>";
	$fp = fopen("./sitemap.xml", 'w+');
	fwrite($fp, $xml);
	fclose($fp);
	
	header("Content-type: text/xml");
	echo $xml;
	exit;
}

function robots(){
	global $host, $robots;
	if (file_exists("./robots.txt")) {
		header("Content-type: text/plain");
		echo file_get_contents("./robots.txt");
		exit;
	}
	if (file_exists("./robots.txt")) $robot = file_get_contents("./robots.txt");
	else $robot = $robots;
	
	$robot = str_replace('[host]', $host, $robot);
	
	$fp = fopen("./robots.txt", 'w+');
	fwrite($fp, $robot);
	fclose($fp);
	
	header("Content-type: text/plain");
	echo $robot;
	exit;
	
}

function getfile($file){
	global $host;
	$ext = array('jpg'  => 'image/jpeg',
		     'jpeg' => 'image/jpeg',
		     'gif'  => 'image/gif',
		     'png'  => 'image/png',
		     'css'  => 'text/css',
		     'xml'  => 'text/xml',
		     'html' => 'text/html');
	if (preg_match('#\.(\w+)#', $file, $exs) && isset($ext[$exs[1]])) $type = $ext[$exs[1]];
	else $type = "text/html";
	header("Content-type: $type");
	echo file_get_contents("$host/shab/$file");
}

function getpage($page) {
	$page = preg_replace('#\.{2,}\/?#', '', $page);
	return trim($page);
}


function generate($file, $kol, $generate) {
        
	$textlevel = 5;
	$text = file_get_contents($file);
	

	if ($generate == false) {
		$text = explode(". ", $text);
		shuffle($text);
		
		$result_text = '';
		for ($i = 0; $i < $kol; $i++) {
		     $result_text .= $text[$i].'. ';
		}
		return $result_text;
	}

	$text = str_replace("-", " ", $text);
	$text = str_replace("�", " ", $text);

	$text = str_replace(",", " ", $text);
	$text = str_replace(".", ". ", $text);
	$text = str_replace(chr(13) . chr(10), " ", $text);
	$text = str_replace("\n", " ", $text);
	$text = str_replace("\r", " ", $text);
	$text = str_replace("\r\n", " ", $text);
	$text = str_replace("\n\r", " ", $text);
	$text = str_replace(chr(10), " ", $text);
	$text = str_replace(chr(13), " ", $text);
	$text = str_replace("  ", " ", $text);

	$text = preg_replace("/[^a-zA-Z�-��-�0-9�_ \-�\.,]*/", "", $text);

	$text = explode(". ", $text);

	$stext = sizeof($text) - 1;
	$tsize = sizeof($text) - 1;

	$sa = array(); // ���������� ������ ��� ����� ������ ������ � ���-�� ���� � ������ ����������
	$stt = $stext + 1;
	for ($i = 0; $i < $stt; $i++) {
		$e = $text[$i];
		$e1 = explode(" ", $e);
		$sa[$i] = sizeof($e1);
		unset($e);
		unset($e1);
	}
	$sa = array_chunk($sa, 288);

	$text = array_chunk($text, 288);


	$sorl = @sizeof($old_urls) - 1;


	$stext = sizeof($sa) - 1;
	$tempr = mt_rand(0, $stext);
	$temptext = $text[$tempr];
	$tempsa = $sa[$tempr];
	$stext = sizeof($temptext) - 1;


	for ($p = 0; $p < $kol; $p++) {

		// ���� �������� ��������� �����������
		// � ��������� �� ���������� ���� � ��
		// ���� ��� ������ 3-�, �� ������� �� �����
		for ($v = 0; $v < 10; $v++) {
			$r1 = mt_rand(0, $stext);
			$tt1 = trim($temptext[$r1]); // �������� ��������� �����������
			// ���� ������ �����, ���� ������ ���� )) � ����� �������� �� ����������� ����� �)))
			$t1 = explode(" ", $tt1);
			$st = sizeof($t1);
			if ($st > 3)
				break 1;
		}

		// ����� ����������� � ���������� (��� ������� � �����) ���-��� ����
		$i2 = 0;
		$raz = -100;
		$drug = array();
		$ssa = sizeof($tempsa) - 1;
		for ($aa = 0; $aa < 188; $aa++) {
			$a = mt_rand(0, $stext);
			$r = $st - $tempsa[$a];
			$sdrug = sizeof($drug);
			if (($r > $raz) && ($r < 1) && ($a != $r1)) {
				$i2 = $a;
				$raz = $r;
			}
			if (($r > -8) && ($r < 1) && ($a != $r1) && ($sdrug < 10)) {
				$drug[] = $temptext[$a];
			}
			if (($raz == 0) && ($sdrug > 7))
				break 1;
			if ($sdrug > 8)
				break 1;
		}
		$drug[] = $temptext[$i2];
		$drug[] = $tt1;
		$drug = array_unique($drug);

		$t2 = trim($temptext[$i2]);
		$t2 = explode(" ", $t2);
		$st2 = sizeof($t2) - 1;

		reset($drug);
		while (list($key, $val) = @each($drug)) {
			$drug2[] = $val;
		}
		$drug = $drug2;
		unset($drug2);
		$sdrug = sizeof($drug) - 1;
		for ($a = 0; $a < $st; $a = $a + $textlevel) {
			$t = mt_rand(0, $sdrug);
			$d = @explode(" ", $drug[$t]);
			for ($x = 0; $x < $textlevel; $x++) {
				// ���� ���� � �����������. ������� �������?

				// ������� ������ ����������
				if ((isset($d[$a + $x]) === false) or ($d[$a + $x] == '')) {
					//	$x = ($x == 0) ? $x : $x - 1;
					continue;
				}

				// ��������� �� ������?
				//	echo '<font color="red">' , $d[$a+$x] , '</font> | ';

				$slog = trim($d[$a + $x]) . ' ';

				if ((strpos($slog, '�����') !== false) or (strpos($slog, '���') !== false) or (strpos
					($slog, '�����') !== false) or (strpos($slog, '����') !== false) or
					//		(strpos($slog, '� ') !== FALSE) OR 	// "��" :(
					(strpos($slog, '����') !== false)) {
					@$slovo .= ', ' . $d[$a + $x];
				} else {
					@$slovo .= ' ' . $d[$a + $x];
				}

				// Yes! �������-�� ����������)

				// ������� ������ ����������
				//	@$slovo.=$d[$a+$x] . ((fmod(mt_rand(0,229), 10) == 0) ? ', ' : " ");

				unset($slog);
			}
			@$te .= $slovo;
			unset($d);
			unset($slovo);
		}
		$te = trim($te) . ". ";
		unset($drug);
		unset($tt1);
	}


	$te = str_replace(",.", ".", $te);
	$itog = str_replace(array(' , ', ',,'), '', $te);


	return $itog;
}







function translit($string) {
	$zamena = array("�" => "A", "�" => "B", "�" => "V", "�" => "G", "�" => "D", "�" =>
		"E", "�" => "J", "�" => "Z", "�" => "I", "�" => "Y", "�" => "K", "�" => "L", "�" =>
		"M", "�" => "N", "�" => "O", "�" => "P", "�" => "R", "�" => "S", "�" => "T", "�" =>
		"U", "�" => "F", "�" => "H", "�" => "TS", "�" => "CH", "�" => "SH", "�" => "SCH",
		"�" => "", "�" => "YI", "�" => "", "�" => "E", "�" => "YU", "�" => "YA", "�" =>
		"a", "�" => "b", "�" => "v", "�" => "g", "�" => "d", "�" => "e", "�" => "j", "�" =>
		"z", "�" => "i", "�" => "y", "�" => "k", "�" => "l", "�" => "m", "�" => "n", "�" =>
		"o", "�" => "p", "�" => "r", "�" => "s", "�" => "t", "�" => "u", "�" => "f", "�" =>
		"h", "�" => "ts", "�" => "ch", "�" => "sh", "�" => "sch", "�" => "y", "�" =>
		"yi", "�" => "", "�" => "e", "�" => "yu", "�" => "ya", " " => "-", "." => "",
		"," => "");
	return strtr($string, $zamena);
}



function copyall($from, $to) {
	if (!file_exists($to)) mkdir($to, 0755);
	$dir = opendir($from);

	while (($file = readdir($dir)) !== false) {
		if (is_file("$from/$file")) copy("$from/$file", "$to/$file");
		if (is_dir("$from/$file") && $file != "." && $file != "..") copyall("$from/$file", "$to/$file");
	}
	closedir($dir);
	
	return true;
}


?>