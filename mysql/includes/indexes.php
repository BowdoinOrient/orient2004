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
												<?PHP echo INDEXES_FOR_TEXT; ?> '<?PHP echo stringIt($_SESSION['table']); ?>'
											</td>
										</tr>
										<tr>
											<td align="left">
												<table width="100%" cellpadding="0" cellspacing="1">
													<tr>
														<td id="col1" width="10">&nbsp;</td>
														<td id="col2">
															<?PHP echo KEYNAME_TEXT; ?></td>
														<td id="col2">
															<?PHP echo TYPE_TEXT; ?></td>
														<td id="col2">
															<?PHP echo FIELD_TEXT; ?></td>
														<td id="col2">
															<?PHP echo CARDINALITY_TEXT; ?></td>
														<td id="col1">&nbsp;
															</td>
													</tr>
<?PHP
		
		$get_indexes = "SHOW INDEX FROM `".mysql_escape_string($_SESSION['table'])."`";
		$result = mysql_query($get_indexes);
		
		$row_num = 1;
		$index_count = 0;
		
		if(mysql_num_rows($result) > 0){
			while($in = mysql_fetch_assoc($result)){
				if($in["Key_name"] == "PRIMARY"){
					$col = 2;
				} else {
					$col = 1;
				}
				if(empty($in["Comment"])){
					if($in["Key_name"] == "PRIMARY"){
						$in['Comment'] = "PRIMARY";
					} else {
						if($in["Non_unique"] == 1){
							$in['Comment'] = "INDEX";
						} else {
							$in['Comment'] = "UNIQUE";
						}
					}
				}
				if(is_null($in['Cardinality'])){
					$in['Cardinality'] = "None";
				}
?>
													<tr>
<?PHP
				if($in['Key_name'] != $last_keyname){
?>
														<td align="center">
															<input type="checkbox" name="index[]" value="<?PHP echo stringIt($in['Key_name']); ?>" id="<?PHP echo $index_count; ?>"<?PHP echo $disable_check; ?>>
<?PHP
				} else {
?>
														<td align="center">	
															<img src="themes/<?PHP echo _THEME; ?>/images/indexarrow_img.gif" alt="Identical Keyname" title="Identical Keyname" border="0">
<?PHP
				}
?>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<label for="<?PHP echo $index_count; ?>" style="display:block;width:100%;"><?PHP echo stringIt($in['Key_name']); ?></label>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<label for="<?PHP echo $index_count; ?>" style="display:block;width:100%;"><?PHP echo stringIt($in['Comment']); ?></label>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<label for="<?PHP echo $index_count; ?>" style="display:block;width:100%;"><?PHP echo stringIt($in['Column_name']); ?></label>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<label for="<?PHP echo $index_count; ?>" style="display:block;width:100%;"><?PHP echo stringIt($in['Cardinality']); ?></label>
														</td>
														<td id="row1_<?PHP echo $row_num; ?>" width="10" align="center">
<?PHP
				if($in['Key_name'] != $last_keyname){
?>
															<a href="javascript:manTable('<?PHP echo $index_count; ?>','dropindex');"><img src="themes/<?PHP echo _THEME; ?>/images/indexdel_button.gif" alt="<?PHP echo DROP_INDEX_TEXT; ?>" title="<?PHP echo DROP_INDEX_TEXT; ?>" border="0"></a></td>
													</tr>
<?PHP
				} else {
?>
															<img src="themes/<?PHP echo _THEME; ?>/images/indexarrow2_img.gif" alt="Identical Keyname" title="Identical Keyname" border="0">
<?PHP
				}
?>
<?PHP
				$row_num = ($row_num == 1)?2:1;
				$last_keyname = $in['Key_name'];
				$index_count++;
			}
?>
													<tr>
														<td style="padding-top: 3px; padding-bottom: 3px;" align="center">
															<input type="checkbox" id="select_unselect" onClick="checkUncheckAll(this)">
														</td>
														<td style="padding-top: 3px; padding-bottom: 3px; padding-left: 5px;">
															<label for="select_unselect" style="display:block;width:100%;"><?PHP echo SELECT_UNSELECT_TEXT; ?></label>
														</td>
													</tr>
<?PHP
		} else {
?>
													<tr>
														<td id="error" colspan="6">
															<b><?PHP echo NO_INDEXES_TEXT; ?></b>
														</td>
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
												<select name="action" onChange="javascript:document.tableopperations.submit();">
													<option></option>
													<option value="dropindex"><?PHP echo DROP_TEXT; ?></option>
												</select>
											</td>
										</tr>
									</table>
								</form>
								<form action="actions.php?act=20" method="post">
									<table width="100%" cellpadding="0" cellspacing="0">																	      									<tr>
											<td id="title" align="left">
												<?PHP echo ADD_INDEX_TO_TEXT; ?> '<?PHP echo stringIt($_SESSION['table']); ?>'
											</td>
										</tr>
										<tr>	
											<td align="left">
												<table width="100%" cellpadding="0" cellspacing="1">
													<tr>
														<td id="row1_1" width="100">
															<?PHP echo INDEX_NAME_TEXT; ?>:
														</td>
														<td id="row1_1">
															<input type="text" name="index_name" id="input" value="<?PHP echo stringIt($_SESSION['form_post']['index_name']); ?>">
														</td>
													</tr>
													<tr>
														<td id="row1_2">
															<?PHP echo INDEX_TYPE_TEXT; ?>:
														</td>
														<td id="row1_2">
															<select name="index_type" id="input">
																<option value="PRIMARY" <?PHP echo ($_SESSION['form_post']['index_type'] == "PRIMARY")?"selected=\"selected\"":""; ?>>Primary Key</option>
																<option value="UNIQUE" <?PHP echo ($_SESSION['form_post']['index_type'] == "UNIQUE")?"selected=\"selected\"":""; ?>>Unique</option>
																<option value="INDEX" <?PHP echo ($_SESSION['form_post']['index_type'] == "INDEX")?"selected=\"selected\"":""; ?>>Index</option>
																<option value="FULLTEXT" <?PHP echo ($_SESSION['form_post']['index_type'] == "FULLTEXT")?"selected=\"selected\"":""; ?>>Full Text</option>
															</select>
														</td>
													</tr>
													<tr>
														<td id="row1_1">
															<?PHP echo INDEX_FIELD_TEXT; ?>
														</td>
														<td id="row1_1">
															<select name="index_field" id="input">
																<option value=""><?PHP echo CHOOSE_TEXT; ?>...</option>
<?PHP
		$result = mysql_query("SHOW COLUMNS FROM `".$_SESSION['table']."`");
		while($field_row = mysql_fetch_assoc($result)){
			$field_namee = $field_row['Field']; ?>
																<option value="<?PHP echo stringIt($field_namee); ?>" <?PHP echo ($_SESSION['form_post']['index_field'] == $field_namee)?"selected=\"selected\"":""; ?>><?PHP echo stringIt($field_namee); ?></option>
<?PHP
		}
?>
															</select>
														</td>
													</tr>
													<tr>
														<td colspan="2" style="padding:5px;">
															<input type="submit" id="button" name="submit" value="<?PHP echo OK_TEXT; ?>">																																								
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</form>