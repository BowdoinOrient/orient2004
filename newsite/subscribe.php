<?php
include("template/top.php");
$title = "The Bowdoin Orient - Subscribe";
startPage();
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
	<div class='span-16'>
		<h2 class='articlesection'>Subscribe</h2>
		
		<div class='advertise information'>
			<h3 class='articletitle'>Stay informed: Subscribe to <em>The Bowdoin Orient</em></h3>
				<p>Find out what's really happening on the Bowdoin campus by subscribing to the student-run newspaper, <em>The Bowdoin Orient</em>. The <em>Orient</em> covers news, features, student opinion, arts &amp; entertainment, sports, and weekly events. We will be printing 24 issues throughout the 2008-2009 academic year.</p>
				
				<p>Your subscription to the Orient will offer you:</p>
				
				<ul class='subscription-list'>
					<li>Unparalleled coverage of Bowdoin news, events, entertainment, and sports.</li>
					<li>Features that explore Bowdoin people and Bowdoin life.</li>
					<li>The chance to connect with student opinion&#8212;and even offer your own.</li>
					<li>Proactive investigation of issues relevant to students and parents.</li>
					<li>Access to Bowdoin's newsmakers and leaders.</li>
					<li>Context for a Bowdoin education.</li>
				</ul>
				
			<h3 class='articletitle'>2008-2009 Domestic Rates</h3>
			
			<p>  1 year: $55 <br />
			2 years: $102 <br />
			1 semester (fall or spring): $30</p>
			
			<h3 class='articletitle'>2008-2009 International Rates</h3>
			
			<p> 1 year: US$82 <br />
			2 years: US$156 <br />
			1 semester (fall or spring): US$43</p>
			
			<h3 class='articletitle'>Instructions</h3>
			
			<p> 1. Print out the <a href='../subscriptionform.php'>subscription form</a>. <br />
			2. Mail the form, along with a check, to:<br />
			<br />
			The Bowdoin Orient <br />
		    6200 College Station <br />
		    Brunswick, ME 04011
			</p>
						
		</div>
	</div>
	
	<div class='span-5 last'>
		<?php include("template/currentorient.php"); ?>
	</div>
</div>
<?php include("template/footer.php"); ?>
</div>

<?php include("template/bottom.php"); ?>