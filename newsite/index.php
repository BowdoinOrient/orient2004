<?php
$title = "The Bowdoin Orient";
include("template/top.php");
startPage();

// Gets all the PHP variables set up for the rest of the page
$break = getSetting('break', false);
$break_message = getSetting('breakMessage', false);
$number_of_articles = getSetting('numArticles', 4, true);
$number_of_mostviewed = getSetting('mostViewed', 4, true);
getFeaturePhoto($date);
$hideHome = true;
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
		<div>
		
			<?php
			// During a break, we need to display the "break" banner before the stories
			if ($break) { ?>
				<div class='span-21 breakcontainer last'>
					<div class='span-21 last breaktitle'><?php echo $break; ?></div>
					<div class='span-21 last'>
						<p><?php echo $break_message; ?></p>
					</div>
					<hr />
				</div>
			<?php } ?>
			<!-- Featured Stories -->
			<div class="span-21 last">
				<!-- Left-hand column of main features - first news stories -->
				<div id='mainarticles' class='span-11 colborder type1'>
					<?php
					// $section determines which section we're grabbing articles for.
					// 1 is news.
					// $date was set in getcurrentdate.php
					$section = 1;
					$result = getSectionArticles($section, $date);
					for ($i = 0; $i < $number_of_articles; $i++) {
						if ($row = mysql_fetch_array($result)) {
							echoArticle($row);
						}
					} ?>
				</div>
				
				<div class='span-9 type1 last'>
					<!-- This is the right-hand column of the main features - the large photos, more news, top stories. -->
					<div class='last featurephoto'>
						<!-- Feature photo -->
						<?php
						if ($anyPhotos) { ?>
							<a href='../images/<?php echo "$date/$photoLargeFilename"; ?>' title='<?php echo getLightboxTitle($photoCaption, $photoCredit); ?>' class='lightbox' ><img src='../images/<?php echo "$date/$photoFilename"; ?>' alt='Feature Photo'></a>
							<div class='photocredit'>
								<?php if ($photographerlink) { ?>
									<a href='authorpage.php?authorid=<?php echo $photographerID ;?>'>
								<?php }
									echo strtoupper($photoCredit);
									if ($photographerlink) {
										echo "</a>";
									}
								?>
							</div>
							<div class='photocaption'>
								<?php echo $photoCaption; ?>
							</div>
						<?php } ?>
					</div>
					
					<div class='spacer'>
					
					</div>
					
					<div class='span-9 last'>
						<!-- More news stories -->
						<ul class='morestories'>
							<li>MORE NEWS</li>
							<?php
								echo more_news($result);
							?>
						</ul>

						<!-- Top-viewed stories -->
						
						<ul class='morestories'>
							<li>THIS WEEK'S MOST-VIEWED ARTICLES</li>
							<?php
								echo more_news(getTopStories($date, $number_of_mostviewed));
							?>
						</ul>
					</div>
				</div>
				<!-- End Featured stories -->

				<div id='sectiondiv' class='span-21 last'>
				
					<?php for ($i = 2; $i < 6; $i++) {
						// This grabs the sections in the order that they're flagged.
						$query = 
							"SELECT id, name
							FROM section 
							WHERE order_flag = $i
						";
						$result = mysql_query($query);
						$row = mysql_fetch_array($result);
						
						// This is the section ID - an integer
						$section = $row['id'];
						// This is the name of the section - a string
						$sectionname = $row['name']; ?>
					<div class='span-21 sectionwrapper last'>
						<hr>
						<h2 class='bottom sectiontitle'><?php echo strtoupper($sectionname); ?></h2>
						
						<div class='span-11 colborder type<?php echo $i; ?>'>
							<?php
								$results = getSectionArticles($section, $date);
								$row = mysql_fetch_array($results);
								echoArticle($row, true);
							?>
						</div>
						
						<div class='span-9 last type<?php echo $i; ?>'>
							<ul class='morestories'>
								<li>MORE <?php echo strtoupper($sectionname); ?></li>
								<?php echo more_news($results); ?>
							</ul>
						</div>
					</div>
				<?php } ?>

				<!-- End section articles -->
				</div>
				
			<!-- End non-link column -->
			</div>

			<?php include("template/footer.php"); ?>
		</div>
		

<?php
include("template/bottom.php");
?>