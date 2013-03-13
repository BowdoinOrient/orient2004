<?PHP
/*************************************
*	This software was developed
*		and distributed
*	by Jeff Broderick and
*				Anthony Frizalone
*			in 2006!
*************************************/

require("includes/header.php");
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
		<script type="text/javascript" language="Javascript" src="includes/javascript.js"></script>
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
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td id="left" valign="top">
								<form name="selectdb" action="actions.php?act=3" method="post">
									<select id="dropdown" name="database" onChange="javascript:document.selectdb.submit();">
										<option value="Select a database..."><?PHP echo SELECT_A_DATABASE_TEXT; ?>...</option>
<?PHP
while($row = @mysql_fetch_assoc($db_list)){
	$selected = ($_SESSION['database'] == $row['Database'])?" selected":NULL; ?>
										<option<?PHP echo $selected; ?>><?PHP echo stringIt($row['Database']); ?></option>
<?PHP
}
?>
									</select>
								</form>
<?PHP
if(!empty($_SESSION['database'])){
	$table_list = @mysql_list_tables($_SESSION['database']); ?>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td id="tables" align="left">
											<a href="actions.php?act=3&database=<?PHP echo stringIt($_SESSION['database']); ?>"><?PHP echo TABLES_TEXT; ?></a>
										</td>
									</tr>
									<tr>
										<td align="left">
											<ul>
<?PHP
	while ($row = @mysql_fetch_array($table_list)) {
		$selected = ($_SESSION['table'] == $row[0])?" id='selected'":NULL; ?>
												<li<?PHP echo $selected; ?>><a href="actions.php?act=4&table=<?PHP echo stringItvTwo($row[0]); ?>"><?PHP echo stringIt($row[0]); ?></a></li>
<?PHP
	}
?>
											</ul>
										</td>
									</tr>
								</table>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr><td style="height:4px;"></td></tr>
								</table>
<?PHP
}
if(!empty($_SESSION['database'])){
?>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td id="tables" align="left">
											<a href="actions.php?act=5&do=query"><?PHP echo RUN_A_QUERY_TEXT; ?></a>
										</td>
									</tr>
								</table>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr><td style="height:4px;"></td></tr>
								</table>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td id="tables" align="left">
											<a href="actions.php?act=5&do=backup"><?PHP echo EXPORT_DATABASE_TEXT; ?></a>
										</td>
									</tr>
								</table>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr><td style="height:4px;"></td></tr>
								</table>
<?PHP
} else {
?>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td id="logout" align="left">
												<a href="actions.php?act=5&do=show_dibs"><?PHP echo DATABASES_TEXT; ?></a>
										</td>
									</tr>
								</table>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr><td style="height:4px;"></td></tr>
								</table>
<?PHP
}

if(AUTH == 'login'){
?>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td id="logout" align="left">
											<a href="actions.php?act=2"><?PHP echo LOGOUT_TEXT; ?></a>
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
										<td>
											<img src="themes/<?PHP echo $_THEME; ?>/images/spacer.gif" style="margin:0px;padding:0px;border:0px;" border="0"></td>
									</tr>
								</table>
							</td>
							<td id="right" valign="top">
<?PHP
if(!empty($_SESSION['table'])){
	$enable_primary = checkPrimary(); ?>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td id="menu" align="left">
											<a href="actions.php?act=5&do=structure"><?PHP echo STRUCTURE_LINK; ?></a>
											<a href="actions.php?act=5&do=browse"><?PHP echo BROWSE_LINK; ?></a>
											<a href="actions.php?act=5&do=indexes"><?PHP echo INDEX_LINK; ?></a>
											<a href="actions.php?act=5&do=changestructure"><?PHP echo CHANGE_LINK; ?></a>
											<a href="actions.php?act=5&do=insert"><?PHP echo INSERT_LINK; ?></a>
											<a href="actions.php?act=5&do=search"><?PHP echo SEARCH_LINK; ?></a></td>
									</tr>
								</table>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr><td style="height:4px;"></td></tr>
								</table>
<?PHP
	if($_SESSION['show'] == "browse"){
		include("includes/browse.php");
	} else if($_SESSION['show'] == "editrow"){
		include("includes/editrow.php");
	} else if($_SESSION['show'] == "viewrow"){
		include("includes/viewrow.php");
	} else if($_SESSION['show'] == "droprow"){
		include("includes/droprow.php");
	} else if($_SESSION['show'] == "insert"){
		include("includes/insert.php");
	} else if($_SESSION['show'] == "search"){
		include("includes/search.php");
	} else if($_SESSION['show'] == "addfield"){
		include("includes/addfield.php");
	} else if($_SESSION['show'] == "dropfield"){
		include("includes/dropfield.php");
	} else if($_SESSION['show'] == "changestructure"){
		include("includes/changestructure.php");
	} else if($_SESSION['show'] == "dropindex"){
		include("includes/dropindex.php");
	} else if($_SESSION['show'] == "indexes"){
		include("includes/indexes.php");
	} else if($_SESSION['show'] == "makehtml"){
		include("includes/makehtml.php");
	} else {
		include("includes/tablestructure.php");
	}
} else {
	if(!empty($_SESSION['database'])){
		if($_SESSION['show'] == "variables"){
			include("includes/variables.php");
		} else if($_SESSION['show'] == "query"){
			include("includes/query.php");
		} else if($_SESSION['show'] == "view_query"){
			include("includes/viewquery.php");
		} else if($_SESSION['show'] == "edit_query"){
			include("includes/editquery.php");
		} else if($_SESSION['show'] == "emptytables"){
			include("includes/emptytables.php");
		} else if($_SESSION['show'] == "backup"){
			include("includes/backup.php");
		} else if($_SESSION['show'] == "droptables"){
			include("includes/droptables.php");
		} else if($_SESSION['show'] == "addtable"){
			include("includes/addtable.php");
		} else if($_SESSION['show'] == "themes"){
			include("includes/themes.php");
		} else if($_SESSION['show'] == "languages"){
			include("includes/languages.php");
		} else {
			include("includes/databasestructure.php");
		}
	} else {
		if($_SESSION['show'] == "themes"){
			include("includes/themes.php");
		} else if($_SESSION['show'] == "languages"){
			include("includes/languages.php");
		} else if($_SESSION['show'] == "dropdb"){
			include("includes/dropdb.php");
		} else {
			include("includes/welcome.php");
		}
	}
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
							<td id="footer" align="left">
<?PHP
if(LANG == ''){
?>
								<a href="actions.php?act=5&do=languages"><?PHP echo $_SESSION['lang_name']; ?></a> | 
<?PHP
}
?>								<a href="actions.php?act=5&do=themes"><?PHP echo stringIt($_SESSION['theme_name']); ?></a>
							</td>
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
unset($_SESSION['last_edit_query']);
unset($_SESSION['mysql_error']);
unset($_SESSION['relogin']);
unset($_SESSION['last_query']);
?>