<?PHP
defined('_VALID_INCLUDE') or die(header("Location: ../main.php"));

				if(!empty($_SESSION['last_query'])){
		
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
											<?PHP echo stringIt($_SESSION['mysql_error']); ?>
										</td>
									</tr>
								</table>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr><td style="height:4px;"></td></tr>
								</table>
<?PHP
					}
?>
								<table width="100%" cellpadding="0" cellspacing="1">
									<tr>
										<td id="query_bottom" align="left">
											<?PHP echo LAST_QUERY; ?>:
										</td>
									</tr>
									<tr>
										<td id="query" align="left">
											<?PHP echo $_SESSION['last_query']; ?>
										</td>
									</tr>
								</table>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr><td style="height:4px;"></td></tr>
								</table>
<?PHP
				}
?>
								<form name="dboverview" action="actions.php?act=5" method="post">
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td id="title" align="left">
												<?PHP echo DATABASES_TEXT; ?>
											</td>
										</tr>
										<tr>
											<td>
												<table width="100%" cellpadding="0" cellspacing="1">
													<tr>
														<td id="col1" width="10">&nbsp;</td>
														<td id="col2" align="left">
															<?PHP echo NAME_TEXT; ?></td>
														<td id="col2" align="left">
															<?PHP echo TABLES_TEXT; ?></td>
														<td id="col2" align="left">
															<?PHP echo RECORDS_TEXT; ?></td>
														<td id="col2" align="left">
															<?PHP echo SIZE_TEXT; ?></td>
														<td id="col1">&nbsp;</td>
													</tr>
<?PHP
		$row_count = 0;
		$row_num = 1;
		$total_size = 0;
		$total_rows = 0;
		$totals['tables'] = 0;
		$totals['size'] = 0;
		$totals['rows'] = 0;
		
		$db_list = mysql_list_dbs();
		if(mysql_num_rows($db_list) > 0){
			while($row = mysql_fetch_assoc($db_list)){
				$get_tables = mysql_query("SHOW TABLE STATUS FROM `".$row['Database']."`");
				$tables_num = mysql_num_rows($get_tables);
				$totals['tables'] += $tables_num;
				while($row2 = mysql_fetch_assoc($get_tables)){
					$total_size += $row2['Index_length'];
					$total_rows += $row2['Rows'];
				}
				$totals['size'] += $total_size;
				$totals['rows'] += $total_rows;
?>
													<tr>
														<td align="center"><input type="checkbox" name="rows[]" value="<?PHP echo stringIt($row['Database']); ?>" id="<?PHP echo $row_count; ?>"></td>
														<td id="row1_<?PHP echo $row_num; ?>" align="left">
															<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><a href="actions.php?act=3&database=<?PHP echo urlencode($row['Database']); ?>"><?PHP echo stringIt($row['Database']); ?></a></label>
														</td>
														<td id="row1_<?PHP echo $row_num; ?>" align="left">
															<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><?PHP echo stringIt($tables_num); ?></label>
														</td>
														<td id="row1_<?PHP echo $row_num; ?>" align="left">
															<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><?PHP echo stringIt($total_rows); ?></label>
														</td>
														<td id="row1_<?PHP echo $row_num; ?>" align="left">
															<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><?PHP echo stringIt(round($total_size/1024, 2)." KB"); ?></label>
														</td>
														<td id="row1_<?PHP echo $row_num; ?>" width="10" align="center">
															<a href="javascript:manDb('<?PHP echo $row_count; ?>','dropdb');"><img src="themes/<?PHP echo $_THEME; ?>/images/dropdb_button.gif" alt="<?PHP echo DROP_DB_BUTTON_TEXT; ?>" title="<?PHP echo DROP_DB_BUTTON_TEXT; ?>" border="0"></a></td>
													</tr>
<?PHP
				$row_num = ($row_num == 1)?2:1;
				$row_count++;
				$total_size = 0;
				$total_rows = 0;
			}
?>
													<tr>
														<td></td>
														<td id="row1_<?PHP echo $row_num; ?>"></td>
														<td id="row1_<?PHP echo $row_num; ?>" align="left">
															<b><?PHP echo stringIt($totals['tables']); ?></b>
														</td>
														<td id="row1_<?PHP echo $row_num; ?>" align="left">
															<b><?PHP echo stringIt($totals['rows']); ?></b>
														</td>
														<td id="row1_<?PHP echo $row_num; ?>" align="left">
															<b><?PHP echo stringIt(round($totals['size']/1024, 2)." KB"); ?></b>
														</td>
														<td id="row1_<?PHP echo $row_num; ?>"></td>
													</tr>
<?PHP
		} else {
?>
													<tr>
														<td id="error" colspan="5" align="left">
															<b><?PHP echo UNABLE_GET_DATA_ERROR_TEXT; ?></b></td>
													</tr>
<?PHP
		}
?>
												</table>
												<table cellpadding="0" cellspacing="0" style="padding:5px;" width="100%">
													<tr>
														<td width="125" style="padding-right:10px;" align="left">
															<?PHP echo WITH_SELECTED_TEXT; ?>:</td>
														<td style="padding-right:10px;" align="left">
															<select name="action" onChange="javascript:document.dboverview.submit();">
																<option></option>
																<option value="dropdb"><?PHP echo DROP_TEXT; ?></option>
															</select>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</form>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr><td style="height:4px;"></td></tr>
								</table>
								<table width="50%" cellpadding="0" cellspacing="0">
									<tr>
										<td width="50%" valign="top" align="left">
											<form name="dbopperations" action="actions.php?act=5&do=adddb" method="post">
												<table width="100%" cellpadding="0" cellspacing="0">
													<tr>
														<td id="title">
															<?PHP echo CREATE_NEW_DB_TEXT; ?>
														</td>
													</tr>
													<tr>
														<td>
															<table width="100%" cellpadding="0" cellspacing="1">
																<tr>
																	<td id="row1_1" width="100">
																		<?PHP echo NAME_TEXT; ?>:</td>
																	<td id="row1_1">
																		<input type="text" id="input" name="name"></td>
																</tr>
																<tr>
																	<td colspan="2" style="padding:5px;">
																		<input type="submit" id="button" name="submit" value="<?PHP echo OK_TEXT; ?>"></td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</form>
										</td>
									</tr>
								</table>