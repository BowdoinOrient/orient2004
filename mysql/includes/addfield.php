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
		
		$add_info = $_SESSION['form_post'];
		$fields_add_num = $add_info['numfields'];
		$row_num = 1; ?>
								<form name="browsingtable" action="actions.php?act=15" method="post">
								<input type="hidden" name="add_where" value="<?PHP echo stringIt($add_info['add_where']); ?>">
								<input type="hidden" name="after_field" value="<?PHP echo stringIt($add_info['after_field']); ?>">
								<input type="hidden" name="numfields" value="<?PHP echo stringIt($add_info['numfields']); ?>">
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td id="title">
												<?PHP echo ADDING_FIELDS_TEXT; ?> '<?PHP echo stringIt($_SESSION['table']); ?>'
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
		for($i=0;$i<$fields_add_num;$i++){; ?>
													<tr>
														<td id="row1_<?PHP echo $row_num; ?>">
															<input type="text" name="field_name[]" id="input" value="<?PHP echo stringIt($add_info['field_name'][$i]); ?>">
														</td>
														<td id="row1_<?PHP echo $row_num; ?>">
															<select name="field_type[]" id="input">
																<option value="varchar" <?PHP echo ($add_info['field_type'][$i] == "varchar")?"selected":""; ?>>VARCHAR</option>
																<option value="tinyint" <?PHP echo ($add_info['field_type'][$i] == "tinyint")?"selected":""; ?>>TINYINT</option>
																<option value="text" <?PHP echo ($add_info['field_type'][$i] == "text")?"selected":""; ?>>TEXT</option>
																<option value="date" <?PHP echo ($add_info['field_type'][$i] == "date")?"selected":""; ?>>DATE</option>
																<option value="smallint" <?PHP echo ($add_info['field_type'][$i] == "smallint")?"selected":""; ?>>SMALLINT</option>
																<option value="mediumint" <?PHP echo ($add_info['field_type'][$i] == "mediumint")?"selected":""; ?>>MEDIUMINT</option>
																<option value="int" <?PHP echo ($add_info['field_type'][$i] == "int")?"selected":""; ?>>INT</option>
																<option value="bigint" <?PHP echo ($add_info['field_type'][$i] == "bigint")?"selected":""; ?>>BIGINT</option>
																<option value="float" <?PHP echo ($add_info['field_type'][$i] == "float")?"selected":""; ?>>FLOAT</option>
																<option value="double" <?PHP echo ($add_info['field_type'][$i] == "double")?"selected":""; ?>>DOUBLE</option>
																<option value="decimal" <?PHP echo ($add_info['field_type'][$i] == "decimal")?"selected":""; ?>>DECIMAL</option>
																<option value="datetime" <?PHP echo ($add_info['field_type'][$i] == "datetime")?"selected=\"selected\"":""; ?>>DATETIME</option>
																<option value="timestamp" <?PHP echo ($add_info['field_type'][$i] == "timestamp")?"selected":""; ?>>TIMESTAMP</option>
																<option value="time" <?PHP echo ($add_info['field_type'][$i] == "time")?"selected":""; ?>>TIME</option>
																<option value="year" <?PHP echo ($add_info['field_type'][$i] == "year")?"selected":""; ?>>YEAR</option>
																<option value="char" <?PHP echo ($add_info['field_type'][$i] == "char")?"selected":""; ?>>CHAR</option>
																<option value="tinyblob" <?PHP echo ($add_info['field_type'][$i] == "tinyblob")?"selected":""; ?>>TINYBLOB</option>
																<option value="tinytext" <?PHP echo ($add_info['field_type'][$i] == "tinytext")?"selected":""; ?>>TINYTEXT</option>
																<option value="blob" <?PHP echo ($add_info['field_type'][$i] == "blob")?"selected":""; ?>>BLOB</option>
																<option value="mediumblob" <?PHP echo ($add_info['field_type'][$i] == "mediumblob")?"selected":""; ?>>MEDIUMBLOB</option>
																<option value="mediumtext" <?PHP echo ($add_info['field_type'][$i] == "mediumtext")?"selected":""; ?>>MEDIUMTEXT</option>
																<option value="longblob" <?PHP echo ($add_info['field_type'][$i] == "longblob")?"selected":""; ?>>LONGBLOB</option>
																<option value="longtext" <?PHP echo ($add_info['field_type'][$i] == "longtext")?"selected":""; ?>>LONGTEXT</option>
																<option value="enum" <?PHP echo ($add_info['field_type'][$i] == "enum")?"selected":""; ?>>ENUM</option>
																<option value="set" <?PHP echo ($add_info['field_type'][$i] == "set")?"selected":""; ?>>SET</option>
																<option value="bool" <?PHP echo ($add_info['field_type'][$i] == "bool")?"selected":""; ?>>BOOL</option>
															</select>
														</td>
														<td id="row1_<?PHP echo $row_num; ?>">
															<input type="text" name="field_value[]" id="input" value="<?PHP echo stringIt($add_info['field_value'][$i]); ?>">
														</td>
														<td id="row1_<?PHP echo $row_num; ?>">
															<select name="field_null[]" id="input">
																<option value="NOT NULL" <?PHP echo ($add_info['field_null'][$i] == "not_null")?"selected=\"selected\"":""; ?>>Not Null</option>
																<option value="NULL" <?PHP echo ($add_info['field_null'][$i] == "null")?"selected=\"selected\"":""; ?>>Null</option>
															</select>
														</td>
														<td id="row1_<?PHP echo $row_num; ?>">
															<input type="text" name="field_default[]" id="input" value="<?PHP echo stringIt($add_info['field_default'][$i]); ?>">
														</td>
														<td id="row1_<?PHP echo $row_num; ?>">
															<select name="field_extra[]" id="input">
																<option value=""></option>
																<option value="auto_increment" <?PHP echo ($add_info['field_extra'][$i] == "auto_increment")?"selected=\"selected\"":""; ?>>auto_increment</option>
															</select>
														</td>
														<td id="row1_<?PHP echo $row_num; ?>">
															<select name="field_other[]" id="input">
																<option value=""></option>
																<option value="primary" <?PHP echo ($add_info['field_other'][$i] == "primary")?"selected=\"selected\"":""; ?>>Primary Key</option>
																<option value="unique" <?PHP echo ($add_info['field_other'][$i] == "unique")?"selected=\"selected\"":""; ?>>Unique</option>
																<option value="index" <?PHP echo ($add_info['field_other'][$i] == "index")?"selected=\"selected\"":""; ?>>Index</option>
															</select>
														</td>
														<td id="row1_<?PHP echo $row_num; ?>">
															<input type="checkbox" name="ft<?PHP echo $i; ?>" value="true" <?PHP echo ($add_info['ft'.$i] == "true")?"checked=\"checked\"":""; ?>>
														</td>
													</tr>														
<?PHP
			$row_num = ($row_num == 1)?2:1;
		}; ?>
												</table>
											</td>
										</tr>
									</table>
									<table cellpadding="0" cellspacing="0" style="padding:5px;">
										<tr>
											<td>
												<input type="submit" name="submit" value="<?PHP echo ADD_TEXT; ?>" id="button">
											</td>
										</tr>
									</table>
								</form>