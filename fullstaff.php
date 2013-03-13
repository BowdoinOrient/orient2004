<?php
include("template/top.php");
$title = "The Bowdoin Orient - Staff and Writers";
startPage();

$staffQuery = 
	"SELECT
		name,
		id
	FROM
		author
	WHERE
		name != '' AND
		active = 'y'
	ORDER BY
		name
	";
$staffResults = mysql_query($staffQuery);
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
	<div class='span-16 information'>
		<h2 class='articlesection'>Staff and Writers</h2>
		
		<div class='information'>
			<h3 class='articletitle'>Full Staff and Contributor List</h3>
				<p>This page contains an alphabetic list of everyone who has worked at or contributed to <em>The Orient</em>. To see the work of a specific staff member or contributor, click on the name below. If you do not find the name you are looking for, try the search box in the top-left corner.</p>
			<?php spacer(); ?>
			
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