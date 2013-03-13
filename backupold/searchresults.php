<?php
	$searchString = strip_tags(trim($_GET["search"]));
	$searchString_escaped = mysql_escape_string($searchString);

	$section = $_GET['section'];
	
	if (!$section) {
		$section = "0";
	}
	
/*
	if(!$searchString) 
	{
		header("Location: search.php");
		exit;
	}

*/
	$sortby = $_GET["sortby"];

	if($sortby == 'date')
		$orderby = 'ar.date desc, ar.title';
	else if($sortby == 'relevance')
		$orderby = 'author1_score desc, author2_score desc, author3_score desc, article_score desc, ar.date desc, ar.title';
	else
	{
		$sortby = 'relevance';
		$orderby = 'author1_score desc, author2_score desc, author3_score desc, article_score desc, ar.date desc, ar.title';
	}

	$page = strip_tags($_GET["page"]);

	if($page && !is_numeric($page) && $page != 'all')
	{
		echo 'The page number provided is not numeric.';
		exit;
	}

	if($page != 'all' && (!$page || $page < 1))
		$page = 1;


	include("start.php");
	startcode("The Bowdoin Orient - Search", false, false, $articleDate, $issueNumber, $volumeNumber);

	$searchString_escaped = str_replace(',','',$searchString_escaped);
	
	$categoryQuery = "";
	
	if ($section != 0 and $section != "" and $section < 7) {
		$categoryQuery = "AND ar.section_id = $section";
	} else if ($section == 7) {
		$categoryQuery = "AND ar.type = 2";
	} else if ($section == 8) {
		$categoryQeury = "AND ar.type = 1";
	}

	$query = "
		select 
			ar.title,
			ar.date,
			date_format(ar.date, '%M %e, %Y') as fancydate,
			ar.section_id,
			ar.priority,
			ar.pullquote,
			j.name as jobname,
			a1.name as authorname1,
			a2.name as authorname2,
			a3.name as authorname3,
			MATCH(ar.title, ar.text) AGAINST('$searchString_escaped') AS article_score,
			MATCH(a1.name) AGAINST('$searchString_escaped') AS author1_score,
			MATCH(a2.name) AGAINST('$searchString_escaped') AS author2_score,
			MATCH(a3.name) AGAINST('$searchString_escaped') AS author3_score
		from 
			article ar,
			author a1,
			author a2,
			author a3,
			job j,
			issue i
		where
			j.id = ar.author_job and
			a1.id = ar.author1 and
			a2.id = ar.author2 and
			a3.id = ar.author3 and
			i.issue_date = ar.date and
			i.ready = 'y' and
			(
				MATCH(ar.title, ar.text) AGAINST('$searchString_escaped') or
				MATCH(a1.name) AGAINST('$searchString_escaped') or 
				MATCH(a2.name) AGAINST('$searchString_escaped') or 
				MATCH(a3.name) AGAINST('$searchString_escaped')
			)
			$categoryQuery
		order by
			$orderby
	";
	

	$search_result = mysql_query($query) or die(mysql_error());
	$search_entries = mysql_num_rows($search_result);

	if($page != 'all' && $search_entries && ($page-1)*10 <= $search_entries)
		mysql_data_seek($search_result,($page-1)*10);
?>
<div id="cse-search-results"></div>
<script type="text/javascript">
  var googleSearchIframeName = "cse-search-results";
  var googleSearchFormName = "cse-search-box";
  var googleSearchFrameWidth = 600;
  var googleSearchDomain = "www.google.com";
  var googleSearchPath = "/cse";
</script>
<script type="text/javascript" src="http://www.google.com/afsonline/show_afs_search.js"></script>


<p><strong><font class="text">If you're not finding what you're looking for, feel free to browse our <a href="/orient/archives.php">archives</a>, 2000-Present.</font></strong></p>
<?php include("stop.php"); ?>