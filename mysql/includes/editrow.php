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
								<form name="editrows" action="actions.php?act=14" method="post">
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td id="title" align="left"><?PHP echo EDIT_ROWS_TEXT; ?> '<?PHP echo stringIt($_SESSION['table']); ?>'</td>
									</tr>
<?PHP
		
		$post = $_SESSION['form_post'];
		$rows = $post['rows'];
		foreach($rows as $key=>$keynum){
?>
									<input type="hidden" name="rows[]" value="<?PHP echo $keynum; ?>">
<?PHP
			for($i=0;$i<count($_SESSION['form_post']['values'][$keynum]);$i++){
?>
									<input type="hidden" name="old_values[<?PHP echo $keynum; ?>][<?PHP echo $i; ?>]" value="<?PHP echo stringIt($_SESSION['form_post']['values'][$keynum][$i]); ?>">
<?PHP
			}
		}
		
		$this_tab_q = "SHOW COLUMNS FROM `".$_SESSION['table']."`";
		$this_result = mysql_query($this_tab_q);
		$num_fields = mysql_num_rows($this_result);
		$for_id = mysql_query("SELECT * FROM `".$_SESSION['table']."`");
		$rr = 0;

		while($row = mysql_fetch_assoc($this_result)){
			$type_length = strlen($row["Type"]);
			$bracket_start = strpos($row["Type"],'(');
			if($bracket_start !== false){
				$bracket_end = $type_length - $bracket_start - 2;
				$row["Value"] = substr($row["Type"], ($bracket_start + 1), ($bracket_end));
				$row["Type"] = substr($row["Type"], 0, ($bracket_start));
			} else $row["Value"] = NULL;
			
			$field_name[] = $row["Field"];
			$field_type[] = $row["Type"];
			$field_value[] = $row["Value"];
		}
			
		foreach($rows as $key=>$value){
			$row_num = 1; ?>
								
									<tr>
										<td>
											<table width="100%" cellpadding="0" cellspacing="1">
												<tr>
													<td id="col2" width="17%" align="left"><?PHP echo FIELD_NAME_TEXT; ?></td>
													<td id="col2" width="17%" align="left"><?PHP echo TYPE_TEXT; ?></td>
													<td id="col2" align="left"><?PHP echo FUNCTION_TEXT; ?></td>
													<td id="col2" width="70%" align="left"><?PHP echo VALUE_TEXT; ?></td>
												</tr>
<?PHP
			$edit_explode = $_SESSION['form_post']['values'][$value];
			
			$string_functions = array("char", "crypt", "htmlentities", "entity_decode", "htmlspecialchars", "spchars_decode", "md5", "money_format", "rand", "stripslashes", "strtolower", "strtoupper", "trim");
			$time_functions = array("now", "date", "time");
			
			for($r=0;$r<$num_fields;$r++){
				for($l=0;$l<$num_fields;$l++){
					$get_field = mysql_fetch_field($for_id, $l);
					if($get_field->primary_key == 1) $id_field_name = $get_field->name;
				}
				
				if($enable_primary == true){
					$col = ($id_field_name == $field_name[$r])?2:1;
				} else {
					$col = 1;
				}
				
				$top_array = array("text", "tinytext", "mediumtext", "longtext", "blob", "tinyblob", "mediumblob", "longblob");
				
				if(in_array($field_type[$r], $top_array)){
					$valign_top = true;
				} else {
					$valign_top = false;
				}

?>
												<tr>
													<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left" <?PHP echo ($valign_top == true)?" valign=\"top\"":NULL; ?>><?PHP echo stringIt($field_name[$r]); ?></td>
													<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left" <?PHP echo ($valign_top == true)?" valign=\"top\"":NULL; ?>><?PHP echo $field_type[$r]; ?><?PHP echo (!empty($field_value[$r]))?"(".stringIt($field_value[$r]).")":""; ?></td>
<?PHP
				
				
				switch($field_type[$r]){
					case 'varchar':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[<?PHP echo $rr; ?>]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?>">
														</td>
<?PHP
					break;
					case 'tinyint':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?>">
														</td>
<?PHP
					break;
					case 'text':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left" valign="top">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<textarea cols="47" rows="5" id="input" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]"><?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?></textarea>
														</td>
<?PHP
					break;
					case 'date':
					$dates = explode("-", $edit_explode[$r]); ?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>][]" size="4" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr][0]):$dates[0]; ?>" maxlength="4">-<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>][]" size="2" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr][1]):$dates[1]; ?>" maxlength="2">-<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>][]" size="2" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr][2]):$dates[2]; ?>" maxlength="2">
														</td>
<?PHP
					break;
					case 'smallint':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?>">
														</td>
<?PHP
					break;
					case 'mediumint':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?>">
														</td>
<?PHP
					break;
					case 'int':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?>">
														</td>
<?PHP
					break;
					case 'bigint':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?>">
														</td>
<?PHP
					break;
					case 'float':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?>">
														</td>
<?PHP
					break;
					case 'double':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?>">
														</td>
<?PHP
					case 'decimal':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?>">
														</td>
<?PHP
					break;
					case 'datetime':
					$both_ = explode(" ", $edit_explode[$r]);
					$dates = explode("-", $both_[0]);
					$times = explode(":", $both_[1]); ?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>][]" size="4" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr][0]):$dates[0]; ?>" maxlength="4">-<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>][]" size="2" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr][1]):$dates[1]; ?>" maxlength="2">-<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>][]" size="2" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr][2]):$dates[2]; ?>" maxlength="2"> <input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>][]" size="2" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr][3]):$times[0]; ?>" maxlength="2">:<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>][]" size="2" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr][4]):$times[1]; ?>" maxlength="2">:<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>][]" size="2" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr][5]):$times[2]; ?>" maxlength="2">
														</td>
