<?php 

function commentForm() { ?>
	
	<div class='comment-form'>
		<table>
			<tr>
				<td><label>Username: <div><input type='text' name='username' id='username' /></div></label></td>
			</tr>
			<tr>
				<td><label>Password: <div><input type='password' name='password' id='password' /></div></label></td>
			</tr>
			<tr>
				<td><label>Comment (note that HTML is disabled): <br /><textarea name='comment' id='comment' ></textarea></label></td>
			</tr>
			<tr>
				<td><button id='submitComment' onclick='submitComment();'>Submit Comment</button></td>
			</tr>
		</table>
		<div>You must have a Bowdoin login in order to comment.  If you do not, there are a number of other ways to <a href='contact.php'>contact us</a>.</div>
		<br />
	</div>
<?php }

function editCommentForm() { ?>
	
	<div id='edit-comment' class='comment-form span-10'>
		<table>
			<tr>
				<td><label>Username (required): <div><input type='text' name='editusername' id='editusername' /></div></label></td>
			</tr>
			<tr>
				<td><label>E-mail address: <div><input type='text' name='editemail' id='editemail' /></div></label></td>
			</tr>
			<tr>
				<td><label>Comment (note that HTML is disabled): <br /><textarea name='editcomment' id='editcomment' ></textarea></label></td>
			</tr>
			<tr>
				<td><button id='submitedit' onclick='submitEdit();'>Edit Comment</button></td>
			</tr>
		</table>
	</div>
<?php }

function setSetting($name, $value, $int=false) {
	$intValue = "NULL";
	$stringValue = "'" . mysql_real_escape_string($value) . "'";
	$name = "'" . mysql_real_escape_string($name) . "'";
	if ($int) {
		$intValue = $value;
		$stringValue = "NULL";
	}
	$query = 
		"SELECT
			*
		FROM
			settings
		WHERE
			name=$name
		";
	if (mysql_num_rows(mysql_query($query)) == 0) {
		// Then we have to insert it
		$query = 
			"INSERT INTO 
				settings
				(`int_value`, `string_value`, `name`)
			VALUES
				($intValue, $stringValue, $name)
			";
		return mysql_query($query);
	} else {
		// Otherwise we update the value
		$query = 
			"UPDATE
				settings
			SET 
				int_value=$intValue,
				string_value=$stringValue
			WHERE
				name=$name
			";
		return mysql_query($query);
	}
}

function getSetting($name, $defaultValue, $int = false) {
	// Pulls a setting out of the mysql database. Defaults to $defaultValue,
	// and since the setting can be either an int or a string, there's a flag.
	// Defaults to string value.
	$vtype = 'string_value';
	if ($int) {
		$vtype = 'int_value';
	}
	$results = mysql_query("SELECT $vtype FROM settings WHERE name='$name';");
	if (mysql_num_rows($results) == 0) {
		return $defaultValue;
	} else {
		return mysql_result($results, 0, $vtype);
	}
}

function spacer() {
	echo "<div class='spacer'></div>";
}

