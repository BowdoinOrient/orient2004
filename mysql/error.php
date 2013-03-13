<?PHP
session_start();
ob_start();

define('_VALID_INCLUDE', TRUE);

if((empty($_SESSION['error'])) && (empty($_SESSION['mysql_error']))) header("Location: index.php");

require("includes/required.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?PHP echo CHARSET; ?>" />
		<STYLE TYPE="text/css">
		<!--
		  @import url(themes/<?PHP echo $_THEME; ?>/style.css);
		-->
		</STYLE>
		<title>MySQL Quick Admin</title>
	</head>
	<body>
		<table width="100%" cellpadding="0" cellspacing="0"><tr><td align="center">
			<table cellpadding="0" cellspacing="4" id="maintable">
				<tr>
					<td id="header" valign="top"><div id="headerimg"></div></td>
				</tr>
				<tr>
					<td id="content">
						<table width="100%" cellpadding="0" cellspacing="1">
							<tr>
								<td id="error_head" align="left">
									<?PHP echo ERROR_TEXT; ?>:
								</td>
							</tr>
							<tr>
								<td id="error" align="left">
									<?PHP echo (!empty($_SESSION['error']))?$_SESSION['error']:$_SESSION['mysql_error']; ?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td id="footer" align="right">
						<?PHP echo POWERED_BY_TEXT; ?>: <a href="http://www.mysqlquickadmin.com/">MySQL Quick Admin</a> v<?PHP echo VERSION; ?></td>
				</tr>
			</table>
		</td></tr></table>
	</body>
</html>
<?PHP
unset($_SESSION['mysql_error']);
?>