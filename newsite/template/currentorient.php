<?php
// This page provides the "In the current Orient" sidebar on the article pages.
// It's the first editorial, followed by the first of each of the sections.
// It avoids displaying the article you're already on - if you're on the first article of a given section,
// it will display the second article.
// Meant for a 5-block width.
?>
<div class='currentorientsidebar'>
<h3 class='currentOrientHeader'>In the current <span class='papertitle'>Orient</span></h3>
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
</div>