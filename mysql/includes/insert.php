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
								<form name="insert_field" action="actions.php?act=12" method="post">
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td id="title" align="left">
												<?PHP echo INSERT_INTO_TEXT; ?> '<?PHP echo stringIt($_SESSION['table']); ?>'</td>
										</tr>
										<tr>
											<td align="left">
												<table width="100%" cellpadding="0" cellspacing="1">
													<tr>
														<td id="col2" width="17%"><?PHP echo FIELD_NAME_TEXT; ?></td>
														<td id="col2" width="15%"><?PHP echo TYPE_TEXT; ?></td>
														<td id="col2"><?PHP echo FUNCTION_TEXT; ?></td>
														<td id="col2" width="70%"><?PHP echo VALUE_TEXT; ?></td>
													</tr>
<?PHP
		$query_string = "SHOW COLUMNS FROM `".$_SESSION['table']."`";
		$result = @mysql_query($query_string);
		$row_num = 1;
		$for_id = mysql_query("SELECT * FROM `".$_SESSION['table']."`");
		$num_fields = mysql_num_rows($result);
		
		$string_functions = array("char", "crypt", "htmlentities", "entity_decode", "htmlspecialchars", "spchars_decode", "md5", "money_format", "rand", "stripslashes", "strtolower", "strtoupper", "trim");
		$time_functions = array("now", "date", "time");
		
		if($num_fields > 0){
			$r = 0;
			while($row = mysql_fetch_assoc($result)){
				$field_id = mysql_fetch_field($for_id, $r);
				if($field_id->primary_key == 1){
					$field_name = $field_id->name;
				}
			
				$r++;
			
				if($enable_primary == true){
					$col = ($row["Field"] == $field_name)?2:1;
				} else {
					$col = 1;
				}
				
				$type_length = strlen($row['Type']);
				$bracket_start = strpos($row['Type'],'(');
				if($bracket_start !== false){
					$bracket_end = $type_length - $bracket_start - 2;
					$row['Value'] = substr($row['Type'], ($bracket_start + 1), ($bracket_end));
					$row['Type'] = substr($row['Type'], 0, ($bracket_start));
				} else {
					$row['Value'] = NULL;
				}
				
				$top_array = array("text", "tinytext", "mediumtext", "longtext", "blob", "tinyblob", "mediumblob", "longblob");
				
				if(in_array($row['Type'], $top_array)){
					$valign_top = true;
				} else {
					$valign_top = false;
				}
?>
													<tr>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>"<?PHP echo ($valign_top == true)?" valign=\"top\"":NULL; ?>>
															<?PHP echo stringIt($row["Field"]); ?>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>"<?PHP echo ($valign_top == true)?" valign=\"top\"":NULL; ?>>
															<?PHP echo stringIt($row["Type"]); ?><?PHP echo (!empty($row["Value"]))?"(".stringIt($row["Value"]).")":NULL; ?>
														</td>
<?PHP				
				switch($row['Type']){
					case 'varchar':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):$row["Default"]; ?>">
														</td>
<?PHP
					break;
					case 'tinyint':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):stringIt($row["Default"]); ?>">
														</td>
<?PHP
					break;
					case 'text':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" valign="top">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<textarea cols="47" rows="5" id="input" name="<?PHP echo stringItvTwo($row["Field"]); ?>"><?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):stringIt($row["Default"]); ?></textarea>
														</td>
<?PHP
					break;
					case 'date':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>[]" size="4" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]][0]):date('Y'); ?>" maxlength="4">-<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>[]" size="2" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]][1]):date('m'); ?>" maxlength="2">-<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>[]" size="2" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]][2]):date('d'); ?>" maxlength="2">
														</td>
<?PHP
					break;
					case 'smallint':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):stringIt($row["Default"]); ?>">
														</td>
<?PHP
					break;
					case 'mediumint':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):stringIt($row["Default"]); ?>">
														</td>
<?PHP
					break;
					case 'int':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>" maxlength="11" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):stringIt($row["Default"]); ?>">
														</td>
<?PHP
					break;
					case 'bigint':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):stringIt($row["Default"]); ?>">
														</td>
<?PHP
					break;
					case 'float':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):stringIt($row["Default"]); ?>">
														</td>
<?PHP
					break;
					case 'double':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):stringIt($row["Default"]); ?>">
														</td>
<?PHP
					case 'decimal':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):stringIt($row["Default"]); ?>">
														</td>
<?PHP
					break;
					case 'datetime':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>[]" size="4" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]][0]):date('Y'); ?>" maxlength="4">-<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>[]" size="2" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]][1]):date('m'); ?>" maxlength="2">-<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>[]" size="2" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]][2]):date('d'); ?>" maxlength="2"> <input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>[]" size="2" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]][3]):date('H'); ?>">:<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>[]" size="2" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]][4]):date('i'); ?>">:<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>[]" size="2" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]][5]):date('s'); ?>">
														</td>
<?PHP
					break;
					case 'timestamp':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):date('YmdHis'); ?>">
														</td>
