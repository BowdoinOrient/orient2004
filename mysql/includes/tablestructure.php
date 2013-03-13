<?PHP
defined('_VALID_INCLUDE') or die(header("Location: ../index.php"));
 
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
								<form name="tableopperations" action="actions.php?act=5" method="post">
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td id="title" align="left">
												<?PHP echo TB_STRUCTURE_TEXT; ?> '<?PHP echo stringIt($_SESSION['table']); ?>'
											</td>
										</tr>
										<tr>
											<td>
												<table width="100%" cellpadding="0" cellspacing="1">
													<tr>
														<td id="col1" width="10">&nbsp;</td>
														<td id="col2" align="left">
															<?PHP echo FIELD_NAME_TEXT; ?></td>
														<td id="col2" align="left">
															<?PHP echo TYPE_TEXT; ?></td>
														<td id="col2" align="left">
															<?PHP echo NULL_TEXT; ?></td>
														<td id="col2" align="left">
															<?PHP echo DEFAULT_TEXT; ?></td>
														<td id="col2" align="left">
															<?PHP echo EXTRA_TEXT; ?></td>
														<td id="col1" colspan="4">&nbsp;</td>
														<td id="col1" colspan="4">&nbsp;</td>
													</tr>
<?PHP
		$query_string = "SHOW COLUMNS FROM  `".$_SESSION['table']."`";
		$result = mysql_query($query_string);
		
		if (mysql_num_rows($result) > 0) {

			$row_count = 0;

			while ($row = mysql_fetch_assoc($result)) {
				$row_num = ($row_count % 2)?2:1;
				if($enable_primary == true){
					$col = ($row['Key'] == "PRI")?2:1;
				} else {
					$col = 1;
				}
?>
													<tr>
	
														<td align="center">
															<input type="checkbox" name="rows[]" value="<?PHP echo stringIt($row['Field']); ?>" id="<?PHP echo $row_count; ?>"></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><?PHP echo stringIt($row['Field']); ?></label></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><?PHP echo stringIt($row['Type']); ?></label></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><?PHP echo ($row['Null'] != "YES")?"No":"Yes"; ?></label></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><?PHP echo stringIt($row['Default']); ?></label></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><?PHP echo stringIt($row['Extra']); ?></label></td>
														<td id="row1_<?PHP echo $row_num; ?>" width="10" align="center">
															<a href="javascript:manTable('<?PHP echo $row_count; ?>','make_primary');"><img src="themes/<?PHP echo $_THEME; ?>/images/primarykey_button.gif" alt="<?PHP echo ADD_PRIMARY_TEXT; ?>" title="<?PHP echo ADD_PRIMARY_TEXT; ?>" border="0"></a></td>
														<td id="row1_<?PHP echo $row_num; ?>" width="10" align="center">
															<a href="javascript:manTable('<?PHP echo $row_count; ?>','make_unique');"><img src="themes/<?PHP echo $_THEME; ?>/images/uniquekey_button.gif" alt="<?PHP echo ADD_UNIQUE_TEXT; ?>" title="<?PHP echo ADD_UNIQUE_TEXT; ?>" border="0"></a></td>
														<td id="row1_<?PHP echo $row_num; ?>" width="10" align="center">
															<a href="javascript:manTable('<?PHP echo $row_count; ?>','make_index');"><img src="themes/<?PHP echo $_THEME; ?>/images/indexkey_button.gif" alt="<?PHP echo ADD_INDEX_TEXT; ?>" title="<?PHP echo ADD_INDEX_TEXT; ?>" border="0"></a></td>
														<td id="row1_<?PHP echo $row_num; ?>" width="10" align="center">
															<a href="javascript:manTable('<?PHP echo $row_count; ?>','make_fulltext');"><img src="themes/<?PHP echo $_THEME; ?>/images/fulltext_button.gif" alt="<?PHP echo ADD_FULLTEXT_TEXT; ?>" title="<?PHP echo ADD_FULLTEXT_TEXT; ?>" border="0"></a></td>
														<td id="row1_<?PHP echo $row_num; ?>" width="10" align="center">
															<a href="javascript:manTable('<?PHP echo $row_count; ?>','browse');"><img src="themes/<?PHP echo $_THEME; ?>/images/colbrowse_button.gif" alt="<?PHP echo BROWSE_TEXT; ?>" title="<?PHP echo BROWSE_TEXT; ?>" border="0"></a></td>
														<td id="row1_<?PHP echo $row_num; ?>" width="10" align="center">
															<a href="javascript:manTable('<?PHP echo $row_count; ?>','changestructure');"><img src="themes/<?PHP echo $_THEME; ?>/images/coledit_button.gif" alt="<?PHP echo CHANGE_HIGH_TEXT; ?>" title="<?PHP echo CHANGE_HIGH_TEXT; ?>" border="0"></a></td>
														<td id="row1_<?PHP echo $row_num; ?>" width="10" align="center">
															<a href="javascript:manTable('<?PHP echo $row_count; ?>','search');"><img src="themes/<?PHP echo $_THEME; ?>/images/searchfield_button.gif" alt="<?PHP echo SEARCH_FIELD_TEXT; ?>" title="<?PHP echo SEARCH_FIELD_TEXT; ?>" border="0"></a></td>
														<td id="row1_<?PHP echo $row_num; ?>" width="10" align="center">
															<a href="javascript:manTable('<?PHP echo $row_count; ?>','dropfield');"><img src="themes/<?PHP echo $_THEME; ?>/images/coldrop_button.gif" alt="<?PHP echo DROP_FIELD_TEXT; ?>" title="<?PHP echo DROP_FIELD_TEXT; ?>" border="0"></a></td>
													</tr>
<?PHP
				$row_count++;
			}
		}
