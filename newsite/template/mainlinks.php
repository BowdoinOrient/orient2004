<?php if ($date != $currentDate) {$dateArg = "?date=$date"; }?>
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
				<li><a href='about.php'>ABOUT</a></li>
				<li><a href='advertise.php'>ADVERTISE</a></li>
				<li><a href='archives.php'>ARCHIVES</a></li>
				<li><a href='contact.php'>CONTACT US</a></li>
				<li><a href='staff.php'>STAFF</a></li>
				<li><a href='subscribe.php'>SUBSCRIBE</a></li>
				<li><a href='rss.php'>RSS <img alt='RSS Feed' src='images/feed-icon.png'/></a></li>
			</ul>