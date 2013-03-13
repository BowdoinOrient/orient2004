<?PHP
session_start();
ob_start();

define('_VALID_INCLUDE', TRUE);

require("includes/required.php");

if(AUTH == "config"){
	header("Location: index.php");
}

if(@mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS)){
	header("Location: main.php");
}
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
					<td id="header" valign="top">
						<div id="headerimg"></div>
					</td>
				</tr>
				<tr>
					<td id="content">
<?PHP
	if(!empty($_SESSION['mysql_error'])){
?>
						<table width="100%" cellpadding="0" cellspacing="1">
							<tr>
								<td id="error_head" align="left">
									<?PHP echo MYSQL_ERROR; ?>:
								</td>
							</tr>
							<tr>
								<td id="error" align="left">
									<?PHP echo $_SESSION['mysql_error']; ?>
								</td>
							</tr>
						</table>
						<table width="100%" cellpadding="0" cellspacing="0">
							<tr><td style="height:4px;"></td></tr>
						</table>
<?PHP
	}
?>
						<table width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td id="title" valign="top" align="left">
									<?PHP echo LOGIN_TEXT; ?></td>
							</tr>
							<tr>
								<td valign="top" style="padding:10px;" id="content">
<?PHP
	if(ALLOW_REMOTE_ADMIN == 1){
?>
									<form action="actions.php?act=1" method="post">
										<table width="100%" cellpadding="0" cellspacing="1" id="right">
											<tr>
												<td id="row1_1" width="100" align="left">
													<?PHP echo USERNAME_TEXT; ?>:</td>
												<td id="row1_1" align="left">
													<input type="text" name="username" id="input"></td>
											</tr>
											<tr>
												<td id="row1_2" width="100" align="left">
													<?PHP echo PASSWORD_TEXT; ?>:</td>
												<td id="row1_2" align="left">
													<input type="password" name="password" id="input"></td>
											</tr>
											<tr>
												<td id="row1_1" width="100" align="left">
													<?PHP echo HOST_TEXT; ?>:</td>
												<td id="row1_1" align="left">
													<input type="text" name="host" id="input" value="<?PHP echo (count($_mysql_host) <= 1)?$_mysql_host[0]:"localhost"; ?>"></td>
											</tr>
											<tr>
												<td colspan="2" style="padding:5px;">
													<input type="submit" value="<?PHP echo LOGIN_TEXT; ?>" id="button" name="submit"></td>
											</tr>
										</table>
									</form>
<?PHP
	} else {
?>
									<form action="actions.php?act=1" method="post">
										<table width="100%" cellpadding="0" cellspacing="1" id="right">
											<tr>
												<td id="row1_1" width="100" align="left">
													<?PHP echo USERNAME_TEXT; ?>:</td>
												<td id="row1_1" align="left">
													<input type="text" name="username" id="input"></td>
											</tr>
											<tr>
												<td id="row1_2" width="100" align="left">
													<?PHP echo PASSWORD_TEXT; ?>:</td>
												<td id="row1_2" align="left">
													<input type="password" name="password" id="input"></td>
											</tr>
<?PHP
		if(count($_mysql_host)>1){
?>
											<tr>
												<td id="row1_1" width="100" align="left">
													<?PHP echo HOST; ?>:</td>
												<td id="row1_1" align="left">
													<select name="host" id="input">
<?PHP
			foreach($_mysql_host as $host){
?>
														<option value="<?PHP echo $host; ?>"><?PHP echo $host; ?></option>
<?PHP
			}
?>
													</select>
												</td>
											</tr>
<?PHP
		}
?>
											<tr>
												<td colspan="2" align="left">
<?PHP
		if(count($_mysql_host) <= 1){
?>
													<input type="hidden" name="host" value="<?PHP echo $_mysql_host[0]; ?>">
<?PHP
		}
?>
												</td>
                                               </tr>
                                               <tr>
                                               		<td colspan="2" style="padding:5px;">
													<input type="submit" value="<?PHP echo LOGIN_TEXT; ?>" id="button" name="submit"></td>
											</tr>
										</table>
									</form>
<?PHP
	}
?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td id="footer" align="right">
									<?PHP echo POWERED_BY_TEXT; ?>: <a href="http://www.mysqlquickadmin.com/">MySQL Quick Admin</a> v<?PHP echo VERSION; ?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td></tr></table>
	</body>
</html>
<?PHP
unset($_SESSION['mysql_error']);
unset($_SESSION['error']);
?>