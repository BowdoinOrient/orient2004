<?php
include("template/top.php");
$volumeNumeral = mysql_real_escape_string($_GET['numeral']);
$title = "The Bowdoin Orient - Volume ".$volumeNumeral;
startPage();

$lastVolQuery = "SELECT id, numeral FROM volume WHERE numeral='$volumeNumeral' LIMIT 0,1";
$lastVolResults = mysql_query($lastVolQuery);
$volumeID = mysql_result($lastVolResults, 0, "id");

$staffQuery = 
	"SELECT
		author.name,
		author.id,
		SUBSTRING_INDEX(author.name, ' ', -1) AS lastname
	FROM
		author,
		article,
		issue
	WHERE
		name != '' AND
		article.date = issue.issue_date AND
		issue.volume_id = $volumeID
		AND (article.author1 = author.id OR article.author2 = author.id OR article.author3 = author.id) AND
		active = 'y'
	GROUP BY 
		author.id
	ORDER BY
		lastname
	";
	$staffResults = mysql_query($staffQuery);

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
		volume_id = '$volumeID'
	ORDER BY
		issue_date DESC
	";
$issues = mysql_query($issueQuery);

// prepare for popular articles query

$allIssues = 'TEST: ';
//foreach(mysql_fetch_array($issues) as $row) {
//	$allIssues .= "'".$row['issuedate']."', ";
//}

?>

<!-- Side Links (3 blocks) -->
<div class='span-3 menudiv'>
	<?php include("template/mainlinks.php"); ?>
	<div class='spacer'>
	</div>

	<?php include("template/events.php"); ?>
	<div class='spacer'>
	</div>

	<?php include("template/otherlinks.php"); ?>
</div>

<!-- The rest of the page is to the right of the link bar -->
<div class='span-21 last'>
	<div class='span-16 information'>
		<h2 class='articlesection'>Volume <?php echo $volumeNumeral ?></h2>
		
		<div class='information'>
			
			<h3 class="articletitle">Issues</h3>
			
			<?php
			spacer(); 
			?>
			
			<ul>
				<?php while ($row = mysql_fetch_array($issues)) {
					$issuedate = $row['issue_date'];
					echo "<li><a href='index.php?date=$issuedate'>" . $row['fancydate'] . "</a></li>";
				}?>
			</ul>
			
			<?php
			spacer(); 
			?>
			
			<h3 class='articletitle'>Popular Articles</h3>
			
			<!-- INSERT POPULAR ARTICLES HERE -->
			<p>Coming soon.</p>
			
			<h3 class='articletitle'>Columns</h3>
			
			<!-- INSERT LIST OF COLUMNS (SERIES) HERE -->
			<p>Coming soon.</p>
			
			
			<h3 class='articletitle'>Contributors</h3>
			
			<?php
			spacer(); 
			?>
			
			<table class='stafftable'>
				<?php
				$counter = 0;
				while ($row = mysql_fetch_array($staffResults)) {
					$authorName = $row['name'];
					$authorID = $row['id'];
					if ($counter == 0) {
						echo "<tr>";
					}
					echo "<td class='col$counter'><a href='authorpage.php?authorid=$authorID'>$authorName</a></td>";
					$counter++;
					$counter = $counter % 3;
					if ($counter == 0) {
						echo "</tr>";
					}
				}
				if ($counter > 0) {
					$counter = 3 - $counter;
					while ($counter > 0) {
						echo "<td></td>";
						$counter--;
					}
					echo "</tr>";
				}
				?>
			</table>
			
		</div>
	</div>
	
	<div class='span-5 last'>
		<?php include("template/currentorient.php"); ?>
	</div>
</div>
<?php include("template/footer.php"); ?>
</div>

<?php include("template/bottom.php"); ?>