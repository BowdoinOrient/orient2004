<?php
	$searchString = strip_tags(trim($_GET["search"]));
	$searchString_escaped = mysql_escape_string($searchString);

	$section = $_GET['section'];
	
	if (!$section) {
		$section = "0";
	}
	
	if(!$searchString) 
	{
		header("Location: search.php");
		exit;
	}

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

<font class="pagetitle">Search Results</font> 
<div style="margin-top: 20px; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #CCCCCC;"><font class="authorpagetext">Your search for &quot;<?php echo $searchString ?>&quot; returned <?php echo $search_entries ?> results.
<?php
	if($search_entries > 10 && $page != 'all')
	{
		$first_result = ($page-1)*10+1;
		$last_result = ($page-1)*10+10;
		if($last_result > $search_entries)
			$last_result = $search_entries;
		echo 'Results '.$first_result.' - '.$last_result.' are listed below.';
	}
?>
</font><br><font class="text">The results are currently sorted by <?php echo $sortby; ?>. You can alternatively <?php if($sortby == 'date') echo '<a href="searchresults.php?search='.htmlspecialchars($searchString).'&page='.$page.'&sortby=relevance&section=' . $section .'">sort by relevance</a>'; else echo '<a href="searchresults.php?search='.htmlspecialchars($searchString).'&page='.$page.'&sortby=date&section=' . $section . '">sort by date</a>'; ?>.</font></div>

<?php
	$search_results_index = 0;
	while($search_entry = mysql_fetch_array($search_result)) 
	{
		$search_results_index++;
		if($search_results_index > 10 && $page != 'all')
			break;

		$articleTitle = $search_entry["title"];
		$articleDate = $search_entry["date"];
		$articleFancyDate = $search_entry["fancydate"];
		$articleSectionID = $search_entry["section_id"];
		$articlePriority = $search_entry["priority"];
		$articlePullquote = $search_entry["pullquote"];
		$articleJob = $search_entry["jobname"];
		$articleAuthor1 = $search_entry["authorname1"];
		$articleAuthor2 = $search_entry["authorname2"];
		$articleAuthor3 = $search_entry["authorname3"];
	?>			
		<p><font class="smallheadline"><a class="smallheadline" href="article.php?date=<?php echo "$articleDate&section=$articleSectionID&id=$articlePriority" ?> "><?php echo $articleTitle; ?></a></font><br>
		<?php if($articleAuthor1) { ?>
			<font class="homeauthorby">By </font><font class="homeauthor"> <?php echo $articleAuthor1 ?>
		<?php if($articleAuthor2) { ?>
			and <?php echo $articleAuthor2; ?>
		<?php if($articleAuthor3) { ?>
			and <?php echo $articleAuthor3; ?>
		<?php } } ?>, <?php echo $articleJob; ?></font><br>
		<?php } ?>
		<font class="articledate"><?php echo $articleFancyDate ?></font><br>
		<font class="hometext"><?php echo $articlePullquote; ?></font>
		</p>
<?php } ?>
<div style="margin-top: 35px"></div>
<?php if($page != 'all' && ($page > 1 || $search_entries > 10)) { ?>
	<div class="navigation">
		<ul class="lnavigation">
			<?php if($page > 1) { ?>
				<li onClick="window.location='searchresults.php?search=<?php echo str_replace("'","\'",htmlspecialchars($searchString)); ?>&section=<?php echo $section; ?>&page=<?php echo $page-1; ?>&sortby=<?php echo $sortby; ?>'"><a href="searchresults.php?search=<?php echo htmlspecialchars($searchString); ?>&section=<?php echo $section; ?>&page=<?php echo $page-1; ?>&sortby=<?php echo $sortby; ?>">&#60; Previous Results</a></li>
			<?php } ?>
			<?php if($search_entries > 10) { ?>
				<li onClick="window.location='searchresults.php?search=<?php echo str_replace("'","\'",htmlspecialchars($searchString)); ?>&page=all&section=<?php echo $section; ?>&sortby=<?php echo $sortby; ?>'"><a href="searchresults.php?search=<?php echo htmlspecialchars($searchString); ?>&page=all&section=<?php echo $section; ?>&sortby=<?php echo $sortby; ?>">View All Results</a></li>
			<?php } ?>
		</ul>
		<ul class="rnavigation">
			<?php if($search_entries > $page*10) { ?>
				<li onClick="window.location='searchresults.php?search=<?php echo str_replace("'","\'",htmlspecialchars($searchString)); ?>&page=<?php echo $page+1; ?>&section=<?php echo $section; ?>&sortby=<?php echo $sortby; ?>'"><a href="searchresults.php?search=<?php echo htmlspecialchars($searchString); ?>&page=<?php echo $page+1; ?>&section=<?php echo $section; ?>&sortby=<?php echo $sortby; ?>">Next Results &#62;</a></li>
			<?php } ?>
		</ul>
	</div>
<?php } ?>

