<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>The Bowdoin Orient - Letter Submission Form</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link href="orient.css" rel="stylesheet" type="text/css">

<script type="text/javascript" language="JavaScript">
function CheckRequiredFields() {
var errormessage = new String();

if(WithoutContent(document.email.required_name.value))
	{ errormessage += "\n\nName"; }

if(WithoutContent(document.email.required_email.value))
	{ errormessage += "\n\nEmail Address"; }

if(WithoutContent(document.email.required_phone.value))
	{ errormessage += "\n\nPhone Number"; }

if(WithoutContent(document.email.required_location.value))
	{ errormessage += "\n\nLocation"; }

if(WithoutContent(document.email.required_text.value))
	{ errormessage += "\n\nLetter Text"; }

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
 ACTION="/cgi-bin/cgiemail/cgiemail/orient/docs/sendletter.cetf">

          <table width="100%" border="0" cellspacing="2" cellpadding="5">
            <tr valign="top"> 
              <td colspan="2" bgcolor="#FFFFFF"><font class="textbold"><font class="pagetitle">Letter Submission Form</font>

<p>&nbsp;</p>

</font></td>
            </tr>
            <tr valign="top">
              <td bgcolor="#CCCCCC"><font class="textbold">Name:</font><font class="articledate">*</font></td>
              <td bgcolor="#CCCCCC"><font class="textbold"> 
                <input name="required_name" size="40">
                </font></td>
            </tr>
            <tr valign="top">
              <td bgcolor="#CCCCCC"><font class="textbold">Organization (if one):</font></td>
              <td bgcolor="#CCCCCC"><font class="textbold"> 
                <input name="organization" size="40">
                </font></td>
            </tr>
            <tr valign="top" bgcolor="#CCCCCC"> 
              <td><font class="textbold">Email address:</font><font class="articledate">*</font></td>
              <td><font class="textbold"> 
                <input name="required_email" size="40">
                </font></td>
            </tr>
            <tr valign="top" bgcolor="#CCCCCC"> 
              <td><font class="textbold">Phone number:</font><font class="articledate">*</font></td>
              <td><font class="textbold"> 
                <input name="required_phone" size="40">
                </font></td>
            </tr>
            <tr valign="top" bgcolor="#CCCCCC"> 
              <td><font class="textbold">Location (City, State):</font><font class="articledate">*</font></td>
              <td><font class="textbold"> 
                <input name="required_location" size="40">
                </font></td>
            </tr>
            <tr valign="top" bgcolor="#CCCCCC"> 
              <td><font class="textbold">Letter text:</font><font class="articledate">*</font></td>
              <td><font class="textbold"> 
                <textarea name="required_text" rows="6" cols="55"></textarea>
                </font></td>
            </tr>
            <tr valign="top" bgcolor="#CCCCCC"> 
              <td><font class="textbold">Special comments:</font></td>
              <td><font class="textbold"> 
                <textarea name="comments" rows="3" cols="35"></textarea>
                </font></td>
            </tr>
          </table><br>



<table width="100%" border="0" cellspacing="0" cellpadding="00">
  <tr>
    <td align="center"><INPUT TYPE="hidden" NAME="success" VALUE="http://orient.bowdoin.edu/orient/sendlettersuccess.php"><INPUT TYPE="submit" value="Send Letter"><font class="smalltext">&nbsp;&nbsp;This may take a few moments.</font><br><p>
<INPUT type="hidden" name="cgiemail_error" value="http://orient.bowdoin.edu/orient/sendlettererror.php">
</FORM><p align="center"><font class="articledate">* denotes a required field.<br>Your email address and phone number will be used to verify your identity and will not be published.</font></p>
  </td>
  </tr>
</table></p>

</td></tr>
</table>

</div>
</body>
</html>