function echoMedia($date, $section, $id) {
	// Gets photos, links, and related documents, and displays them in a little media box.
	$photos = photoQuery($date, $section, $id);
	$docs = docQuery($date, $section, $id);
	$links = linkQuery($date, $section, $id);
	
	if (mysql_num_rows($links) > 0) {
		$anylinks = true;
	}

	if (mysql_num_rows($docs) > 0) {
		$anydocuments = true;
	}
	
	$gallery = " rel='lightbox'";
	if (mysql_num_rows($photos) > 1) {
		$multiplePhotos = true;
		$numPhotos = mysql_num_rows($photos);
		$gallery = ' rel="lightbox[gallery]"';
	}
	if ($row = mysql_fetch_array($photos)) {
		$anyphotos = true;
		$articleImage = $row['article_filename'];
		$largeImage = $row["large_filename"];
		$photoCredit = $row['photographer'];
		if ($photoCredit) {
			$photoCredit .= ", The Bowdoin Orient";
			$photographerlink = true;
		} else {
			$photoCredit = $row['credit'];
		}
		$photoCaption = $row["caption"];
		$photoCaption = str_replace("<b>", "<span class=\"caps\">", $photoCaption);
		$photoCaption = str_replace("</b>", "</span>", $photoCaption);
		$photoCaption = str_replace("'", "&#39;", $photoCaption);
		$photographerID = $row["authorid"];
	}
	if ($anyphotos or $anydocuments or $anylinks) { ?>
		<div class='articlemedia'>
<?php 	if ($anyphotos) { ?>
			<a href='../images/<?php echo "$date/$largeImage"; ?>' title='<?php echo getLightboxTitle($photoCaption, $photoCredit); ?>' class='lightbox'<?php echo $gallery; ?>><img src='../images/<?php echo "$date/$articleImage"; ?>' alt='<?php echo getLightboxTitle($photoCaption, $photoCredit); ?>'></a>
			<div class='photocredit last'>
<?php if ($photographerlink) {?>
					<a href='authorpage.php?authorid=<?php echo $photographerID ;?>'>
<?php }
	echo strtoupper($photoCredit);
	if ($photographerlink) {
		echo "</a>";
	} ?>
			<?php if ($multiplePhotos) { ?><br />Picture 1 of <?php echo $numPhotos; } ?></div>
			<div class='photocaption last'>
				<?php echo $photoCaption; ?>
			</div>
<?php }
						if ($anydocuments) { ?>
						<div class='othermedia'>
							<h5>Related Documents</h5>
							<ul>
<?php
		while($row = mysql_fetch_array($docs)) {
			$label = $row['label'];
			$url = $row['url']; ?>
								<li><a href='../related/<?php echo "$date/$url";?>'><?php echo $label; ?></a></li>
<?php } ?>							</ul>
						</div>
<?php 	}
	if ($anylinks) { ?>
						<div class='othermedia'>
							<h5>Related Links</h5>
							<ul>
<?php
		while($row = mysql_fetch_array($links)) {
			$label = $row['label'];
			$url = $row['url']; ?>
								<li><a href='<?php echo $url; ?>'><?php echo $label; ?></a></li>
<?php 		} ?>							</ul>
						</div>
<?php 	} ?>
		</div>
<?php } // End "if ($anyphotos or $anydocuments or $anylinks)"					
	 if ($multiplePhotos) { ?>
		<div class='morephotos'>
			<?php
				while ($row = mysql_fetch_array($photos)) {
					$articleImage = $row['article_filename'];
					$largeImage = $row["large_filename"];
					$photoCredit = $row['photographer'];
					if ($photoCredit) {
						$photoCredit .= ", The Bowdoin Orient";
						$photographerlink = true;
					} else {
						$photoCredit = $row['credit'];
					}
					$photoCaption = $row["caption"];
					$photoCaption = str_replace("<b>", "<span class=\"caps\">", $photoCaption);
					$photoCaption = str_replace("</b>", "</span>", $photoCaption);
					$photoCaption = str_replace("'", "&#39;", $photoCaption);
					?>
					<a href='../images/<?php echo "$date/$largeImage"; ?>' title='<?php echo getLightboxTitle($photoCaption, $photoCredit); ?>' class='lightbox'<?php echo $gallery; ?>><img src='../images/<?php echo "$date/$articleImage"; ?>' alt='<?php echo getLightboxTitle($photoCaption, $photoCredit); ?>'></a>
<?php 							} ?>
		</div>
	<?php }
}

function echoSidebarArticle($row, $sectionname, $editorial) {
	// Prints an article to the sidebar.  Intended for "In the current Orient" column on the right.
	$classname = 'sidebararticle';
	if ($editorial) {
		$sectionname = "EDITORIAL";
		$classname=' sidebareditorial';
	}
	$title = $row['title'];
	$section = $row['section_id'];
	$priority = $row['priority'];
	$blurb = $row['pullquote'];
	$blurb = substr($blurb, 0, 150);
	$blurb = substr($blurb, 0, strrpos($blurb, " "));
	$lastchar = substr($blurb, strlen($blurb) - 1);
	if ($lastchar == ";" or $lastchar == "," or $lastchar == "-") {
		$blurb = substr($blurb, 0, strlen($blurb) - 1);
	}
	$date = $row['articledate'];
	?>
	
	<div class='<?php echo $classname; ?>'>
		<h4><a href='section.php?section=<?php echo $section; ?>'><?php echo strtoupper($sectionname); ?></a></h4>
		<h5 class='bottom'><a href='<?php echo articleLink($date, $section, $priority); ?>'><?php echo $title; ?></a></h5>
		<p><?php echo $blurb; ?> ... <a href="<?php echo articleLink($date, $section, $priority); ?>">Read</a></p>
	</div>
	

<?php }

