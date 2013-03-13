<?php 
	// All shared code goes in this file.  

	include("dbconnect.php");
	include("util.php");
	include("getcurrentdate.php");

	$date = $_GET['date'];
	$section = $_GET['section'];
	$priority = $_GET['id'];
	$authorID =  $_GET['authorid'];
	$seriesID = $_GET['seriesid'];
	$featureSection = $_GET['featuresection'];

	if(strcmp($date, "") == 0)
		$date = $currentDate;

	if(strcmp($section, "") == 0)
		$section = 1;

	if(strcmp($priority, "") == 0)
		$priority = 1;

	include("issuequery.php");

	function startcode($theTitle,$displayDate, $displayCurrentOrient, $articleDate, $issueNumber, $volumeNumber, $ignoreHomeLink = "no") 
	{
		global $searchString;

		?>
			<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
			<html>
				<head>
					<title><?php echo $theTitle ?></title>
					<style type="text/css" media="all">@import "browserupgrade.css";</style>
					<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
					<script type="text/javascript" src="lightbox/js/prototype.js"></script>
					<script type="text/javascript" src="lightbox/js/scriptaculous.js?load=effects"></script>
					<script type="text/javascript" src="lightbox/js/lightbox.js"></script>

					<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="rss.php" />
		<?php
			# This checks if the domain requested is studorgs.bowdoin.edu and tells search engines not to index the page if it is.   
			if(strcmp($_SERVER["HTTP_HOST"], "studorgs.bowdoin.edu") == 0)
				echo '<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';
			if(strcmp($_SERVER["HTTP_HOST"], "www.wbor.org") == 0)
				echo '<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';
		?>
			<link href="/orient/orient2.css" rel="stylesheet" type="text/css">
			<script language="javascript">
				var remote = null;
				
				function rs(n,u,w,h) 
				{
					remote = window.open(u, n, 'width=' + w + ',height=' + h +',resizable=yes,scrollbars=yes');
					
					if(remote != null) 
					{
						if(remote.opener == null)
							remote.opener = self;
						
						remote.location.href = u;
					}
							
					remote.focus();
				}
			</script>
		</head>
		<body leftMargin="0" topMargin="0" marginwidth="0" marginheight="0">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><a href="/orient/"><img src="/orient/images/orienthead.jpg" alt="The Bowdoin Orient" border="0"></a></td>
				</tr>
			</table>
			<table width="775" border="0" cellspacing="0" cellpadding="0">
				<tr> 
					<td height="1" bgcolor="#000000"></td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr bgcolor="CCCCCC"> 
								<td width="34%" height="20"><font class="headertext">&nbsp;&nbsp;Bowdoin College, Brunswick, Maine</font></td>
								<td><div align="right"><font class="headertext"> The Oldest Continuously Published College Weekly in the U.S.&nbsp;&nbsp;</font></div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr> 
					<td height="1" bgcolor="#000000"></td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr> 
								<td width="244" height="40" bgcolor="003366">
									<form method="GET" action="searchresults.php" id="searchForm" style="margin: 0; padding: 0">
										&nbsp;&nbsp;<input name="search" type="text" value="<?php echo htmlspecialchars($searchString); ?>" size="20" maxlength="200" style="width:150px;"> 
										<input type="hidden" name="sortby" value="relevance" />
										<input type="hidden" name="section" value="0" />
										&nbsp;<input type="image" src="/orient/images/search.jpg" align="absmiddle" alt="Search">
										
									</form>	
								</td>
								<td width="170" height="40"><div align="left"><img src="/orient/images/corner.jpg" width="50" height="40" alt=""></div></td>
							<?php if($displayDate == true) { ?>
								<td width="347" align="center" valign="middle">
									<?php displayIssueAndDate($volumeNumber, $issueNumber, $articleDate) ?>
								</td>
							<?php } else { if($displayCurrentOrient==true) { ?>
								<td width="202" align="center" valign="middle"></td>
								<td width="145" align="center" valign="bottom"><img src="/orient/images/thisweek.jpg"></td>
							<?php } else { ?>
								<td width="347">&nbsp;</td>
							<?php } } ?>
								<td width="14" align="center" valign="middle"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">
						<!-- 775 -->
						<table width="775" border="0" cellspacing="0" cellpadding="0">
							<tr> 
							    <!-- 113 -->
								<td width="125" valign="top" bgcolor="#CCCCCC"> <div align="left"> 
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="1" bgcolor="#FFFFFF"></td>
										</tr>
									</table>
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="13" bgcolor="#CCCCCC"></td>
										</tr>
									</table>
								<?php if(strcmp($ignoreHomeLink,"yes")!=0) { ?>
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="1" bgcolor="#FFFFFF"></td>
										</tr>
									</table>
									<table width="100%" height="22" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td bgcolor="#003366"><font class="tocitem">&nbsp;<a class="tocitem" href="/orient/">Home</a></font></td>
										</tr>
									</table>
								<?php } ?>
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="1" bgcolor="#FFFFFF"></td>
										</tr>
									</table>
									<table width="100%" height="22" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td bgcolor="#003366"><font class="tocitem">&nbsp;<a class="tocitem" href="/orient/section.php?section=1">News</a></font></td>
										</tr>
									</table>
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="1" bgcolor="#FFFFFF"></td>
										</tr>
									</table>
				  
									<table width="100%" height="22" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td bgcolor="#003366"><font class="tocitem">&nbsp;<a class="tocitem" href="/orient/section.php?section=3">Features</a></font></td>
										</tr>
									</table>
				 
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="1" bgcolor="#FFFFFF"></td>
										</tr>
									</table>
	 
									<table width="100%" height="22" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td bgcolor="#003366"><font class="tocitem">&nbsp;<a class="tocitem" href="/orient/section.php?section=2">Opinion</a></font></td>
										</tr>
									</table>
				 
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="1" bgcolor="#FFFFFF"></td>
										</tr>
									</table>

									<table width="100%" height="22" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td bgcolor="#003366"><font class="tocitem">&nbsp;<a class="tocitem" href="/orient/section.php?section=4">Arts</a></font></td>
										</tr>
									</table>
				 
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="1" bgcolor="#FFFFFF"></td>
										</tr>
									</table>
				  
									<table width="100%" height="22" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td bgcolor="#003366"><font class="tocitem">&nbsp;<a class="tocitem" href="/orient/section.php?section=5">Sports</a></font></td>
										</tr>
									</table>
				 
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="1" bgcolor="#FFFFFF"></td>
										</tr>
									</table>
				  
									<table width="100%" height="22" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td bgcolor="#003366"><font class="tocitem">&nbsp;<a class="tocitem" href="/orient/events.php">Events</a></font></td>
										</tr>
									</table>
				  
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="1" bgcolor="#FFFFFF"></td>
										</tr>
									</table>

									<table width="100%" height="22" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td bgcolor="#003366"><font class="tocitem">&nbsp;<a class="tocitem" href="/orient/photos.php">Photos</a></font></td>
										</tr>
									</table>
				  
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="1" bgcolor="#FFFFFF"></td>
										</tr>
									</table>
				  
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="13" bgcolor="#CCCCCC"></td>
										</tr>
									</table>
				  
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="1" bgcolor="#FFFFFF"></td>
										</tr>
									</table>
				  
									<table width="100%" height="22" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td bgcolor="#003366"><font class="tocitem">&nbsp;<a class="tocitem" href="/orient/about.php">About</a></font></td>
										</tr>
									</table>
				  
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="1" bgcolor="#FFFFFF"></td>
										</tr>
									</table>
				  
									<table width="100%" height="22" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td bgcolor="#003366"><font class="tocitem">&nbsp;<a class="tocitem" href="/orient/advertise.php">Advertise</a></font></td>
										</tr>
									</table>
				  
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="1" bgcolor="#FFFFFF"></td>
										</tr>
									</table>
				  
									<table width="100%" height="22" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td bgcolor="#003366"><font class="tocitem">&nbsp;<a class="tocitem" href="/orient/archives.php">Archives</a></font></td>
										</tr>
									</table>
				  
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="1" bgcolor="#FFFFFF"></td>
										</tr>
									</table>
				  
									<table width="100%" height="22" border="0" cellpadding="0" cellspacing="0">
										<tr>   
											<td bgcolor="#003366" height="14"><font class="tocitem">&nbsp;<a class="tocitem" href="/orient/contact.php">Contact Us</a></font></td>
										</tr>
									</table>
				  
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="1" bgcolor="#FFFFFF"></td>
										</tr>
									</table>
				  
									<table width="100%" height="22" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td bgcolor="#003366"><font class="tocitem">&nbsp;<a class="tocitem" 	href="/orient/search.php">Search</a></font></td>
										</tr>
									</table>
				  
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="1" bgcolor="#FFFFFF"></td>
										</tr>
									</table>
				  
									<table width="100%" height="22" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td bgcolor="#003366"><font class="tocitem">&nbsp;<a class="tocitem" href="/orient/staff.php">Staff and Writers</a></font></td>
										</tr>
									</table>
				  
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="1" bgcolor="#FFFFFF"></td>
										</tr>
									</table>
				  
									<table width="100%" height="22" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td bgcolor="#003366"><font class="tocitem">&nbsp;<a class="tocitem" href="/orient/subscribe.php">Subscribe</a></font></td>
										</tr>
									</table>

									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="1" bgcolor="#FFFFFF"></td>
										</tr>
									</table>

									<table width="100%" height="22" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td bgcolor="#003366"><div style="position: relative"><font class="tocitem">&nbsp;<a class="tocitem" href="/orient/rss.php">RSS Feed</a></font><div style="position: absolute; top: -2px; right: 3px"><a class="tocitem" href="/orient/rss.php"><img style="border: 0" src="/orient/images/rss.gif" /></a></div></div></td>
										</tr>
									</table>
				  
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="1" bgcolor="#FFFFFF"></td>
										</tr>
									</table>
				  
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="13" bgcolor="#CCCCCC"></td>
										</tr>
									</table>
				  
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="1" bgcolor="#FFFFFF"></td>
										</tr>
									</table>
				  
									<table width="100%" height="22" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td bgcolor="#003366"><font class="tocitem">&nbsp;Bowdoin Links</font></td>
										</tr>
									</table>
				  
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td bgcolor="#003366"><font class="link"><p>
												&nbsp;<a class="link" href="http://www.bowdoin.edu/dining/menus/">Dining Menus</a>
												<br>
												&nbsp;<a class="link" href="http://www.bowdoin.edu/directory/">College Directory</a>
												<br>
												&nbsp;<a class="link" href="http://webmail.bowdoin.edu/">Webmail</a> 
												<br>
												&nbsp;<a class="link" href="http://library.bowdoin.edu/">Library</a>
												<br>
												&nbsp;<a class="link" href="http://www.bowdoin.edu/studentrecords/bearings/">Bearings</a>
												<br>
												&nbsp;<a class="link" href="http://www.bowdoin.edu/athletics/">Athletics</a>
												<br>
												&nbsp;<a class="link" href="http://www.bowdoin.edu/">Bowdoin Home</a>
											</p></font></td>
										</tr>
									</table>
				  
									<table width="100%" height="6" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td bgcolor="#003366"></td>
										</tr>
									</table>
				  
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="1" bgcolor="#FFFFFF"></td>
										</tr>
									</table>  
							   
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td height="13"></td>
										</tr>
									</table>

									<?php 
										#includes PDF front page code, weather code
										include("homeleftbottom.php");
									?>
								</td>
								<td width="14" valign="top"></td>
								<td width="634" valign="top"> 
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
											<td height="14"></td>
										</tr>
									</table>
									<?php
										} #end startcode
?>