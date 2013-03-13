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
					$result = getSectionArticles($section, $date, false);
					for ($i = 0; $i < $number_of_articles; $i++) {
						if ($row = mysql_fetch_array($result)) {
							echoArticle($row, false, false);
						}
					} ?>
				</div>
				
				<div class='span-9 type1 last'>
					<!-- This is the right-hand column of the main features - the large photos, more news, top stories. -->
					<div class='last featurephoto'>
						<!-- Feature photo -->
						<?php
						if ($anyPhotos) { ?>
							<a href='images/<?php echo "$date/$photoLargeFilename"; ?>' title='<?php echo getLightboxTitle($photoCaption, $photoCredit); ?>' class='lightbox' ><img id='featurephoto' src='images/<?php echo "$date/$photoFilename"; ?>' alt='Feature Photo'></a>
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
							<div class='mainphotocaption'>
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
								echo more_news($result, false, false);
							?>
						</ul>
					</div>
				</div>
				<!-- End Featured stories -->

						<!-- Top-viewed stories -->
						
				<div id='sectiondiv' class='span-21 last'>
					<div class='span-21 sectionwrapper last'>
						<hr>
						<div class='span-11 colborder type2'>
						<ul class='morestories'>
							<li>RECENT COMMENTS</li>
							<li><b>Toph Tucker</b> on <a href='article.php?date=2010-02-05&section=2&id=6'>The iPad: Good-looking, poorly named, and possibly transformative</a></li>
							<li><b>Gemma Leghorn</b> on <a href='article.php?date=2010-02-05&section=2&id=1'>Our Challenge</a></li>
							<li><b>Abriel Ferreira</b> on <a href='article.php?date=2010-02-05&section=2&id=4'>Bowdoin’s hard alcohol ban creates more problems than it solves</a></li>
							<li><b>Octavian Neamtu</b> on <a href='article.php?date=2010-02-05&section=2&id=6'>The iPad: Good-looking, poorly named, and possibly transformative</a></li>
							<li><b>Kathryn Engel</b> on <a href='article.php?date=2010-02-05&section=5&id=5'>Swimming teams defeat Wesleyan, lose to strong Trinity squads</a></li>
						</ul>
						<center>
						<h3>"Tell me again, is it really possible to just look out for each other better? NOOO YOU IDIOTS!"</h3>
						<p><b>Rutledge Long</b> on <a href='article.php?date=2010-02-05&section=2&id=1'>Our Challenge</a></p>
						</center>
						</div>
						<div class='span-9 last type2'>
						<ul class='morestories'>
							<li>MOST VIEWED</li>
							<?php
								echo more_news(getTopStories($date, $number_of_mostviewed), false, false);
							?>
						</ul>
						</div>
					</div>
				</div>
				
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
								$results = getSectionArticles($section, $date, false);
								$row = mysql_fetch_array($results);
								echoArticle($row, true, false);
							?>
						</div>
						
						<div class='span-9 last type<?php echo $i; ?>'>
							<ul class='morestories'>
								<li>MORE <?php echo strtoupper($sectionname); ?></li>
								<?php echo more_news($results, false, false); ?>
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