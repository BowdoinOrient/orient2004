<?php
include("start.php");
#change first false to true gives date
#change second false to true gives "In the current Orient"
startcode("The Bowdoin Orient - Staff and Writers", false, false, $articleDate, $issueNumber, $volumeNumber);
?>

<!-- Start -->

            <font class="pagetitle">Staff and Writers</font> 
            <p> <font class="textbold">The Editorial Staff</font></p>

	<div align="center"><font class="staffpagetitles">Editors-in-Chief</font><br />
                    <font class="text">Nick Day<br />Mary Helen Miller</font>

		<p><font class="staffpagetitles">Senior Editors</font><br />
			<font class="text">Adam Kommel<br />Cati Mitchell</font></p>
		

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr valign="top"> 
		<td style="text-align: center" width="30%">
			<p><font class="staffpagetitles">News Editor</font><br /><font class="text">Gemma Leghorn</font></p>
            <p><font class="staffpagetitles">Features Editor</font><br /><font class="text">Cameron Weller</font></p>
			<p><font class="staffpagetitles">Sports Editor</font><br /><font class="text">Seth Walder</font></p>
			<p><font class="staffpagetitles">Calendar Editor</font><br /><font class="text">Alex Porter</font></p>
            <p><font class="staffpagetitles">Opinion Editor</font><br /><font class="text">Piper Grosswendt</font></p>
		</td>
        <td style="text-align: center">
			<p><font class="staffpagetitles">Senior News Staff</font><br /><font class="text">Nat Herz<br />Caitlin Beach<br />Emily Guerin</font></p>
			<p><font class="staffpagetitles">A&E Editor</font><br /><font class="text">Carolyn Williams</font></p>
			<p><font class="staffpagetitles">Business Manager</font><br /><font class="text">Jessica Haymon Gorlov</font></p>
			<p><font class="staffpagetitles">Assistant Business Manager</font><br /><font class="text">Lizzy Tarr</font></p>
						
		</td>
        <td style="text-align: center" width="30%">
        	<p><font class="staffpagetitles">News Staff</font><br />
				<font class="text">Anya Cohen<br />
				Claire Collery<br />
				Nick Daniels<br />
				Peter Griesmer<br />
				Zo&euml; Lescaze<br />
				Toph Tucker</font>
			</p>
			<p><font class="staffpagetitles">Photo Editor</font><br /><font class="text">Margot D. Miller</font></p>
			<p><font class="staffpagetitles">Assistant Photo Editor</font><br /><font class="text">Mariel Beaudoin</font></p>
		</td>
	</tr>
	<tr valign="top">
		<td colspan="3"><div align="center"><p><font class="staffpagetitles">Website Manager</font><br /><font class="text">Seth Glickman</font></p></td>
	</tr>
	<tr valign="top"> 
		<td colspan="3"><div align="center"><font class="text"><br />For information on contacting the <i>Orient,<br /></i>please see the <a href="/orient/contact.php">contact page</a>.</font></div></td>
    </tr>
</table>

<?php
$lastVolQuery = "SELECT id, numeral FROM volume ORDER BY id DESC LIMIT 0,1";
$lastVolResults = mysql_query($lastVolQuery);
$lastVolumeID = mysql_result($lastVolResults, 0, "id");
$lastVolumeNumeral = mysql_result($lastVolResults, 0, "numeral");

?>


         
            <p><font class="textbold">Current Staff Pages</font></p>
			<p><font class="text">This is a list of everyone who has contributed to Volume <b><?php echo $lastVolumeNumeral;?></b> of <i>The Orient</i> (the most recent volume).  To see the work of a specific staff member or contributor, click on the name below.  If you do not see the name you are looking for, you can try the <a href="fullstaff.php">Full Contributor Page</a>, or the <a href="search.php">search page</a>.</font></p>
            
<!-- <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr valign="top"> 
    <td><p align="left"><font class="text">

<?php
/* $sqlQuery = "
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
} */
?>

</font></p></td>
  </tr>
</table> -->

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr valign="top"> 
    <td><p align="left"><font class="text">
<?php

$sqlQuery = "
	select
		author.name,
		author.id
	from
		author,
		article,
		issue
	where
		name != '' and
		article.date = issue.issue_date and
		issue.volume_id = $lastVolumeID
		and (article.author1 = author.id or article.author2 = author.id or article.author3 = author.id) and
		active = 'y'
	GROUP BY 
		author.id
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

	
	

<!-- Stop -->

<?php
include("stop.php");
?>