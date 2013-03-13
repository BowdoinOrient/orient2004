<?php
include("template/top.php");

$volumesQuery = 
	"SELECT
		id,
		numeral
	FROM
		volume
	WHERE 
		id > 2
	ORDER BY
		id DESC
	";
$volumes = mysql_query($volumesQuery);

$year = 2004 + mysql_num_rows($volumes);

$title = "The Bowdoin Orient - Archives";
startPage();

?>

<!-- Side Links (3 blocks) -->
<div class='span-3 menudiv'>
	<?php include("template/mainlinks.php"); ?>
	<div class='spacer'>
	</div>

	<?php include("template/otherlinks.php"); ?>
</div>

<!-- The rest of the page is to the right of the link bar -->
<div class='span-21 last'>
	<div class='span-16 authorpage'>
		<h2 class='articlesection'>Archives</h2>
			<?php
				while ($volumeID = mysql_fetch_array($volumes)) {
					$volID = $volumeID['id'];
					$volNum = $volumeID['numeral'];
					$year--;
					$issueQuery = 
						"SELECT
							date_format(issue.issue_date, '%M %e, %Y') AS fancydate,
							issue_date,
							volume_id,
							issue_number
						FROM
							issue
						WHERE
							ready = 'y' AND
							volume_id = '$volID'
						ORDER BY
							issue_date DESC
						";
					$issues = mysql_query($issueQuery); ?>
			<h3 class='authorpagesection'><?php echo "$year - " . ($year + 1) . ": Volume $volNum"; ?></h3>
				<ul>
					<?php while ($row = mysql_fetch_array($issues)) {
						$issuedate = $row['issue_date'];
						echo "<li><a href='index.php?date=$issuedate'>" . $row['fancydate'] . "</a></li>";
					}?>
				</ul>
<?php 			} ?>
			<h3 class='authorpagesection'>2003-2004: Volume CXXXIII</h3>
				<ul>
					<li><a href='index.php?date=2004-05-07'>May 7, 2004</a></li>
					<li><a href='index.php?date=2004-04-30'>April 30, 2004</a></li>
					<li><a href='index.php?date=2004-04-23'>April 23, 2004</a></li>
					<li><a href='index.php?date=2004-04-16'>April 16, 2004</a></li>
					<li><a href='index.php?date=2004-04-09'>April 9, 2004</a></li>
					<li><a href='index.php?date=2004-04-02'>April 2, 2004</a></li>
					<li><a href='archives/2004-03-05/main.htm'>March 5, 2004</a></li>
					<li><a href='archives/2004-02-27/main.htm'>February 27, 2004</a></li>
					<li><a href='archives/2004-02-20/main.htm'>February 20, 2004</a></li>
					<li><a href='archives/2004-02-13/main.htm'>February 13, 2004</a></li>
					<li><a href='archives/2004-02-06/main.htm'>February 6, 2004</a></li>
					<li><a href='archives/2004-01-30/main.htm'>January 30, 2004</a></li>
					<li><a href='archives/2003-12-05/main.htm'>December 5, 2003</a></li>
					<li><a href='archives/2003-11-21/main.htm'>November 21, 2003</a></li>
					<li><a href='archives/2003-11-14/main.htm'>November 14, 2003</a></li>
					<li><a href='archives/2003-11-07/main.htm'>November 7, 2003</a></li>
					<li><a href='archives/2003-10-31/main.htm'>October 31, 2003</a></li>
					<li><a href='archives/2003-10-24/main.htm'>October 24, 2003</a></li>
					<li><a href='archives/2003-10-10/main.htm'>October 10, 2003</a></li>
					<li><a href='archives/2003-10-03/main.htm'>October 3, 2003</a></li>
					<li><a href='archives/2003-09-26/main.htm'>September 26, 2003</a></li>
					<li><a href='archives/2003-09-19/main.htm'>September 19, 2003</a></li>
					<li><a href='archives/2003-09-12/main.htm'>September 12, 2003</a></li>
				</ul>
			
			<h3 class='authorpagesection'>2002-2003: Volume CXXXII</h3>
			<ul>
				<li><a href='archives/2003-05-02/main.htm'>May 2, 2003</a></li>
				<li><a href='archives/2003-04-25/main.htm'>April 25, 2003</a></li>
				<li><a href='archives/2003-04-18/main.htm'>April 18, 2003</a></li>
				<li><a href='archives/2003-04-11/main.htm'>April 11, 2003</a></li>
				<li><a href='archives/2003-04-04/main.htm'>April 4, 2003</a></li>
				<li><a href='archives/2003-03-28/main.htm'>March 28, 2003</a></li>
				<li><a href='archives/2003-02-28/main.htm'>February 28, 2003</a></li>
				<li><a href='archives/2003-02-21/main.htm'>February 21, 2003</a></li>
				<li><a href='archives/2003-02-14/main.htm'>February 14, 2003</a></li>
				<li><a href='archives/2003-02-07/main.htm'>February 7, 2003</a></li>
				<li><a href='archives/2003-01-31/main.htm'>January 31, 2003</a></li>
				<li><a href='archives/2003-01-24/main.htm'>January 24, 2003</a></li>
				<li><a href='archives/2002-12-06/main.htm'>December 6, 2002</a></li>
				<li><a href='archives/2002-11-22/main.htm'>November 22, 2002</a></li>
				<li><a href='archives/2002-11-15/main.htm'>November 15, 2002</a></li>
				<li><a href='archives/2002-11-08/main.htm'>November 8, 2002</a></li>
				<li><a href='archives/2002-11-01/main.htm'>November 1, 2002</a></li>
				<li><a href='archives/2002-10-25/main.htm'>October 25, 2002</a></li>
				<li><a href='archives/2002-10-18/main.htm'>October 18, 2002</a></li>
				<li><a href='archives/2002-10-04/main.htm'>October 4, 2002</a></li>
				<li><a href='archives/2002-09-27/main.htm'>September 27, 2002</a></li>
				<li><a href='archives/2002-09-20/main.htm'>September 20, 2002</a></li>
				<li><a href='archives/2002-09-13/main.htm'>September 13, 2002</a></li>
			</ul>
			
			<h3 class='authorpagesection'>2001-2002: Volume CXXXIII/CXXXI<a class='footnote' href='#footnote'><sup>*</sup></a></h3>
			<ul>
				<li><a href='archives/2002-05-03/main.htm'>May 3, 2002</a></li>
				<li><a href='archives/2002-04-26/main.htm'>April 26, 2002</a></li>
				<li><a href='archives/2002-04-19/main.htm'>April 19, 2002</a></li>
				<li><a href='archives/2002-04-12/main.htm'>April 12, 2002</a></li>
				<li><a href='archives/2002-04-05/main.htm'>April 5, 2002 <a class='footnote' href='#footnote'><sup>*</sup></a></a></li>
				<li><a href='archives/2002-03-29/main.htm'>March 29, 2002</a></li>
				<li><a href='archives/2002-03-01/main.htm'>March 1, 2002</a></li>
				<li><a href='archives/2002-02-22/main.htm'>February 22, 2002</a></li>
				<li><a href='archives/2002-02-15/main.htm'>February 15, 2002</a></li>
				<li><a href='archives/2002-02-08/main.htm'>February 8, 2002</a></li>
				<li><a href='archives/2002-02-01/main.htm'>February 1, 2002</a></li>
				<li><a href='archives/2002-01-25/main.htm'>January 25, 2002</a></li>
				
				<li><a href='archives/2001-12-07/main.htm'>December 7, 2001</a></li>
				<li><a href='archives/2001-11-30/main.htm'>November 30, 2001</a></li>
				<li><a href='archives/2001-11-16/main.htm'>November 16, 2001</a></li>
				<li><a href='archives/2001-11-09/main.htm'>November 9, 2001</a></li>
				<li><a href='archives/2001-11-02/main.htm'>November 2, 2001</a></li>
				<li><a href='archives/2001-10-26/main.htm'>October 26, 2001</a></li>
				<li><a href='archives/2001-10-19/main.htm'>October 19, 2001</a></li>
				<li><a href='archives/2001-10-12/main.htm'>October 12, 2001</a></li>
				<li><a href='archives/2001-09-28/main.htm'>September 28, 2001</a></li>
				<li><a href='archives/2001-09-21/main.htm'>September 21, 2001</a></li>
				<li><a href='archives/2001-09-14/main.htm'>September 14, 2001</a></li>
				<li><a href='archives/2001-09-07/main.htm'>September 7, 2001</a></li>
			</ul>
			
			<h3 class='authorpagesection'>2000-2001: Volume CXXXII (Incomplete)</h3>
			<ul>
				<li><a href='archives/2001-05-04/news.htm'>May 4, 2001 [headlines]</a></li>    
				<li><a href='archives/2001-04-27/news.htm'>April 27, 2001 [headlines]</a></li>    
				<li><a href='archives/2001-04-20/news.htm'>April 20, 2001 [headlines]</a></li>    
				<li><a href='archives/2001-04-13/news.htm'>April 13, 2001 [headlines]</a></li>    
				<li><a href='archives/2001-04-06/main.htm'>April 6, 2001</a></li>    
				<li><a href='archives/2001-03-09/main.htm'>March 9, 2001</a></li>    
				<li><a href='archives/2001-03-02/main.htm'>March 2, 2001</a></li>    
				<li><a href='archives/2001-02-23/news.htm'>February 23, 2001 [headlines]</a></li>    
				<li><a href='archives/2001-02-16/main.htm'>February 16, 2001</a></li>    
				<li><a href='archives/2001-02-09/main.htm'>February 9, 2001</a></li>    
				<li><a href='archives/2001-02-02/main.htm'>February 2, 2001</a></li>    
				<li><a href='archives/2001-01-26/news.htm'>January 26, 2001 [headlines]</a></li>    
				
				<li><a href='archives/2000-12-08/main.htm'>December 8, 2000</a></li>
				<li><a href='archives/2000-12-01/main.htm'>December 1, 2000</a></li>
				<li><a href='archives/2000-11-17/main.htm'>November 17, 2000</a></li>
				<li><a href='archives/2000-11-10/main.htm'>November 10, 2000</a></li>
				<li><a href='archives/2000-11-03/news.htm'>November 3, 2000 [headlines]</a></li>
				<li><a href='archives/2000-10-20/news.htm'>October 20, 2000 [headlines]</a></li>
				<li><a href='archives/2000-10-13/news.htm'>October 13, 2000 [headlines]</a></li>
				<li><a href='archives/2000-10-06/news.htm'>October 6, 2000 [headlines]</a></li>
				<li><a href='archives/2000-09-29/news.htm'>September 29, 2000 [headlines]</a></li>
				<li><a href='archives/2000-09-22/news.htm'>September 22, 2000 [headlines]</a></li>
				<li><a href='archives/2000-09-15/news.htm'>September 15, 2000 [headlines]</a></li>
				<li><a href='archives/2000-09-08/news.htm'>September 8, 2000</a></li>
			</ul>
			
			<a name='footnote'></a><p>* In this issue a longstanding numbering error in the volume was corrected. Issues after April 5 are in volume CXXXI. See <a href='http://orient.bowdoin.edu/orient/archives/2002-04-05/opinion_eds.htm#2'>Editors' Note</a>.</p>
	</div>
	
	<div class='span-5 last'>
		<?php include("template/currentorient.php"); ?>
	</div>
</div>
<?php include("template/footer.php"); ?>
</div>

<?php include("template/bottom.php"); ?>