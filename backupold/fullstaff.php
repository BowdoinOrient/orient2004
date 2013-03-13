<?php 
include("start.php");
startcode("The Bowdoin Orient - Full Staff and Contributor List", false, false, $articleDate, $issueNumber, $volumeNumber);
?>
            <font class="pagetitle">Full Staff and Contributor List</font>
            
            <p style="text-align:center;"><font class="text">This page contains a list of everyone who has worked at or contributed to <i>The Orient</i>.  To see the work of a 
              specific staff member or contributor, click on the name below. If you do not find the name you are looking for, try our <a href="/orient/search.php">search page</a>.</font></p>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr valign="top"> 
    <td><p align="left"><font class="text">
<?php
$sqlQuery = "
	select
		name,
		id
	from
		author
	where
		name != '' and
		active = 'y'
	order by
		name
";
$result = mysql_query($sqlQuery);
while($row = mysql_fetch_array($result)) {
	$authorName = $row["name"];
	$authorID = $row["id"];
?>
        <a href="authorpage.php?authorid=<?php echo $authorID ?>"><?php echo $authorName ?></a><br />
<?php
}
?>
</font></p></td>
  </tr>
</table>

<?php
include("stop.php");
?>