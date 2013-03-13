<?php
	include("start.php");
	startcode("The Bowdoin Orient - Search", false, false, $articleDate, $issueNumber, $volumeNumber);
?>
<font class="pagetitle">Search</font> 
<p><font class="text"><strong>1) Search <i>The Bowdoin Orient</i>:</font></strong></p>		  
<div style="margin: 15px; font-size: 8pt"> 
	<form method="GET" action="searchresults.php">
		<input type="text" name="search" size="30">
		<input type="submit" value="Search">
		<div style="font-size: 10pt">Sort by: <input type="radio" name="sortby" value="relevance" checked="checked"> Relevance <input type="radio" name="sortby" value="date"> Date</div> 
		<SELECT name="section" id="section">
			<option value="0">Search All</option>
			<option value="1">News</option>
			<option value="2">Opinion</option>
			<option value="3">Features</option>
			<option value="4">Arts & Entertainment</option>
			<option value="5">Sports</option>
			<option value="7">Editorials</option>
			<option value="8">Letters</option>
		</SELECT>
	</form>
	This will only search material published on or after April 2, 2004.
</div>
<p><strong><font class="text">2) Browse our <a href="/orient/archives.php">archives</a>, 2000-Present.</font></strong></p>
<p><strong><font class="text">3) Try a Google&trade; search:</font></strong></p>
			
<!-- Search Google -->
<left>
<FORM method=GET action=http://www.google.com/custom>
<TABLE bgcolor=#FFFFFF cellspacing=0 border=0>
<tr valign=top><td>
<A HREF=http://www.google.com/search>
<IMG SRC=http://www.google.com/logos/Logo_40wht.gif border=0 ALT=Google align=middle></A>
</td>
<td>
<INPUT TYPE=text name=q size=31 maxlength=255 value="">
<INPUT type=submit name=sa VALUE="Google Search">
<INPUT type=hidden name=cof VALUE="S:http://orient.bowdoin.edu;GL:0;AH:left;LH:26;LC:#003366;L:http://orient.bowdoin.edu/orient/images/whiteminilogo.jpg;LW:277;AWFID:6f9be9270348b262;">
<input type=hidden name=domains value="orient.bowdoin.edu"><br><input type=radio name=sitesearch value=""> <font class="text">The Web <input type=radio name=sitesearch value="orient.bowdoin.edu" checked> orient.bowdoin.edu</font> 
</td></tr></TABLE>
</FORM>
</left>
<!-- Search Google -->

<font class="smalltext">Google is a trademark of Google Inc.</font>
<?php include("stop.php"); ?>