function authorsLinks($a1, $a2, $a3, $id1, $id2, $id3, $job) {
	// Returns the authors string with a link to their page if needed
	$authors = "";
	if ($a1) {
		$authors = "By ";
		if ($id1) {
			$authors .= "<a href='authorpage.php?authorid=$id1'>";
		}
		$authors .= $a1;
		if ($id1) {
			$authors .= "</a>";
		}
	}
	if ($a2) {
		$authors .= " and ";
		if ($id2) {
			$authors .= "<a href='authorpage.php?authorid=$id2'>";
		}
		$authors .= $a2;
		if ($id2) {
			$authors .= "</a>";
		}
	}
	if ($a3) {
		$authors .= " and ";
		if ($id3) {
			$authors .= "<a href='authorpage.php?authorid=$id3'>";
		}
		$authors .= $a3;
		if ($id3) {
			$authors .= "</a>";
		}
	}
	return "<p class='bottom'>" . $authors . "</p><span class='top job'>" . strtoupper($job) . "</span>";
}

function echoArticleOptions($date, $section, $id, $title) { ?>
	<div class='articleoptions'>
		<ul class='morestories'>
			<li>ARTICLE OPTIONS</li>
			<li><a onclick='rs("ss", this.getAttribute("href"), 600, 600); return false;' href='../emailarticle.php?date=<?php echo $date; ?>&amp;section=<?php echo $section; ?>&amp;id=<?php echo $id; ?>'>E-mail this article</a></li>
			<li><a href="http://www.facebook.com/share.php?u=<url>" onclick="return fbs_click()" target="_blank">Share on Facebook</a></li>
			<li><a href='printer.php?date=<?php echo $date; ?>&amp;section=<?php echo $section; ?>&amp;id=<?php echo $id; ?>'>Printer-friendly version</a></li>
			<li><a href=''>Send a letter to the editor</a></li>
		</ul>
	</div>
<?php }

function authors($a1, $a2, $a3, $job) {
	// Returns a string of the authors.
	$authors = "";
	if ($a1) {
		$authors = "By " . strtoupper($a1);
	}
	if ($a2) {
		if (!$a3) {
			$authors .= " AND " . strtoupper($a2);
		} else {
			$authors .= ", " . strtoupper($a2);
		}
	}
	if ($a3) {
		$authors .= " AND " . strtoupper($a3);
	}
	if ($authors) {
		$authors .= ", " . strtoupper($job);
	}
	return $authors;
}

function more_news($result, $skipPriority, $dontskip) {
	// Returns the HTML to print out the "MORE _____" list
	global $date;
	while ($row = mysql_fetch_array($result)) {
		$articleSection=$row["section_id"];
		$articlePriority=$row["priority"];
		if ($articlePriority == $skipPriority and !$dontskip) {
			continue;
		}
		$articleTitle = $row["title"];
		$articleSeries = $row["series"];
		$articleType = $row["type"];
		if(strcmp($articleSeries, "") != 0) {
			$articleSeries = "<span class='articleprefix'>$articleSeries:</span> ";
		}
		if(strcmp($articleType, "") != 0) {
			$articleType = "<span class='articleprefix'>$articleType:</span> ";
		}?>
		<li><a href='<?php echo articleLink($date, $articleSection, $articlePriority)?>'><?php echo $articleSeries . $articleType . $articleTitle; ?></a></li>
		<?php
	}
}

function getEditorials($date) {
	$query = 
	"SELECT
		section_id,
		priority,
		a1.name AS author1,
		a2.name AS author2,
		a3.name AS author3,
		job.name AS jobname,
		article.date AS articledate,
		article.title,
		article.pullquote,
		series.name AS series,
		articletype.name AS type
	FROM
		article
	INNER JOIN job ON article.author_job = job.id
	INNER JOIN series ON article.series = series.id
	INNER JOIN articletype ON article.type = articletype.id
	INNER JOIN author a1 ON article.author1 = a1.id
	INNER JOIN author a2 ON article.author2 = a2.id
	INNER JOIN author a3 ON article.author3 = a3.id
	WHERE article.date = '$date'
	AND article.section_id = '2'
	AND article.type = '2'
	ORDER BY article.priority
	";
	return mysql_query($query);
}

