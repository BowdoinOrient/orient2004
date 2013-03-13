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
			
			<style>

				.bigshot, .stafftitle {
					font-variant: small-caps;
					font-weight: bold;
				}

				.bigshot-title {
					font-style: italic;
				}

				.stafftitle {
					padding-top: 10px;
				}

				div {
					background: white;
					margin: 0;
					padding: 0;
				}

				.clear {
					clear: both;
				}

				#stafftable {
					width: 100%;
					text-align: center;
				}

				#eic, #topeditors {
					clear: both;
				}

				#eic div, #topeditors div {
					width: 50%;
					float: left;
					margin: 0 0 10px 0;
				}

				#topstaff {
					width: 100%;
				}

				#lowerstaff {
					width: 100%;
				}

				#lowerstaff .column {
					float: left;
					width: 33.3%;
					margin: 0;
				}

				#stafftable p {
					margin: 0px;
				}
				
			</style>
			
			<div id="stafftable">

				<div id="topstaff">
					<div id="eic">
						<div><p><span class="bigshot">Nick Daniels,</span> <span class="bigshot-title">Editor in Chief</span></p></div>
						<div><p><span class="bigshot">Zoë Lescaze,</span> <span class="bigshot-title">Editor in Chief</span></p></div>
					</div>
					<div id="topeditors">
						<div><p><span class="bigshot">Elizabeth Maybank,</span> <span class="bigshot-title">Senior Editor</span></p></div>
						<div><p><span class="bigshot">Erica Berry,</span> <span class="bigshot-title">Managing Editor</span></p></div>
						<div style="width:100%"><p><span class="bigshot">Linda Kinstler,</span> <span class="bigshot-title">Managing Editor</span></p></div>
					</div>
				</div>
				<hr style="width:50%; margin: 0 auto;">
				<div id="lowerstaff">
					<div class="column">
						<p class="stafftitle">News Editors</p>
						<p>Zohran Mamdani</p>
						
						<p class="stafftitle">Features Editor</p>
						<p>Claire Aasen</p>
						
						<p class="stafftitle">A&E Editor</p>
						<p>Peter Griesmer</p>
						
						<p class="stafftitle">Sports Editor</p>
						<p>Sam Weyrauch</p>
						
						<p class="stafftitle">Opinion Editor</p>
						<p>Nora Biette-Timmons</p>
					</div>
					<div class="column">
						<p class="stafftitle">Calendar Editor</p>
						<p>Garrett Casey</p>

						<p class="stafftitle">Associate Editors</p>
						<p>Carlo Davis</p>
						<p>Sam Frizell</p>
						
						<p class="stafftitle">Senior Reporters</p>
						<p>Diana Lee</p>
						<p>Eliza Novick-Smith</p>
						
						<p class="stafftitle">Business Managers</p>
						<p>Maya Lloyd</p>
						<p>Madison Whitley</p>
					</div>
					<div class="column">
						<p class="stafftitle">Graphic Designers</p>
						<p>Leo Shaw</p>
						
						<p class="stafftitle">Photo Editor</p>
						<p>Brian Jacobel</p>
						
						<p class="stafftitle">Asst. Photo Editor</p>
						<p>Kate Featherston</p>
						
						<p class="stafftitle">Information Architect</p>
						<p>Toph Tucker</p>
						
						<p class="stafftitle">Web Editor</p>
						<p>Linda Kinstler</p>
					</div>
				</div>
				
			</div>
			
			<div class="clear"></div>
			
			<?php spacer() ?>
			
			<hr>
			
			<?php spacer() ?>
			
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