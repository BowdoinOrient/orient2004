<?php
include("template/top.php");
$title = "The Bowdoin Orient - Staff and Writers";
startPage();

$lastVolQuery = "SELECT id, numeral FROM volume ORDER BY id DESC LIMIT 0,1";
$lastVolResults = mysql_query($lastVolQuery);
$lastVolumeID = mysql_result($lastVolResults, 0, "id");
$lastVolumeNumeral = mysql_result($lastVolResults, 0, "numeral");

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
		issue.volume_id = $lastVolumeID
		AND (article.author1 = author.id OR article.author2 = author.id OR article.author3 = author.id) AND
		active = 'y'
	GROUP BY 
		author.id
	ORDER BY
		lastname
	";
	$staffResults = mysql_query($staffQuery);
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
		<h2 class='articlesection'>Staff and Writers</h2>
		
		<div class='information'>
			<h3 class='articletitle'>Orient Staff</h3>
			
			<?php spacer(); ?>
			
			<table class='staff-table'>
				<tr>
					<td><span class='caps2'>Nick Day,</span> Editor-in-Chief</td>
					<td><span class='caps2'>Mary Helen Miller,</span> Editor-in-Chief</td>
				</tr>
				<tr>
					<td><span class='caps2'>Adam Kommel,</span> Senior Editor</td>
					<td><span class='caps2'>Cati Mitchell,</span> Senior Editor</td>
				</tr>
			</table>
			
			<hr class='staff-divider'>
			
			<table class='paper-staff'>
				<tr>
					<td><span class='caps2'>News Editor</span></td>
					<td><span class='caps2'>Senior News Staff</span></td>
					<td><span class='caps2'>Photo Editor</span></td>
				</tr>
				<tr>
					<td>Gemma Leghorn</td>
					<td>Caitlin Beach</td>
					<td>Margot D. Miller</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Emily Guerin</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><span class='caps2'>Features Editor</span></td>
					<td>Nat Herz</td>
					<td><span class='caps2'>Assistant Photo Editor</span></td>
				</tr>
				<tr>
					<td>Cameron Weller</td>
					<td>&nbsp;</td>
					<td>Mariel Beaudoin</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><span class='caps2'>News Staff</span></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><span class='caps2'>A&amp;E Editor</span></td>
					<td>Anya Cohen</td>
					<td><span class='caps2'>Web Manager</span></td>
				</tr>
				<tr>
					<td>Carolyn Williams</td>
					<td>Claire Collery</td>
					<td>Seth Glickman</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Nick Daniels</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><span class='caps2'>Sports Editor</span></td>
					<td>Peter Griesmer</td>
					<td><span class='caps2'>Business Manager</span></td>
				</tr>
				<tr>
					<td>Seth Walder</td>
					<td>Zo&euml; Lescaze</td>
					<td>Jessica Haymon Gorlov</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Toph Tucker</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><span class='caps2'>Opinion Editor</span></td>
					<td>&nbsp;</td>
					<td><span class='caps2'>Assistant Business</span></td>
				</tr>
				<tr>
					<td>Piper Grosswendt</td>
					<td><span class='caps2'>Calendar Editor</span></td>
					<td><span class='caps2'>Manager</span></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Alex Porter</td>
					<td>Lizzy Tarr</td>
				</tr>
			</table>

			<p>For more information on contacting <em>The Orient</em>, please see our <a href='contact.php'>contact page</a>.</p>
			
			<h3 class='articletitle'>Current Staff Pages</h3>
			
			<?php
			spacer(); 
			?>
			<p>This is an alphabetic list of everyone who has contributed to Volume <strong><?php echo $lastVolumeNumeral;?></strong> of <em>The Orient</em> (the most recent volume).  To see the work of a specific staff member or contributor, click on the name below.  If you do not see the name you are looking for, you can try the <a href="fullstaff.php">Full Contributor Page</a>, or searching for that name in the box in the upper-left corner.</p>
			
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