function getSectionArticles($section, $date, $noneditorials) {
	// Returns a mysql result of a query pulling articles from a specific section
	$query = 
	"SELECT
		section_id,
		priority,
		a1.name AS author1,
		a2.name AS author2,
		a3.name AS author3,
		job.name AS jobname,
		article.title,
		article.pullquote,
		series.name AS series,
		articletype.name AS type
	FROM
		article
	INNER JOIN job ON article.author_job = job.id
	INNER JOIN series ON article.series = series.id
	INNER JOIN articletype ON article.type = articletype.id
	INNER JOIN author a1 ON article.author1 = a1.id
	INNER JOIN author a2 ON article.author2 = a2.id
	INNER JOIN author a3 ON article.author3 = a3.id
	WHERE article.date = '$date' ";
	if ($noneditorials) {
		$query .= "AND article.type != '2' ";
	}
	$query .= 
	"AND article.section_id = '$section'
	ORDER BY article.priority
	";
	return mysql_query($query);
}

function getFeaturePhoto($date) {
	// Grabs the featured photo for a given issue.
	// Probably shouldn't use all these globals; what it should do is just echo the actual photo code.  Oh well.
	global $anyPhotos, $multiplePhotos, $relatedArticle, $photoFilename, $photoLargeFilename, $photoSection, $photoFeatureSection, $photoPriority, $photographer, $photographerlink, $photoCredit, $photoCaption, $photographerID;
	$sqlQuery = 
	"SELECT
		p.article_section,
		p.article_priority,
		p.large_filename, 
		p.ffeature_filename,
		a.name AS photographer,
		p.caption,
		p.credit,
		p.feature_section,
		a.id
	FROM
		photo p,
		author a
	WHERE
		p.photographer = a.id AND
		p.article_date = '$date' AND 
		p.feature = 'y' AND
		p.feature_section  = '10'
	";

	$result = mysql_query($sqlQuery);
	$anyPhotos = false;
	$multiplePhotos = false;
	$relatedArticle = true;

	if($row = mysql_fetch_array($result)) 
	{
		$anyPhotos = true;
		$photoFilename = $row["ffeature_filename"];
		$photoLargeFilename = $row["large_filename"];
		$photoSection = $row["article_section"];
	
		if($photoSection == 0) 
		{
			$relatedArticle = false;
		}

		$photoFeatureSection = $row["feature_section"];
		$photoPriority = $row["article_priority"];
		$photographer = $row["photographer"];

		if(strcmp($photographer, "") != 0) 
		{
			$photographer = "$photographer, The Bowdoin Orient";
			$photographerlink = true;
		}

		$credit = $row["credit"];
		$photoCredit = str_replace("'", "&#39;", "$photographer$credit");
		
		$photoCaption = $row['caption'];
		$photoCaption = str_replace("<b>", "<span class=\"caps\">", $photoCaption);
		$photoCaption = str_replace("</b>", "</span>", $photoCaption);
		$photoCaption = str_replace("'", "&#39;", $photoCaption);

		$photographerID = $row["id"];
		
		if(mysql_num_rows($result) > 1) 
			$multiplePhotos = true;
	}
	else 
	{
		echo "$sqlQuery<br>";
		echo mysql_error();
	}
	
}

function getTopStories($date, $number) {
	// Gets the most-viewed stories of a given issue
	$query = 
	"SELECT
		section_id, 
		priority, 
		author1, 
		author2, 
		author3, 
		title, 
		series.name AS series,
		articletype.name AS type,
		subhead, 
		pullquote, 
		views 
	FROM 
		article 
	INNER JOIN series ON article.series = series.id
	INNER JOIN articletype ON article.type = articletype.id
	WHERE date = '$date' 
	ORDER BY views DESC 
	LIMIT 0, $number
	";
	return mysql_query($query);
}

function articleLink($date, $section, $priority) {
	// In case the article link syntax changes in the future,
	// this is the one place to change it.
	return "article.php?date=$date&amp;section=$section&amp;id=$priority";
}

function commentLink($date, $section, $id) {
	return "viewcomments.php?date=$date&amp;section=$section&amp;id=$id";
}

function getLightboxTitle($caption, $credit) {
	// Any time you want to use a Lightbox effect for a photo with a caption and credits,
	// run it through this function first. 
	// The 's need to be escaped, and the <b> should be replaced with the caps class.
	$photographer = str_replace("'", "&#39;", $photographer);
	$photoCredit = str_replace("'", "&#39;", $credit);

	$photoCaption = str_replace("<b>", "", $caption);
	$photoCaption = str_replace("</b>", "", $photoCaption);
	$photoCaption = str_replace("<span class=\"caps\">", "", $photoCaption);
	$photoCaption = str_replace("</span>", "", $photoCaption);
	$photoCaption = str_replace("'", "&#39;", $photoCaption);
	return $photoCaption . "<br />" . $photoCredit . $photographer;
}