<div style="margin-top: 10px; margin-bottom: 20px; padding: 20px; border: 1px solid #E6E6E6; border-top: 2px solid #CCCCCC; background: #F2F2F2">
	<p style="padding-top: 0; margin: 0; font-size: 12pt; border-bottom: 1px solid #CCCCCC; padding-bottom: 10px; font-weight: bold; color: #353535">Not finding what you are looking for?</p>
	<div style="padding: 10px 0 10px 0; font-size: 8pt; border-bottom: 1px solid #CCCCCC;">
		Note that very common words such as "the" or "Bowdoin" will not be considered in a search. Search terms less than four characters long will also yield unpredictable results. With that in mind, you can:
	</div>
	<p><strong><font class="text">1) Refine your search:</font></strong></p>
	<div style="margin: 15px; font-size: 8pt">  
		<form method="GET" action="searchresults.php">
			<input type="text" name="search" value="<?php echo htmlspecialchars($searchString); ?>" size="30" maxlength="200">
			<input type="submit" value="Search">
			<div style="font-size: 10pt">Sort by: <input type="radio" name="sortby" value="relevance"<?php if($sortby == 'relevance') echo ' checked="checked"'; ?>> Relevance <input type="radio" name="sortby" value="date"<?php if($sortby == 'date') echo ' checked="checked"'; ?>> Date</div>
		<SELECT name="section" id="section">
			<option value="0">Search All</option>
			<option value="1">News</option>
			<option value="2">Opinion</option>
			<option value="3">Features</option>
			<option value="4">Arts & Entertainment</option>
			<option value="5">Sports</option>
			<option value="7">Editorials</option>
			<option value="8">Letters</option>
		</SELECT>
		</form>
		This will only search material published on or after April 2, 2004.
	</div>
	<p><strong><font class="text">2) Browse our <a href="/orient/archives.php">archives</a>, 2000-Present.</font></strong></p>
	<p><strong><font class="text">3) Try a Google&trade; search:</font></strong></p>

	<!-- Search Google -->
	<left>
	<FORM method=GET action=http://www.google.com/custom>
	<TABLE cellspacing=0 border=0>
	<tr valign=top><td>
	<A HREF=http://www.google.com/search>
	<IMG SRC=http://www.google.com/logos/Logo_40wht.gif border=0 ALT=Google align=middle></A>
	</td>
	<td>
	<INPUT TYPE=text name=q size=31 maxlength=255 value="">
	<INPUT type=submit name=sa VALUE="Google Search">
	<INPUT type=hidden name=cof VALUE="S:http://orient.bowdoin.edu;GL:0;AH:left;LH:26;LC:#003366;L:http://orient.bowdoin.edu/orient/images/whiteminilogo.jpg;LW:277;AWFID:6f9be9270348b262;">
	<input type=hidden name=domains value="orient.bowdoin.edu"><br><input type=radio name=sitesearch value=""> <font class="text">The Web <input type=radio name=sitesearch value="orient.bowdoin.edu" checked> orient.bowdoin.edu</font> 
	</td></tr></TABLE>
	</FORM>
	</left>
	<!-- Search Google -->

	<font class="smalltext">Google is a trademark of Google Inc.</font>
</div>
<?php include("stop.php"); ?>