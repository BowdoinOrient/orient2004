<?php


#Connect to DB
include("dbconnect.php");
include("util.php");

$date = $_GET['date'];
$section = $_GET['section'];
$priority = $_GET['id'];

# Article Query
$sqlQuery = "



	select

		

		s.name as sectionname,

		ar.priority,
		ar.author1,

		a1.name as author1name,
		a1.photo as author1photo,
		ar.author2,
		a2.name as author2name,
		a2.photo as author2photo,
		ar.author3,
		a3.name as author3name,
		a3.photo as author3photo,

		j.name as jobname,

		ar.title,
		ar.subhead,

		ar.text,

		at.name as type,
		ar.pullquote

	from section s,
		article ar,
		author a1,
		author a2,
		author a3,
		job j,
		articletype at
	where
		ar.type = at.id and
		ar.author_job = j.id and
		ar.section_id = s.id and
		ar.author1 = a1.id and
		ar.author2 = a2.id and 
		ar.author3 = a3.id and
		ar.date = '$date' and
		ar.section_id = '$section' and 
		ar.priority = '$priority'
";


$result = mysql_query ($sqlQuery);



if ($row = mysql_fetch_array($result)) {

	$sectionName = $row["sectionname"];
	$articleAuthor1 = $row["author1name"];
	$articleAuthor2 = $row["author2name"];
	$articleAuthor3 = $row["author3name"];
	$articleAuthorID1 = $row["author1"];
	$articleAuthorID2 = $row["author2"];
	$articleAuthorID3 = $row["author3"];
	$articleAuthorPhoto1 = $row["author1photo"];
	$articleAuthorPhoto2 = $row["author2photo"];
	$articleAuthorPhoto3 = $row["author3photo"];
	$articleJob = $row["jobname"];
	$articleSubhead = $row["subhead"];

	$articleTitle = $row["title"];

	$articleCaption = $row["photo_caption"];

	$articlePhotoCredit = $row["photo_credit"];

	$articleText = $row["text"];

	$articleImage = $row["photo_filename"];

	$articlePhotoPosition = $row["photo_position"];
	$articleType = $row["type"];
	$articlePullquote = $row["pullquote"];

# change quotes in articletitle and articlepullquote
$old = array("\"");
$new = array("&quot;");
$newarticlepullquote = str_replace($old, $new, $articlePullquote);
$newarticleTitle = str_replace($old, $new, $articleTitle);

# remove <i> and </i> from articletitle and articlepullquote
$old2 = array("<i>", "</i>");
$new2 = array("", "");
$newarticleTitle2 = str_replace($old2, $new2, $newarticleTitle);

$title = "$sectionName - $articleTitle";


# Issue Query
$sqlQuery = "
	select
		date_format(article.date, '%M %e, %Y') as date,
		issue.issue_number,
		volume.numeral
	from article
	inner join issue on article.date = issue.issue_date
	inner join volume on issue.volume_id = volume.id
	where article.date = '$date'
";

$res = mysql_query ($sqlQuery);

if ($row = mysql_fetch_array($res)) {
	$articleDate = $row["date"];
	$issueNumber = $row["issue_number"];
	$volumeNumber = $row["numeral"];
}



?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>The Bowdoin Orient - Email Article</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link href="orient.css" rel="stylesheet" type="text/css">

<script type="text/javascript" language="JavaScript">
function CheckRequiredFields() {
var errormessage = new String();

if(WithoutContent(document.email.required_sendername.value))
	{ errormessage += "\n\nYour name"; }

if(WithoutContent(document.email.required_from.value))
	{ errormessage += "\n\nYour email address"; }

if(WithoutContent(document.email.required_to.value))
	{ errormessage += "\n\nRecipient's email address"; }

if(errormessage.length > 2) {
	alert('YOU HAVE LEFT THE FOLLOWING REQUIRED FIELDS BLANK:' + errormessage);
	return false;
	}
return true;

} // end of function CheckRequiredFields()

function WithoutContent(ss) {
if(ss.length > 0) { return false; }
return true;
}

</script>

</head>

<body class="email" leftMargin=0 topMargin=0 marginwidth="0" marginheight="0">

<div align="center"> 
  <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#003366">
    <tr>
      <td height="50"><div align="center"><img src="images/minilogo.jpg" align="middle"></div></td>
    </tr>
  </table>

<table width="100%" border="0" cellspacing="0" cellpadding="5"><tr><td>

<FORM METHOD="POST" NAME="email" onSubmit="return CheckRequiredFields()"
 ACTION="/cgi-bin/cgiemail/cgiemail/orient/docs/emailarticle.cetf">

          <table width="100%" border="0" cellspacing="2" cellpadding="5">
            <tr valign="top"> 
              <td colspan="2" bgcolor="#FFFFFF"><font class="textbold"><font class="pagetitle">Email This Article</font>
<table width="100%" border="0" cellspacing="0" cellpadding="35">
  <tr>
    <td><p>
<?php
if(strcmp($articleType, "") != 0) {
?>
<p><font class="articletype"><?php echo $articleType ?></font><br>
<?php
}
?>
  <font class="homeheadline"><?php echo $articleTitle ?></font><br>
<?php
if(strcmp($articleSubhead, "")!=0) {
?>
  <font class="articlesubhead"><?php echo $articleSubhead ?><br>
<?php 
} 
?>
  </font><font class="smalltext"><?php echo $articleDate ?></font></p>
<?php
if(strcmp($articleAuthor1, "")!=0) { # if we have any authors
?>

</p>

<p><font class="articleauthorby">By </font><font class="articleauthor"><?php 
				echo $articleAuthor1;
				if(strcmp($articleAuthor2, "")!= 0) {
					echo " and $articleAuthor2";
				}
				if(strcmp($articleAuthor3, "")!= 0) {
					echo " and $articleAuthor3";
				}
			
			?></font><br>
<?php
}
?><font class="articleauthorjob"><?php echo $articleJob ?></font><br>
</td>
  </tr>
</table>


</font></td>
            </tr>
            <tr valign="top">
              <td bgcolor="#CCCCCC"><font class="textbold">Your name:</font><font class="articledate">*</font></td>
              <td bgcolor="#CCCCCC"><font class="textbold"> 
                <input name="required_sendername" size="40">
                </font></td>
            </tr>
            <tr valign="top" bgcolor="#CCCCCC"> 
              <td><font class="textbold">Your email address:</font><font class="articledate">*</font></td>
              <td><font class="textbold"> 
                <input name="required_from" size="40">
                </font></td>
            </tr>
            <tr valign="top" bgcolor="#CCCCCC"> 
              <td><font class="textbold">Recipient's email address:</font><font class="articledate">*<br>&nbsp;&nbsp;(enter only 1 recipient)</font></td>
              <td><font class="textbold"> 
                <input name="required_to" size="40">
                </font></td>
            </tr>
            <tr valign="top" bgcolor="#CCCCCC"> 
              <td><font class="textbold">Personal message:</font></td>
              <td><font class="textbold"> 
                <textarea name="message" rows="3" cols="35"></textarea>
                </font></td>
            </tr>
          </table><br>



<table width="100%" border="0" cellspacing="0" cellpadding="00">
  <tr>
    <td align="center"><INPUT TYPE="hidden" NAME="success" VALUE="http://orient.bowdoin.edu/orient/emailarticlesuccess.php"><INPUT TYPE="submit" value="Send Article"><font class="smalltext">&nbsp;&nbsp;This may take a few moments.</font><br><p>
<INPUT type="hidden" name="cgiemail_error" value="http://orient.bowdoin.edu/orient/emailarticleerror.php">
<INPUT TYPE="hidden" name="date" value="<?php echo $date ?>">
<INPUT TYPE="hidden" name="section" value="<?php echo $section ?>">
<INPUT TYPE="hidden" name="id" value="<?php echo $priority ?>">
<INPUT TYPE="hidden" name="job" value="<?php echo $authorJob ?>">
<INPUT TYPE="hidden" name="articletype" value="<?php if(strcmp($articleType, "") != 0) { ?>
<?php echo $articleType ?>:<?php } ?>">
<INPUT TYPE="hidden" name="articletitle" value="<?php echo $newarticleTitle2 ?>">
<INPUT TYPE="hidden" name="articleauthor" value="<?php if(strcmp($articleAuthor1, "")!=0) { # if we have any authors ?>
By <?php				echo $articleAuthor1;
				if(strcmp($articleAuthor2, "")!= 0) {
					echo " and $articleAuthor2";
				}
				if(strcmp($articleAuthor3, "")!= 0) {
					echo " and $articleAuthor3";
				} ?> <?php } ?>">
<INPUT TYPE="hidden" name="articlejob" value="<?php echo $articleJob ?>">
<INPUT TYPE="hidden" name="articledate" value="<?php echo $articleDate ?>">
<INPUT TYPE="hidden" name="articlepullquote" value="<?php echo $newarticlepullquote ?>">
</FORM><p align="center"><font class="articledate">* denotes a required field.<br>The email addresses that 
                you enter on this page will only be used to send the requested 
                article.</font></p>
  </td>
  </tr>
</table></p>



</td></tr>
</table>

</div>
</body>
</html>

<?php

	}

else {

	print "Sorry, no records were found!";

}

?>




