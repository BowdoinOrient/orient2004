<?PHP
defined('_VALID_INCLUDE') or die(header("Location: ../index.php"));
 
				if(!empty($_SESSION['last_query'])){
					if(!empty($_SESSION['mysql_error'])){
?>
								<table width="100%" cellpadding="0" cellspacing="1">
									<tr>
										<td id="error_head">
											<?PHP echo MYSQL_ERROR; ?>:
										</td>
									</tr>
									<tr>
										<td id="error">
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
										<td id="query_bottom">
											<?PHP echo LAST_QUERY; ?>:
										</td>
									</tr>
									<tr>
										<td id="query">
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
								<form name="tablestructure" action="actions.php?act=10" method="post">
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td id="title">
												<?PHP echo ADDING_TABLE_TEXT; ?> '<?PHP echo stringIt($_SESSION['form_post']['name']); ?>'
											</td>
										</tr>
										<tr>
											<td>
												<table width="100%" cellpadding="0" cellspacing="1">
													<tr>
														<td id="col2">
															<?PHP echo FIELD_NAME_TEXT; ?></td>
														<td id="col2">
															<?PHP echo TYPE_TEXT; ?></td>
														<td id="col2">
															<?PHP echo VALUE_TEXT; ?></td>
														<td id="col2">
															<?PHP echo NULL_TEXT; ?></td>
														<td id="col2">
															<?PHP echo DEFAULT_TEXT; ?></td>
														<td id="col2">
															<?PHP echo EXTRA_TEXT; ?></td>
														<td id="col2">
															<?PHP echo OTHER_TEXT; ?></td>
														<td id="col2">
															<?PHP echo FT_TEXT; ?></td>
													</tr>
<?PHP
		if ($_SESSION['form_post']['numfields'] > 0) {

			for($i=0;$i<$_SESSION['form_post']['numfields'];$i++){
				$row_num = ($row_count % 2)?2:1;
				$col = ($row['Key'] == "PRI")?2:1; ?>
													<tr>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input name="col_name[]" id="input" type="text" value="<?PHP echo stringIt($_SESSION['form_post']['col_name'][$i]); ?>"></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="col_type[]">
<?PHP
				$type_array = array('varchar','tinyint','text','date','smallint','mediumint','int','bigint','float','double','decimal','datetime','timestamp','time','year','char','tinyblob','tinytext','blob','mediumblob','mediumtext','longblob','longtext','enum','set','bool');
				foreach($type_array as $mytype){
?>
																<option value="<?PHP echo $mytype; ?>"<?PHP echo ($_SESSION['form_post']['col_type'][$i] == $mytype)?" selected":NULL; ?>><?PHP echo strtoupper($mytype); ?></option>
<?PHP
				}
?>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input name="col_value[]" id="input" type="text" value="<?PHP echo stringIt($_SESSION['form_post']['col_value'][$i]); ?>"></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="col_null[]">
																<option value="0"<?PHP echo ($_SESSION['form_post']['col_null'][$i] == 0)?" selected":NULL; ?>>Not Null</option>
																<option value="1"<?PHP echo ($_SESSION['form_post']['col_null'][$i] == 1)?" selected":NULL; ?>>Null</option>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input name="col_default[]" id="input" type="text" value="<?PHP echo stringIt($_SESSION['form_post']['col_default'][$i]); ?>"></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="col_extra[]">
																<option></option>
																<option value="auto_increment" <?PHP echo ($_SESSION['form_post']['col_extra'][$i] == "auto_increment")?" selected":NULL; ?>>auto_increment</option>
															</select></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="col_other[]">
																<option value="none"></option>
																<option value="primary" <?PHP echo ($_SESSION['form_post']['col_other'][$i] == "primary")?"selected":""; ?>>Primary Key</option>
																<option value="unique" <?PHP echo ($_SESSION['form_post']['col_other'][$i] == "unique")?"selected":""; ?>>Unique</option>
																<option value="index" <?PHP echo ($_SESSION['form_post']['col_other'][$i] == "index")?"selected":""; ?>>Index</option>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input type="checkbox" name="ft<?PHP echo $i; ?>" value="true" <?PHP echo ($_SESSION['form_post']['ft'.$i] == "true")?"checked=\"checked\"":""; ?>>
														</td>
													</tr>
<?PHP
				$row_count++;
			}
		}
?>
												</table>
												<table cellpadding="0" cellspacing="0" style="padding:5px;">
													<tr>
														<td width="75">
															<?PHP echo COMMENT_TEXT; ?>:</td>
														<td>
															<input name="comment" id="input" type="text" value="<?PHP echo stringIt($_SESSION['form_post']['comment']); ?>" size="50" style="width:100%;"></td>
														<td width="75" style="padding-left:20px;">
															<?PHP echo STORAGE_TEXT; ?>:</td>
														<td>
															<select name="storage" id="input">
<?PHP
				$storage_array = array("MyISAM", "ISAM", "MERGE", "HEAP", "MEMORY", "InnoDB", "BDB");
				foreach($storage_array as $key=>$value){
?>
																<option value="<?PHP echo $value; ?>" <?PHP echo ($_SESSION['form_post']['type'] == $value)?"selected=\"selected\"":NULL; ?>><?PHP echo $value; ?></option>
<?PHP
				}
?>
															</select>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									<table cellpadding="0" cellspacing="0" style="padding:5px;">
										<tr>
											<td>
												<input name="name" type="hidden" value="<?PHP echo stringIt($_SESSION['form_post']['name']); ?>">
												<input name="numfields" type="hidden" value="<?PHP echo $_SESSION['form_post']['numfields']; ?>">
												<input type="submit" value="<?PHP echo SAVE_TEXT; ?>" id="button"></td>
										</tr>
									</table>
								</form>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr><td style="height:4px;"></td></tr>
								</table>
								<form name="tableopperations" action="actions.php?act=9" method="post">
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td id="title">
												<?PHP echo ADD_ROWS_TEXT; ?>
											</td>
										</tr>
										<tr>
											<td>
												<table width="100%" cellpadding="0" cellspacing="1">
													<tr>
														<td id="row1_2" width="100">
															<?PHP echo NUM_FIELDS_ADD_TEXT; ?>:</td>
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