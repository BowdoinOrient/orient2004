<?php
// This page provides the "In the current Orient" sidebar on the article pages.
// It's the first editorial, followed by the first of each of the sections.
// It avoids displaying the article you're already on - if you're on the first article of a given section,
// it will display the second article.
// Meant for a 5-block width.
?>
<div class='currentorientsidebar'>
<!--<h3 class='currentOrientHeader'>In the current <span class='papertitle'>Orient</span></h3>-->
<div class='sidebararticle' style="text-align:center">
<h4 style="margin-bottom:0"><strong>IN THE CURRENT <i>ORIENT</i></strong></h4>
</div>
<?php spacer() ?>
<?php

if ($section != 2) {
	// If we're not looking at an opinion article, display the editorial first.
	
	$editorials = getEditorials($currentDate);
	if ($row = mysql_fetch_array($editorials)) {
		echoSidebarArticle($row, "", true);
	}
	spacer();
}

for ($i = 1; $i < 6; $i++) {
	// This grabs the sections in the order that they're flagged.
	$query = 
		"SELECT id, name
		FROM section 
		WHERE order_flag = $i
	";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	
	// This is the section ID - an integer
	$sectionID = $row['id'];
	$secondStory = false;
	if ($section == $sectionID and $priority == 1 and $date == $currentDate) {
		$secondStory = true;
	}
	// This is the name of the section - a string
	$sectionname = $row['name'];
	$articles = getSectionArticles($sectionID, $currentDate, true);
	$articlerow = mysql_fetch_array($articles);
	if ($secondStory) {
		$articlerow = mysql_fetch_array($articles);
	}
	if ($articlerow) {
		echoSidebarArticle($articlerow, $sectionname);
		spacer();
	}
}
?>

<iframe src="http://www.facebook.com/plugins/fan.php?id=113269185373845&amp;width=190&amp;height=330&amp;connections=9&amp;stream=false&amp;header=false" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:190px; height:330px"></iframe>

<?php spacer() ?>

<iframe src="http://www.facebook.com/plugins/activity.php?site=orient.bowdoin.edu&amp;width=190&amp;height=200&amp;header=true&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:190px; height:200px"></iframe>

<?php spacer() ?>

<iframe src="http://www.facebook.com/plugins/recommendations.php?site=orient.bowdoin.edu&amp;width=190&amp;height=200&amp;header=true&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:190px; height:200px"></iframe>

<!--
<div class="sidebararticle">
	<h4><a href='http://twitter.com/bowdoinorient'>@bowdoinorient</a></h4> 
	<h5 class='bottom'><a href='url'>Headline</a></h5>
	<p>Tweet</p> 
</div>
-->

</div>