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

	$issue_date = $_GET["issue_date"];
	$section = $_GET["section"];
	
	$issue_result = mysql_query("
		select
			date_format(issue.issue_date, '%b %e, %Y') as date,
			issue.issue_number,
			volume.numeral
		from issue
		inner join volume on issue.volume_id = volume.id
		where issue.issue_date = '$issue_date'
	");

	if($issue = mysql_fetch_assoc($issue_result)) 
	{
		$issue_date_formatted = $issue["date"];
		$issue_number = $issue["issue_number"];
		$volume_numeral = $issue["numeral"];
	}
	
?>

<issue>
	<date><?=$issue_date?></date>
	<date_formatted><?=$issue_date_formatted?></date_formatted>
	<issue_number><?=$issue_number?></issue_number>
	<volume_numeral><?=$volume_numeral?></volume_numeral>
	<section><?=$section?></section>
	
	<?php
	
	$articles = mysql_query("
			select
				section_id,
				priority,
				a1.name as author1,
				a2.name as author2,
				a3.name as author3,
				job.name as jobname,
				article.title,
				article.pullquote,
				series.name as series,
				articletype.name as type,
				section.name as sectionName
			from 
				article
			inner join job on article.author_job = job.id
			inner join series on article.series = series.id
			inner join articletype on article.type = articletype.id
			inner join author a1 on article.author1 = a1.id
			inner join author a2 on article.author2 = a2.id
			inner join author a3 on article.author3 = a3.id
			inner join section on article.section_id = section.id
			where article.date = '$issue_date'
			and section_id = '$section'
			order by article.section_id, article.priority
		") or die(mysql_error());
	
	while($article = mysql_fetch_assoc($articles))
	{
		
		$hasThumbnail = FALSE;
		$thumbnailquery = 
			"SELECT 
				thumb_filename
			FROM
				photo
			WHERE
				article_section = '".$article["section_id"]."' AND
				article_date = '$issue_date' AND
				article_priority = '".$article["priority"]."'
			";
		$thumbResult = mysql_query($thumbnailquery);
		if ($row = mysql_fetch_array($thumbResult)) {
			$thumbFilename = $row['thumb_filename'];
			$hasThumbnail = TRUE;
		}
		
		?>
			
		<article id="<?=$article["priority"]?>">
			<title><?=$article["title"]?></title>
			<author><?=$article["author1"]?></author>
			<thumb><?php if($hasThumbnail) echo "http://orient.bowdoin.edu/orient/images/".$issue_date."/".$thumbFilename; ?></thumb>
			<summary>
				<?=$article["pullquote"]?>
			</summary>
		</article>
		
		<?php
	}
	?>
	

</issue>