function photoQuery($date, $section, $priority) {
	$photoQuery = 
	"SELECT
		p.id,
		p.article_filename,
		p.thumb_filename,
		p.sfeature_filename,
		p.large_filename,
		p.ffeature_filename,
		a.name AS photographer,
		p.credit AS credit,
		concat(a.name, p.credit) AS alternatecredit,
		p.caption,
		p.article_date,
		p.article_section,
		p.article_priority,
		p.slideshow_id,
		p.article_photo_priority,
		p.slideshow_photo_priority,
		p.feature,
		p.feature_section,
		a.id AS authorid
	FROM
		photo p,
		author a
	WHERE
		p.photographer = a.id AND 
		p.article_date = '$date' AND
		p.article_section = '$section' AND
		p.article_priority = '$priority'
	ORDER BY
		p.article_photo_priority
	";
	return mysql_query($photoQuery);
}

function linkQuery($date, $section, $id) {
	$query = 
	"SELECT		
		lk.linkname AS label,
		lk.linkurl AS url
	FROM 
		links lk
	WHERE
		lk.article_date = '$date' AND
		lk.article_section = '$section' AND 
		lk.article_priority = '$id'
	";
	return mysql_query($query);
}

function docQuery($date, $section, $id) {
	$query = 
	"SELECT		
		rl.label,
		rl.url
	FROM 
		related rl
	WHERE
		rl.article_date = '$date' AND
		rl.article_section = '$section' AND 
		rl.article_priority = '$id'
	";
	return mysql_query($query);
}

function thumbnailQuery($date, $section, $id) {
	// Formulates and executes a query looking for thumbnails for a given article.
	$thumbnailquery = 
	"SELECT 
		thumb_filename,
		large_filename,
		caption,
		credit,
		author.name AS photographer,
		author.id
	FROM
		photo, 
		author
	WHERE
		author.id = photo.photographer AND
		article_section = '$section' AND
		article_date = '$date' AND
		article_priority = '$id' AND
		(feature_section <> '$section' OR
			feature = 'n')
	";
	return mysql_query($thumbnailquery);
}

function echoSectionArticle($row) {
	// Prints an article to the page
	// Formatted for section.php
	global $date;
	$articleSection = $row['section_id'];
	$articlePriority = $row["priority"];
	$articleAuthor1 = $row["author1"];					
	$articleAuthor2 = $row["author2"];					
	$articleAuthor3 = $row["author3"];
	$articleJob = $row["jobname"];
	$articleTitle = $row["title"];
	$articlePullquote = $row["pullquote"];
	$thumbPosition = $row["thumb_position"];
	$articleSeries = $row["series"];
	$articleType = strtoupper($row["type"]);
	echo "<div class='sectionarticle'>";
	
	$thumbResult = thumbnailQuery($date, $articleSection, $articlePriority);
	if ($row = mysql_fetch_array($thumbResult)) {
		$thumbFilename = $row['thumb_filename'];
		$largeFilename = $row['large_filename'];
		$photoCredit = $row['photographer'];
		if ($photoCredit) {
			$photoCredit .= ", The Bowdoin Orient";
		} else {
			$photoCredit = $row['credit'];
		}
		$photoCaption = $row['caption'];
		$photoTitle = getLightboxTitle($photoCaption, $photoCredit);
	}
	
	if ($articleSeries) {
		$articleSeries = "<span class='articleprefix'>$articleSeries: </span>";
	}
	
	if ($articleType) { ?>
		<span class='articletype'><?php echo $articleType; ?></span>
	<?php }
	if ($thumbFilename) { ?>
		<a class='articlethumb' href='<?php echo articleLink($date, $articleSection, $articlePriority); ?>'><img src='../images/<?php echo "$date/$thumbFilename"; ?>'></a>
		<!-- <a title='<?php echo $photoTitle; ?>' class='articlethumb modal' href='../images/<?php echo "$date/$largeFilename"; ?>'><img src='../images/<?php echo "$date/$thumbFilename"; ?>'></a> -->
	<?php } ?>
		<h3 class='articletitle'><a href='<?php echo articleLink($date, $articleSection, $articlePriority); ?>'><?php echo $articleSeries . $articleTitle; ?></a></h3>
		<span class='articlecredit'><?php echo authors($articleAuthor1, $articleAuthor2, $articleAuthor3, $articleJob); ?></span>
		<p><?php echo $articlePullquote; ?></p>
		</div>
<?php }

