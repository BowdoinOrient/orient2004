<?PHP
defined('_VALID_INCLUDE') or die(header("Location: ../index.php"));
 
				$result = @mysql_query("SHOW TABLE STATUS FROM `".$_SESSION['database']."`");
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
								<form name="tableoverview" action="actions.php?act=5" method="post">
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td id="title" align="left">
												<?PHP echo TABLES_IN_TEXT; ?> '<?PHP echo stringIt($_SESSION['database']); ?>'
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
															<?PHP echo TYPE_TEXT; ?></td>
														<td id="col2" align="left">
															<?PHP echo RECORDS_TEXT; ?></td>
														<td id="col2" align="left">
															<?PHP echo SIZE_TEXT; ?></td>
														<td id="col2" align="left">
															<?PHP echo OVERHEAD_TEXT; ?></td>
														<td id="col2" align="left">
															<?PHP echo COMMENT_TEXT; ?></td>
														<td id="col1" colspan="4">&nbsp;</td>
													</tr>
<?PHP
				if(@mysql_num_rows($result) > 0){
		
					$row_count = 0;
					$total_overhead = array();
					$total_overhead['bytes'] = 0;
					$total_overhead['count'] = 0;
					$totals = array();

					while ($row = mysql_fetch_assoc($result)) {
						$row_num = ($row_count % 2)?2:1;
						$col = ($row['Key'] == "PRI")?2:1;

						$col = (($row['Data_free'] != 0) && ($col != 2))?3:1;

						$total_overhead['bytes'] = ($row['Data_free'] != 0)?$total_overhead['bytes'] + $row['Data_free']:$total_overhead['bytes'];
						$total_overhead['count'] = ($row['Data_free'] != 0)?$total_overhead['count'] + 1:$total_overhead['count'];
						$totals['rows'] += $row['Rows'];
						$totals['size'] += $row['Index_length'];
?>
													<tr>
														<td align="center"><input type="checkbox" name="rows[]" value="<?PHP echo stringIt($row['Name']); ?>" id="<?PHP echo $row_count; ?>"></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><a href="actions.php?act=4&table=<?PHP echo stringItvTwo($row['Name']); ?>"><?PHP echo stringIt($row['Name']); ?></a></label></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><?PHP echo (!empty($row['Type']))?stringIt($row['Type']):stringIt($row['Engine']); ?></label></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><?PHP echo stringIt($row['Rows']); ?></label></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><?PHP echo round($row['Index_length']/1024,2). " KB"; ?></label></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><?PHP echo round($row['Data_free']/1024,2). " KB"; ?></label></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><?PHP echo stringIt($row['Comment']); ?></label></td>
														<td id="row1_<?PHP echo $row_num; ?>" width="10" align="center">
															<a href="actions.php?act=5&do=insert_row&table=<?PHP echo stringItvTwo($row['Name']); ?>"><img src="themes/<?PHP echo $_THEME; ?>/images/insert_button.gif" alt="<?PHP echo INSERT_ROW_TEXT; ?>" title="<?PHP echo INSERT_ROW_TEXT; ?>" border="0"></a></td>
														<td id="row1_<?PHP echo $row_num; ?>" width="10" align="center">
															<a href="javascript:manAll('<?PHP echo $row_count; ?>','emptytables');"><img src="themes/<?PHP echo $_THEME; ?>/images/empty_button.gif" alt="<?PHP echo EMPTY_TABLE_TEXT; ?>" title="<?PHP echo EMPTY_TABLE_TEXT; ?>" border="0"></a></td>
														<td id="row1_<?PHP echo $row_num; ?>" width="10" align="center">
															<a href="javascript:manAll('<?PHP echo $row_count; ?>','optimize');"><img src="themes/<?PHP echo $_THEME; ?>/images/optimize_button.gif" alt="<?PHP echo OPTIMIZE_TABLE_TEXT; ?>" title="<?PHP echo OPTIMIZE_TABLE_TEXT; ?>" border="0"></a></td>
														<td id="row1_<?PHP echo $row_num; ?>" width="10" align="center">
															<a href="javascript:manAll('<?PHP echo $row_count; ?>','droptables');"><img src="themes/<?PHP echo $_THEME; ?>/images/drop_button.gif" alt="<?PHP echo DROP_TABLE_TEXT; ?>" title="<?PHP echo DROP_TABLE_TEXT; ?>" border="0"></a></td>
													</tr>
<?PHP
						$row_count++;
					}
				$row_num = ($row_count % 2)?2:1;
?>
													<tr>
														<td></td>
														<td id="row1_<?PHP echo $row_num;?>" colspan="2">
															</td>
														<td id="row1_<?PHP echo $row_num; ?>" align="left">
															<strong><?PHP echo stringIt($totals['rows']); ?></strong></td>
														<td id="row1_<?PHP echo $row_num; ?>" align="left">
															<strong><?PHP echo round($totals['size']/1024,2)." KB"; ?></strong></td>
														<td id="row1_<?PHP echo $row_num; ?>" align="left">
															<strong><?PHP echo round($total_overhead['bytes']/1024,2). " KB"; ?></strong></td>
														<td id="row1_<?PHP echo $row_num; ?>" align="left"></td>
														<td id="row1_<?PHP echo $row_num; ?>" colspan="4"></td>
													</tr>
													<tr>
														<td style="padding-top: 3px; padding-bottom: 3px;" align="center">
															<input type="checkbox" id="select_unselect" onClick="checkUncheckAll(this)">
														</td>
														<td colspan="<?PHP echo mysql_num_fields($result); ?>" style="padding-top: 3px; padding-bottom: 3px; padding-left: 5px;" align="left">
															<label for="select_unselect" style="display:block;width:100%;"><?PHP echo SELECT_UNSELECT_TEXT; ?></label>
														</td>
													</tr>
<?PHP
				} else {
?>
													<tr>
														<td id="error" colspan="<?PHP echo mysql_num_fields($result)+1; ?>" align="left">
															<b><?PHP echo NO_TABLES_IN_DB_TEXT; ?></b></td>
													</tr>
<?PHP
				}