<?PHP
					break;
					case 'time':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>[]" size="2" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]][0]):date('H'); ?>">:<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>[]" size="2" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]][1]):date('i'); ?>">:<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>[]" size="2" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]][2]):date('s'); ?>">
														</td>
<?PHP
					break;
					case 'year':
					if($row['Value'] == "4"){
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):date('Y'); ?>" maxlength="4">
														</td>
<?PHP
					} else if($row['Value'] == "2"){
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):date('y'); ?>">
														</td>
<?PHP
					}
					break;
					case 'char':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):stringIt($row["Default"]); ?>">
														</td>
<?PHP
					break;
					case 'tinyblob':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" valign="top">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<textarea cols="47" rows="5" id="input" name="<?PHP echo stringItvTwo($row["Field"]); ?>"><?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):stringIt($row["Default"]); ?></textarea>
														</td>
<?PHP
					break;
					case 'blob':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" valign="top">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<textarea cols="47" rows="5" id="input" name="<?PHP echo stringItvTwo($row["Field"]); ?>"><?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):stringIt($row["Default"]); ?></textarea>
														</td>
<?PHP
					break;
					case 'mediumblob':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" valign="top">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<textarea cols="47" rows="5" id="input" name="<?PHP echo stringItvTwo($row["Field"]); ?>"><?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):stringIt($row["Default"]); ?></textarea>
														</td>
<?PHP
					break;
					case 'longblob':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" valign="top">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<textarea cols="47" rows="5" id="input" name="<?PHP echo stringItvTwo($row["Field"]); ?>"><?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):stringIt($row["Default"]); ?></textarea>
														</td>
<?PHP
					break;
					case 'tinytext':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" valign="top">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<textarea cols="47" rows="5" id="input" name="<?PHP echo stringItvTwo($row["Field"]); ?>"><?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):stringIt($row["Default"]); ?></textarea>
														</td>
<?PHP
					break;
					case 'mediumtext':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" valign="top">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<textarea cols="47" rows="5" id="input" name="<?PHP echo stringItvTwo($row["Field"]); ?>"><?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):stringIt($row["Default"]); ?></textarea>
														</td>
<?PHP
					break;
					case 'longtext':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" valign="top">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<textarea cols="47" rows="5" id="input" name="<?PHP echo stringItvTwo($row["Field"]); ?>"><?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):stringIt($row["Default"]); ?></textarea>
														</td>
<?PHP
					break;
					case 'enum':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="center">-----------------</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
<?PHP
					//$row['Value'] .= ",";
					$match_it = preg_match_all("^'(.*?)'^", $row['Value'], $matches);
					$values = $matches[1];
					foreach($values as $key=>$value){
						if($value == $row["Default"] || $_SESSION['form_post'][$row["Field"]] == $value){
?>
															<input id="input" type="radio" value="<?PHP echo stringIt($value); ?>" name="<?PHP echo stringItvTwo($row["Field"]); ?>" checked="checked"> <?PHP echo stringIt($value); ?>
<?PHP
						} else {
?>
															<input id="input" type="radio" value="<?PHP echo stringIt($value); ?>" name="<?PHP echo stringItvTwo($row["Field"]); ?>"> <?PHP echo stringIt($value); ?>
<?PHP
						}
					}
?>
														</td>
<?PHP
					break;
					case 'set':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="center">-----------------</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
<?PHP
					$match_it = preg_match_all("^'(.*?)'^", $row['Value'], $matches);
					$values = $matches[1];
					$defaults = explode(",", $row["Default"]);
					foreach($values as $key=>$value){
						if(!isset($_SESSION['form_post'])){
?>
															<input id="input" type="checkbox" name="<?PHP echo stringItvTwo($row["Field"]); ?>[]" value="<?PHP echo stringIt($value); ?>"<?PHP echo (in_array($value, $defaults))?" checked=\"checked\"":NULL; ?>> <?PHP echo stringIt($value); ?>
<?PHP
						} else {
?>
															<input id="input" type="checkbox" name="<?PHP echo stringItvTwo($row["Field"]); ?>[]" value="<?PHP echo stringIt($value); ?>"<?PHP echo (in_array($value, $_SESSION['form_post'][$row["Field"]]))?" checked=\"checked\"":NULL; ?>> <?PHP echo stringIt($value); ?>
<?PHP
						}
					}
?>
														</td>
<?PHP
					break;
					case 'bool':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="<?PHP echo stringItvTwo($row["Field"]); ?>_function" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$row["Field"]."_function"] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($row["Field"]); ?>" value="<?PHP echo (isset($_SESSION['form_post']))?stringIt($_SESSION['form_post'][$row["Field"]]):stringIt($row["Default"]); ?>">
														</td>
<?PHP
					break;
				}
?>
													</tr>
<?PHP
				$row_num = ($row_num == 1)?2:1;
			}
		} else {
			$_SESSION['show'] = 'failure';
		}
?>
												</table>
											</td>
										</tr>
									</table>
									<table cellpadding="0" cellspacing="0" style="padding:5px;" width="100%">
										<tr>
											<td align="left">
												<input type="submit" value="<?PHP echo INSERT_BT_TEXT; ?>" name="submit" id="button">
											</td>
										</tr>
									</table>
								</form>