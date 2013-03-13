
<?php

$oldArticleType = $articleType;
if(strcmp($oldArticleType, "Editorial")!=0) {

#this is not an editorial.  display editorial teaser.

$sqlQuery = "
	select
		article.title, 
		substring(article.pullquote,1,133) as pullquote, 
		article.date, 
		article.section_id,
		section.name, 
		article.priority,
		articletype.name as type
	from 
		article,
		section,
		articletype
	where 
		article.section_id = section.id and
		article.type = articletype.id and 
		article.date='$currentDate' and 
		article.type = 2 and
		section.id < 6
	group by
		section.id
	order by
		section.order_flag

";

$res = mysql_query ($sqlQuery);

if ($row = mysql_fetch_array($res)) {

	$articleTitle = $row["title"];
	$articlePullquote = $row["pullquote"];
	$articleDate = $row["date"];
	$articleSectionID = $row["section_id"];
	$articleSection = $row["name"];
	$articlePriority = $row["priority"];
	$articleType = $row["type"];
}

}

$sqlQuery = "
	select
		article.title, 
		substring(article.pullquote,1,133) as pullquote, 
		article.date, 
		article.section_id,
		section.name, 
		article.priority,
		article.type
	from 
		article,
		section
	where 
		article.section_id = section.id and
		article.date='$currentDate' and 
		article.type != 2 and
		(
# including the following line gives the next article in the section rather than omitting the section altogether.
#		article.priority != '$priority' or 
		article.section_id != '$section'
		) and
		section.id < 6
	group by
		section.id
	order by
		section.order_flag

";

$res = mysql_query ($sqlQuery);


if(strcmp($oldArticleType, "Editorial")!=0) {
#this is not an editorial.  display editorial teaser.

?>
    
<!-- start editorial -->
         <table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#000000">
                    <tr>
                      <td>
					  
	<table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#CCCCCC">
                          <tr>
                            <td><p><font class="articlealsosection"><a class="articlealsosection" href="article.php?section=<?php echo "$articleSectionID&date=$articleDate&id=$articlePriority" ?>"><?php echo $articleType ?></a><br>
                                <br>
                                </font><font class="articlealsoheadline"><a class="articlealsoheadline" href="article.php?section=<?php echo "$articleSectionID&date=$articleDate&id=$articlePriority" ?>"><?php echo $articleTitle ?></a></font><br>
                                <font class="articlealsotexteditorial"><?php echo removeLastWord($articlePullquote) ?>... </font><font class="articlealsolink"><a class="articlealsolink" href="article.php?section=<?php echo "$articleSectionID&date=$articleDate&id=$articlePriority" ?>">Read</a></font></p>
                              </td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>				  
<!-- spacer table between article boxes -->
<table height="14" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td></td>
  </tr>
</table>
<!-- end editorial -->
<?php
}
?>
<?php
while ($row = mysql_fetch_array($res)) {
	$articleTitle = $row["title"];
	$articlePullquote = $row["pullquote"];
	$articleDate = $row["date"];
	$articleSectionID = $row["section_id"];
	$articleSection = $row["name"];
	$articlePriority = $row["priority"];
	$articleType = $row["type"];
?>
<table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#CCCCCC">
                    <tr>
                      <td>
					  
					  <table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF">
                          <tr>
                            <td><p><font class="articlealsosection"><a class="articlealsosection" href="section.php?section=<?php echo "$articleSectionID&date=$articleDate" ?>"><?php echo $articleSection ?></a><br>
                                <br>
                                </font><font class="articlealsoheadline"><a class="articlealsoheadline" href="article.php?date=<?php echo "$articleDate&section=$articleSectionID&id=$articlePriority" ?>"><?php echo $articleTitle ?></a></font><br>
                                <font class="articlealsotext"><?php echo removeLastWord($articlePullquote) ?>... </font><font class="articlealsolink"><a class="articlealsolink" href="article.php?date=<?php echo "$articleDate&section=$articleSectionID&id=$articlePriority" ?>">Read</a></font></p>
                              </td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
				  
				  <table height="14" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td></td>
  </tr>
</table>
<?php 
} // end while
?>