<?PHP
					break;
					case 'timestamp':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?>">
														</td>
<?PHP
					break;
					case 'time':
					$times = explode(":", $edit_explode[$r]); ?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>][]" size="2" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr][0]):$times[0]; ?>">:<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>][]" size="2" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr][1]):$times[1]; ?>">:<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>][]" size="2" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr][2]):$times[2]; ?>">
														</td>
<?PHP
					break;
					case 'year':
					if($field_value[$r] == "4"){
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]" maxlength="4" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?>">
														</td>
<?PHP
					} else if($field_value[$r] == "2"){
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]" maxlength="2" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?>">
														</td>
<?PHP
					}
					break;
					case 'char':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?>">
														</td>
<?PHP
					break;
					case 'tinyblob':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left" valign="top">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<textarea cols="47" rows="5" id="input" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]"><?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?></textarea>
														</td>
<?PHP
					break;
					case 'blob':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left" valign="top">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<textarea cols="47" rows="5" id="input" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]"><?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?></textarea>
														</td>
<?PHP
					break;
					case 'mediumblob':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left" valign="top">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<textarea cols="47" rows="5" id="input" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]"><?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?></textarea>
														</td>
<?PHP
					break;
					case 'longblob':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left" valign="top">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<textarea cols="47" rows="5" id="input" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]"><?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?></textarea>
														</td>
<?PHP
					break;
					case 'tinytext':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left" valign="top">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<textarea cols="47" rows="5" id="input" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]"><?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?></textarea>
														</td>
<?PHP
					break;
					case 'mediumtext':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left" valign="top">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<textarea cols="47" rows="5" id="input" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]"><?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?></textarea>
														</td>
<?PHP
					break;
					case 'longtext':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left" valign="top">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<textarea cols="47" rows="5" id="input" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]"><?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?></textarea>
														</td>
<?PHP
					break;
					case 'enum':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left" align="center">-----------------</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
<?PHP
					$match_it = preg_match_all("^'(.*?)'^", $field_value[$r], $matches);
					$values = $matches[1];
					foreach($values as $key=>$value){
						if(!isset($_SESSION['form_post']) || empty($_SESSION['last_query'])){
?>
															<input id="input" type="radio" value="<?PHP echo stringIt($value); ?>" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]" <?PHP echo ($value == $edit_explode[$r])?"checked=\"checked\"":NULL; ?>> <?PHP echo stringIt($value); ?>
<?PHP
						} else {
?>
															<input id="input" type="radio" value="<?PHP echo stringIt($value); ?>" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]" <?PHP echo ($_SESSION['form_post'][$field_name[$r]][$rr] == $value)?"checked=\"checked\"":NULL; ?>> <?PHP echo stringIt($value); ?>
<?PHP
						}
					}
?>
														</td>
<?PHP
					break;
					case 'set':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left" align="center">-----------------</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
<?PHP
					$match_it = preg_match_all("^'(.*?)'^", $field_value[$r], $matches);
					$values = $matches[1];
					$act_vals = explode(",", $edit_explode[$r]);
					foreach($values as $key=>$value){
						if(!isset($_SESSION['form_post']) || empty($_SESSION['last_query'])){
?>
															<input id="input" type="checkbox" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>][]" value="<?PHP echo stringIt($value); ?>" <?PHP echo (in_array($value, $act_vals))?"checked=\"checked\"":""; ?>> <?PHP echo stringIt($value); ?>
<?PHP
						} else {
?>
															<input id="input" type="checkbox" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>][]" value="<?PHP echo stringIt($value); ?>" <?PHP echo (in_array($value, $_SESSION['form_post'][$field_name[$r]][$rr]))?"checked=\"checked\"":""; ?>> <?PHP echo stringIt($value); ?>
<?PHP
						}
					}
?>
														</td>
<?PHP
					break;
					case 'bool':
?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<select name="<?PHP echo stringItvTwo($field_name[$r]); ?>_function[]" id="input">
																<option value=""></option>
																<optgroup label="<?PHP echo STRING_FUN_TEXT; ?>">
<?PHP
						foreach($string_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
																<optgroup label="<?PHP echo DATE_TIME_FUN_TEXT; ?>">
<?PHP
						foreach($time_functions as $key=>$function){
?>
																	<option <?PHP echo ($_SESSION['form_post'][$field_name[$r]."_function"][$rr] == $function)?"selected=\"selected\"":NULL; ?>><?PHP echo $function; ?></option>
<?PHP
						}
?>
																</optgroup>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<input id="input" type="text" name="<?PHP echo stringItvTwo($field_name[$r]); ?>[<?PHP echo $rr; ?>]" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post'][$field_name[$r]][$rr]):stringIt($edit_explode[$r]); ?>">
														</td>
<?PHP
					break;
				}
?>
											  </tr>
<?PHP
			
			$row_num = ($row_num == 1)?2:1;
			}
?>
											</table>
										</td>
									
<?PHP
			$rr++;
		}
?>
									</tr>
								</table>
								<table cellspacing="0" cellpadding="0" style="padding:5px;">
									<tr>
										<td align="left">
											<input type="submit" id="button" name="submit" value="<?PHP echo SAVE_TEXT; ?>">
										</td>
									</tr>
								</table>
								</form>