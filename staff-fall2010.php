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
					<td colspan="3" width="50%"><span class='caps2'><a href="authorpage.php?authorid=441">Piper Grosswendt</a>,</span> Editor in Chief</td>
					<td colspan="3" width="50%"><span class='caps2'><a href="authorpage.php?authorid=457">Seth Walder</a>,</span> Editor in Chief</td>
				</tr>
				<tr>
					<td colspan="3" width="50%"><span class='caps2'><a href="authorpage.php?authorid=514">Claire Collery</a>,</span> Managing Editor</td>
					<td colspan="3" width="50%"><span class='caps2'><a href="authorpage.php?authorid=525">Nick Daniels</a>,</span> Managing Editor</td>
				</tr>
				<tr>
					<td colspan="6"><span class='caps2'><a href="authorpage.php?authorid=515">Zo&euml Lescaze</a>,</span> Managing Editor</td>
				</tr>
			</table>
			
<!--
			<div class='top' style='text-align: center; margin-top: -10px; margin-bottom: 10px;'>
				<span class='caps2'>Will Jacob,</span> Managing Editor
			</div>
-->
			
			<hr class='staff-divider'>
			
			<table class='paper-staff'>
				<tr>
					<td><span class='caps2'>News Editor</span></td>
					<td><span class='caps2'>Senior News Staff</span></td>
					<td><span class='caps2'>Photo Editor</span></td>
				</tr>
				<tr>
					<td><a href="authorpage.php?authorid=565">Linda Kinstler</a></td>
					<td><a href="authorpage.php?authorid=588">Sasha Davis</a></td>
					<td><a href="authorpage.php?authorid=640">Aaron Wolf</a></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><a href="authorpage.php?authorid=580">Sarah Levin</a></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><span class='caps2'>Features Editor</span></td>
					<td><a href="authorpage.php?authorid=428">Erin McAuliffe</a></td>
					<td><span class='caps2'>Asst. Photo Editor</span></td>
				</tr>
				<tr>
					<td><a href="authorpage.php?authorid=669">Melissa Wiley</a></td>
					<td>&nbsp;</td>
					<td><a href="authorpage.php?authorid=643">Alex Pigott</a></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><span class='caps2'>A&E Editor</span></td>
					<td><span class='caps2'>News Staff</span></td>
					<td><span class='caps2'>Photographer</span></td>
				</tr>
				<tr>
					<td><a href="authorpage.php?authorid=585">Mariya Ilyas</a></td>
					<td><a href="authorpage.php?authorid=654">Claire Aasen</a></td>
					<td><a href="authorpage.php?authorid=639">Alex Sutula</a></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><a href="authorpage.php?authorid=667">Erica Berry</a></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td><span class='caps2'>Sports Editor</span></td>
					<td><a href="authorpage.php?authorid=597">Molly Burke</a></td>
					<td></td>
				</tr>
				<tr>
					<td><a href="authorpage.php?authorid=611">Jim Reidy</a></td>
					<td><a href="authorpage.php?authorid=666">Jeff Cuartas</a></td>
					<td><span class='caps2'>Business Manager</span></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><a href="authorpage.php?authorid=570">Charlie Cubeta</a></td>
					<td>Tarara Deane-Krantz</td>
				</tr>
				<tr>
					<td><span class='caps2'>Opinion Editor</span></td>
					<td><a href="authorpage.php?authorid=670">Peter Davis</a></td>
					<td></td>
				</tr>
				<tr>
					<td><a href="authorpage.php?authorid=610">Ted Clark</a></td>
					<td><a href="authorpage.php?authorid=675">Diana Lee</a></td>
					<td><span class='caps2'>Asst. Business Managers</span></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><a href="authorpage.php?authorid=653">Zohran Mamdani</a></td>
					<td>Maya Lloyd</td>
				</tr>
				<tr>
					<td><span class='caps2'>Calendar Editor</span></td>
					<td><a href="authorpage.php?authorid=652">Eliza Novak-Smith</a></td>
					<td>Madison Whitley</td>
				</tr>
				<tr>
					<td>Nora Biette-Timmons</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td><span class="caps2">Web Editor</span></td>
					<td><span class='caps2'>Web Manager</span></td>
					<td><span class='caps2'>Circulation Manager</span></td>
				</tr>
				<tr>
					<td><a href="authorpage.php?authorid=524">Anya Cohen</a></td>
					<td><a href="authorpage.php?authorid=513">Toph Tucker</a></td>
					<td>Reed Gilbride</td>
				</tr>
				
				<!--
					<td><a href="authorpage.php?authorid=513">Toph Tucker</a></td>
					<td><a href="authorpage.php?authorid=585">Mariya Ilyas</a></td>
					<td><a href="authorpage.php?authorid=524">Anya Cohen</a></td>
					<td><a href="authorpage.php?authorid=611">Jim Reidy</a></td>
					<td><a href="authorpage.php?authorid=610">Ted Clark</a></td>
				-->
				
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