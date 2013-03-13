<?php 
	
	function encodeXML($string)
	{
		$string = strip_tags($string);
		$string = str_replace('ó', '-', $string);
		$string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
		$string = unhtmlentities($string);
		$string = safe_cr($string);
		$string = str_replace("&amp;", "&", $string);
		
		return $string;
	}
	
	function unhtmlentities($string)
	{
	   // replace numeric entities
	   $string = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $string);
	   $string = preg_replace('~&#([0-9]+);~e', 'chr(\\1)', $string);
	   // replace literal entities
	   $trans_tbl = get_html_translation_table(HTML_ENTITIES);
	   $trans_tbl = array_flip($trans_tbl);
	   return strtr($string, $trans_tbl);
	}
	
	function safe_cr($string){
		$cr = array(
			// http://intertwingly.net/stories/2004/04/14/i18n.html#CleaningWindows
			'&#128;' => '&#8364;',
			'&#129;' => '',
			'&#130;' => '&#8218;',
			'&#131;' => '&#402;',
			'&#132;' => '&#8222;',
			'&#133;' => '&#8230;',
			'&#134;' => '&#8224;',
			'&#135;' => '&#8225;',
			'&#136;' => '&#710;',
			'&#137;' => '&#8240;',
			'&#138;' => '&#352;',
			'&#139;' => '&#8249;',
			'&#140;' => '&#338;',
			'&#141;' => '',
			'&#142;' => '&#381;',
			'&#143;' => '',
			'&#144;' => '',
			'&#145;' => '&#8216;',
			'&#146;' => '&#8217;',
			'&#147;' => '&#8220;',
			'&#148;' => '&#8221;',
			'&#149;' => '&#8226;',
			'&#150;' => '&#8211;',
			'&#151;' => '&#8212;',
			'&#152;' => '&#732;',
			'&#153;' => '&#8482;',
			'&#154;' => '&#353;',
			'&#155;' => '&#8250;',
			'&#156;' => '&#339;',
			'&#157;' => '',
			'&#158;' => '&#382;',
			'&#159;' => '&#376;' );
			
		return strtr($string,$cr);
	}
	
	header("Content-Type: application/xml; charset=UTF-8");
	echo '<?xml version="1.0" encoding="UTF-8" ?>';

	include("dbconnect.php");
	include("getcurrentdate.php");
	
	// romanToArabic written 2001 by Mark Wilton-Jones. Version 1.1.1
	// http://www.howtocreate.co.uk/php/
	// http://www.howtocreate.co.uk/jslibs/termsOfUse.html
	function romanToArabic( $myRomanNum, $htmlelement = '_', $htmlelement2 = '' ) {
		//convert into single characters
		$htmlelement = strtoupper(addslashes($htmlelement));
		$htmlelement2 = strtoupper(addslashes($htmlelement2));
		$myRomanNum = strtoupper($myRomanNum);
		$myRomanNum = str_replace($htmlelement."M".$htmlelement2,"N",$myRomanNum);
		$myRomanNum = str_replace($htmlelement."D".$htmlelement2,"O",$myRomanNum);
		$myRomanNum = str_replace($htmlelement."C".$htmlelement2,"P",$myRomanNum);
		$myRomanNum = str_replace($htmlelement."L".$htmlelement2,"Q",$myRomanNum);
		$myRomanNum = str_replace($htmlelement."X".$htmlelement2,"R",$myRomanNum);
		$myRomanNum = str_replace($htmlelement."V".$htmlelement2,"S",$myRomanNum);
		//prepare Arabic numerals
		$rom_to_ar['N'] = 1000000;
		$rom_to_ar['O'] = 500000;
		$rom_to_ar['P'] = 100000;
		$rom_to_ar['Q'] = 50000;
		$rom_to_ar['R'] = 10000;
		$rom_to_ar['S'] = 5000;
		$rom_to_ar['M'] = 1000;
		$rom_to_ar['D'] = 500;
		$rom_to_ar['C'] = 100;
		$rom_to_ar['L'] = 50;
		$rom_to_ar['X'] = 10;
		$rom_to_ar['V'] = 5;
		$rom_to_ar['I'] = 1;
		$myArabicNum = 0;
		if( isset( $myRomanNum ) && $myRomanNum == '' ) { return 0; }
		//go forever 'till you get it
		for( $x = 0; $x >= 0; $x++ ) {
			//if you get to the end, you have finished
			if( substr($myRomanNum,$x,1) == '' ) { return $myArabicNum; }
			//check for valid characters
			if( $rom_to_ar[substr($myRomanNum,$x,1)] ) {
				//the character is valid. check for valid format, then do we add or delete?
				if( $rom_to_ar[substr($myRomanNum,$x,1)] < $rom_to_ar[substr($myRomanNum,$x+2,1)] && $rom_to_ar[substr($myRomanNum,$x+1,1)] < $rom_to_ar[substr($myRomanNum,$x+2,1)] ) {
					//for example IIX is invalid. so is VIX. so is IVX. they are ambiguous
					//IXI will be allowed as it is not ambiguous. Try to show a better way of writing it.
					return "not convertable, format invalid. Only one lower value character may preceed a higher value character.";
				}
				if( $rom_to_ar[substr($myRomanNum,$x,1)] >= $rom_to_ar[substr($myRomanNum,$x+1,1)] ) {
					//add
					$myArabicNum += $rom_to_ar[substr($myRomanNum,$x,1)];
				} else {
					//delete
					$myArabicNum -= $rom_to_ar[substr($myRomanNum,$x,1)];
				}
			} else {
				return "not convertable, invalid character '".htmlentities(substr($myRomanNum,$x,1))."' used.";
			}
		}
	}
	
	function volToYears($vol) {
		return (1870+$vol)."-".(1871+$vol);
	}
	