?>
												</table>

											</td>
										</tr>
									</table>
									<table cellpadding="0" cellspacing="0" style="padding:5px;" width="100%">
										<tr>
											<td width="125" style="padding-right:10px;" align="left">
												<?PHP echo WITH_SELECTED_TEXT; ?>:</td>
											<td style="padding-right:10px;" align="left">
												<select name="action" onChange="javascript:document.tableoverview.submit();">
													<option></option>
													<option value="emptytables"><?PHP echo EMPTY_TEXT; ?></option>
													<option value="droptables"><?PHP echo DROP_TEXT; ?></option>
													<option value="optimize"><?PHP echo OPTIMIZE_TEXT; ?></option>
												</select>
											</td>
										</tr>
									</table>
								</form>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr><td style="height:4px;"></td></tr>
								</table>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td width="50%" valign="top" align="left">
											<form name="tableopperations" action="actions.php?act=5&do=addtable" method="post">
												<table width="100%" cellpadding="0" cellspacing="0">
													<tr>
														<td id="title">
															<?PHP echo CREATE_NEW_TABLE_TEXT; ?>
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
																	<td id="row1_2" width="100">
																		<?PHP echo NUM_FIELDS_TEXT; ?>:</td>
																	<td id="row1_2">
																		<input type="text" id="input" name="numfields" size="2"></td>
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
										<td style="width:4px;">&nbsp;</td>
										<td width="50%" valign="top">
<?PHP
				if($total_overhead['count'] > 0){
?>
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr>
													<td id="title_red" align="left">
														<?PHP echo TABLE_NEEDS_OPTIMIZE_TEXT; ?>
													</td>
												</tr>
												<tr>
													<td>
														<table width="100%" cellpadding="0" cellspacing="1">
															<tr>
																<td id="row1_1" width="100" align="left">
																	<?PHP echo OVERHEAD_WARNING_TEXT_1; ?> <?PHP echo round($total_overhead['bytes']/1024,2)." KB"; ?> <?PHP echo OVERHEAD_WARNING_TEXT_2; ?> <?PHP echo $total_overhead['count']; ?> <?PHP echo OVERHEAD_WARNING_TEXT_3; ?><p>
																	<a href="actions.php?act=5&do=optimize&all=true">Optimize now!</a></td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
<?PHP
				} else {
					echo "&nbsp;";
				}
?>
										</td>
									</tr>
								</table>