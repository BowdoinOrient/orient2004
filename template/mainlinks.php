<?php if ($date != $currentDate) {$dateArg = "?date=$date"; }?>
			
			<ul class="mainlinks last">
				<li>
					<!--<img src="http://img266.imageshack.us/img266/1585/newvm.png" style="position:absolute; left:97px; top:208px;">-->
					<a href="http://www.bowdoinorientexpress.com/">
						<img src="images/logo2-express-thin-nav.png">
					</a>
				</li>
			</ul>
			<div class="spacer last"></div>
			
			<ul class='mainlinks last'>
				<?php if (!$hideHome) { ?>
				<li><a href='index.php<?php echo $dateArg; ?>'>HOME</a></li>	
				<?php }?>
				<li><a href='news.php<?php echo $dateArg; ?>'>NEWS</a></li>
				<li><a href='features.php<?php echo $dateArg; ?>'>FEATURES</a></li>
				<li><a href='opinion.php<?php echo $dateArg; ?>'>OPINION</a></li>
				<li><a href='arts.php<?php echo $dateArg; ?>'>ARTS</a></li>
				<li><a href='sports.php<?php echo $dateArg; ?>'>SPORTS</a></li>
				<li><a href='events.php<?php echo $dateArg; ?>'>EVENTS</a></li>
				<li><a href='photos.php<?php echo $dateArg; ?>'>PHOTOS</a></li>
			</ul>
			
			<div class='spacer last'>
			
			</div>
						
			<ul class='mainlinks last'>
				<li><a href='comments.php'>COMMENT <img alt='Recent Comments' src='images/comments-icon.png'/></a></li>
				<li><a href='http://www.twitter.com/bowdoinorient'>TWITTER <img alt='Twitter' src='images/twitter-icon.png'/></a></li>
				<li><a href='rss.php'>RSS <img alt='RSS Feed' src='images/feed-icon.png'/></a></li>
			</ul>
			
			<div class='spacer last'>
			
			</div>
			
			<ul class='mainlinks last'>
				<li><a href='about.php'>ABOUT</a></li>
				<li><a href='advertise.php'>ADVERTISE</a></li>
				<li><a href='archives.php'>ARCHIVES</a></li>
				<li><a href='contact.php'>CONTACT US</a></li>
				<li><a href='staff.php'>STAFF</a></li>
				<li><a href='subscribe.php'>SUBSCRIBE</a></li>
			</ul>