?>

<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<dict>
	<key>Rows</key>
	<array>

		<?php
		
		$volumes_result = mysql_query("
			select `id`, `numeral` from volume where `numeral` <> 'CXXXII'
		");
		
		while($volume = mysql_fetch_assoc($volumes_result))
		{
		
		?>
	
		<dict>
			<key>Title</key>
			<string><?="Vol. ".romanToArabic($volume["numeral"])." (".volToYears(romanToArabic($volume["numeral"])).")"?></string>
			<key>Children</key>
			<array>
				
				
				<?php
	
				$volume_result = mysql_query("
					select
						date_format(issue_date, '%b %e, %Y') as date,
						issue_date,
						issue_number
					from issue
					where volume_id = '".$volume["id"]."'
				");
				
				while($issue = mysql_fetch_assoc($volume_result))
				{
				
				?>
				
				<dict>
					<key>Title</key>
					<string>No. <?=$issue["issue_number"]?> (<?=$issue["date"]?>)</string>
					<key>Children</key>
					<array>
						
						
						<?php for ($i = 0; $i < 5; $i++) { ?>
						
						<dict>
							<key>Number</key>
							<string><?=$i?></string>
							<key>Children</key>
							<array>
							
							<?php
	
							$articles = mysql_query("
									select
										section_id,
										priority,
										title
									from 
										article
									where date = '".$issue["issue_date"]."' and section_id = '".($i+1)."' 
									order by section_id, priority 
								") or die(mysql_error());
							
							while($article = mysql_fetch_assoc($articles))
							{
							?>
							
							<dict>
								<key>Title</key>
								<string><?=utf8_encode(htmlspecialchars($article["title"]))?></string>
								<key>Section</key>
								<string><?=($article["section_id"]-1)?></string>
								<key>URL</key>
								<string>http://orient.bowdoin.edu/orient/article_iphone.php?date=<?=$issue["issue_date"]?>&amp;section=<?=$article["section_id"]?>&amp;id=<?=$article["priority"]?></string>
							</dict>
							
							<?php
							}
							?>
							
							</array>
						</dict>
						
						<?php } ?>
						
					</array>
				</dict>
				
				<?php
				}
				?>
				
			</array>
		</dict>
	
		<?php
		}
		?>
	
	</array>
</dict>
</plist>