?>
													<tr>
														<td style="padding-top: 3px; padding-bottom: 3px;" align="center">
															<input type="checkbox" id="select_unselect" onClick="checkUncheckAll(this)">
														</td>
														<td colspan="<?PHP echo mysql_num_fields($result); ?>" style="padding-top: 3px; padding-bottom: 3px; padding-left: 5px;" align="left">
															<label for="select_unselect" style="display:block;width:100%;"><?PHP echo SELECT_UNSELECT_TEXT; ?></label>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									<table cellpadding="0" cellspacing="0" style="padding:5px;" width="100%">
										<tr>
											<td width="125" style="padding-right:10px;" align="left">
												<?PHP echo WITH_SELECTED_TEXT; ?>:</td>
											<td style="padding-right:10px;" align="left">
												<select name="action" onChange="javascript:document.tableopperations.submit();">
													<option></option>
													<option value="browse"><?PHP echo BROWSE_TEXT; ?></option>
													<option value="changestructure"><?PHP echo CHANGE_TEXT; ?></option>
													<option value="dropfield"><?PHP echo DROP_TEXT; ?></option>
													<option value="make_primary">Primary Key</option>
													<option value="make_unique">Unique</option>
													<option value="make_index">Index</option>
													<option value="make_fulltext">FullText</option>
													<option value="search"><?PHP echo SEARCH_TEXT; ?></option>
													<option value="makehtml"><?PHP echo MAKE_HTML_TEXT; ?></option>
												</select>
											</td>
										</tr>
									</table>
								</form>
								<form action="actions.php?act=5&do=addfield" method="post">
									<table width="100%" cellpadding="0" cellspacing="0">																	      									<tr>
											<td id="title" align="left">
												<?PHP echo ADD_FIELDS_TO_TEXT; ?> '<?PHP echo stringIt($_SESSION['table']); ?>'
											</td>
										</tr>
										<tr>	
											<td align="left">
												<table width="100%" cellpadding="0" cellspacing="1">
													<tr>
														<td id="row1_1" width="100">
															<?PHP echo ADD_FIELDS_DOT_TEXT; ?>...
														</td>
														<td id="row1_1">
															<input type="radio" name="add_where" value="end" id="end" checked="checked"><label for="end"> <?PHP echo AT_END_TEXT; ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="add_where" value="beginning" id="beginning"><label for="beginning"> <?PHP echo AT_BEGINNING_TEXT; ?></label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="add_where" value="after" id="after"><label for="after"> <?PHP echo AFTER_TEXT; ?>:</label> <select name="after_field" id="input" onFocus="this.form.add_where[2].checked=true">
<?PHP
		$result = mysql_query("SHOW COLUMNS FROM `".$_SESSION['table']."`");
		while($field_row = mysql_fetch_assoc($result)){
			$field_namee = $field_row['Field']; ?>
																<option value="<?PHP echo stringIt($field_namee); ?>"><?PHP echo stringIt($field_namee); ?></option>
<?PHP
		}
?>
															</select>
														</td>
													</tr>
													<tr>
														<td id="row1_2" width="100">
															<?PHP echo NUM_FIELDS_TEXT; ?>:</td>
														<td id="row1_2">
															<input type="text" id="input" name="numfields" size="2"></td>
													</tr>
													<tr>
														<td colspan="2" style="padding:5px;">
															<input type="submit" value="<?PHP echo OK_TEXT; ?>" id="button" name="submit">																														
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</form>