function getEvents($day) {
	global $date;
	$eventsQuery = 
	"SELECT
		date_format(event.event_date, '%M %e, %Y') AS edate,
		event.event_priority,
		event.title,
		event.description,
		event.timeplace,
		daydate.day
	FROM
		event
	INNER JOIN
		daydate
	ON
		(event.event_date = daydate.date)
	WHERE
		event.issue_date = '$date' AND
		daydate.day = '$day'
	ORDER BY
		event.event_date, event.event_priority
	";
	return mysql_query($eventsQuery);
}

function echoEvent($name, $desc, $place) {
	?>
	<h3 class='articletitle'><?php echo $name; ?></h3>
	<p class='bottom'><?php echo $desc; ?></p>
	<p class='eventplace top'><?php echo $place; ?></p>
<?php }

function echoAuthorArticle($row) {
	$date = $row['date'];
	$section = $row['section_id'];
	$id = $row['priority'];
	$fancydate = $row['fancydate'];
	$job = $row['jobname'];
	$title = $row['title'];
	$author1 = $row['author1'];
	$author2 = $row['author2'];
	$author3 = $row['author3'];?>
	<h3 class='articletitle'><a href='<?php echo articleLink($date, $section, $id); ?>'><?php echo $title; ?></a></h3>
	<span class='articlecredit'><?php echo authors($author1, $author2, $author3, $job); ?></span>
	<h5 class='articledate'><?php echo $fancydate; ?></h5>
<?php }

function echoAuthorPhoto($row) {
	$date = $row['article_date'];
	$credit = $row['photographer'];
	if ($credit) {
		$credit .= ", Bowdoin Orient";
	} else {
		$credit = $row['credit'];
	}
	echo "<a class='morephotos' rel='lightbox[gallery]' title='" . getLightboxTitle($row['caption'], $credit) . "' href='../images/$date/" . $row['large_filename'] . "'><img src='../images/$date/" . $row['thumb_filename'] . "'></a> ";
}

function echoArticle($row, $displayPhotos, $hidePullQuote) {
	// Prints an article to the page.
	// Intended for index.php.
	// The news section doesn't display photos for stories;
	// if you want a photo on it, set $displayPhotos to true.
	global $date;
	$articleSection = $row['section_id'];
	$articlePriority=$row["priority"];
	$articleAuthor1 = $row["author1"];					
	$articleAuthor2 = $row["author2"];					
	$articleAuthor3 = $row["author3"];
	$articleJob = $row["jobname"];
	$articleTitle = $row["title"];
	$articlePullquote = $row["pullquote"];
	$thumbPosition = $row["thumb_position"];
	$articleSeries = $row["series"];
	$articleType = strtoupper($row["type"]);
	$thumbResult = thumbnailQuery($date, $articleSection, $articlePriority);
	
	if ($row = mysql_fetch_array($thumbResult)) {
		$thumbFilename = $row['thumb_filename'];
		$largeFilename = $row['large_filename'];
		$photoCredit = $row['photographer'];
		if ($photoCredit) {
			$photoCredit .= ", The Bowdoin Orient";
		} else {
			$photoCredit = $row['credit'];
		}
		$photoCaption = $row['caption'];
		$photoTitle = getLightboxTitle($photoCaption, $photoCredit);
	}
	if(strcmp($articleType, "") != 0) { ?>
		<span class='articletype'><?php echo $articleType; ?></span>
	<?php } if ($thumbFilename and $displayPhotos) { ?>
		<a class='articlethumb' href='<?php echo articleLink($date, $articleSection, $articlePriority); ?>'><img src='../images/<?php echo "$date/$thumbFilename"; ?>'></a>
		<!-- <a title='<?php echo $photoTitle; ?>' class='articlethumb modal' href='../images/<?php echo "$date/$largeFilename"; ?>'><img src='../images/<?php echo "$date/$thumbFilename"; ?>'></a> -->
	<?php } ?>
		<h3 class='articletitle'><a href='<?php echo articleLink($date, $articleSection, $articlePriority); ?>'><?php echo $articleTitle; ?></a></h3>
		<span class='articlecredit'><?php echo authors($articleAuthor1, $articleAuthor2, $articleAuthor3, $articleJob);?></span>
		<?php if (!$hidePullQuote) { ?><p><?php echo $articlePullquote; ?></p><?php } ?>
<?php } ?>