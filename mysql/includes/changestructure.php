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
								<form name="tablestructure" action="actions.php?act=6" method="post">
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td id="title" align="left">
												<?PHP echo CHANGING_STRUCTURE_TEXT; ?> '<?PHP echo stringIt($_SESSION['table']); ?>'
											</td>
										</tr>
										<tr>
											<td align="left">
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
															<?PHP echo PRIMARY_TEXT; ?></td>
													</tr>
<?PHP
		$query_string = "SHOW COLUMNS FROM  `".$_SESSION['table']."`";
		$result = @mysql_query($query_string);
		$all_get = @mysql_query("SELECT * FROM `".$_SESSION['table']."`");

		if (mysql_num_rows($result) > 0) {

			$row_count = 0;

			while ($row = mysql_fetch_assoc($result)) {
				if(is_array($_SESSION['form_post']['rows'])){
					if(in_array($row['Field'],$_SESSION['form_post']['rows'])){
						$continue = true;
					} else {
						$continue = false;
					}
				} else {
					$continue = true;
				}

				if($continue == true){
					for($i=0;$i<mysql_num_fields($all_get);$i++){
						$get_each_field = mysql_fetch_field($all_get, $i);
						if($get_each_field->name == $row["Field"]){
							$field_info = $get_each_field;
						}
					}
					
					$row_num = ($row_count % 2)?2:1;
					if($enable_primary == true){
						$col = ($row['Key'] == "PRI")?2:1;
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
?>
													<tr>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input type="hidden" name="old_col_name[]" value="<?PHP echo stringIt($row['Field']); ?>">
															<input name="col_name[]" id="input" type="text" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post']['col_name'][$row_count]):stringIt($row['Field']); ?>"></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="col_type[]">
<?PHP
					$type_array = array('varchar','tinyint','text','date','smallint','mediumint','int','bigint','float','double','decimal','datetime','timestamp','time','year','char','tinyblob','tinytext','blob','mediumblob','mediumtext','longblob','longtext','enum','set','bool');
					foreach($type_array as $mytype){
						if(!isset($_SESSION['form_post']) || empty($_SESSION['last_query'])){
?>
																<option value="<?PHP echo $mytype; ?>"<?PHP echo (strtolower($row['Type']) == $mytype)?" selected":NULL; ?>><?PHP echo strtoupper($mytype); ?></option>
<?PHP
						} else {
?>
																<option value="<?PHP echo $mytype; ?>"<?PHP echo (stringIt($_SESSION['form_post']['col_type'][$row_count]) == $mytype)?" selected":NULL; ?>><?PHP echo strtoupper($mytype); ?></option>
<?PHP
						}				
					}
?>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input name="col_value[]" id="input" type="text" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post']['col_value'][$row_count]):stringIt($row['Value']); ?>"></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="col_null[]">
<?PHP
					if(!isset($_SESSION['form_post']) || empty($_SESSION['last_query'])){
?>
																<option value="0"<?PHP echo ($row['Null'] != "YES")?" selected":NULL; ?>>Not Null</option>
																<option value="1"<?PHP echo ($row['Null'] == "YES")?" selected":NULL; ?>>Null</option>
<?PHP
					} else {
?>
																<option value="0"<?PHP echo (stringIt($_SESSION['form_post']['col_null'][$row_count]) == 0)?" selected":NULL; ?>>Not Null</option>
																<option value="1"<?PHP echo (stringIt($_SESSION['form_post']['col_null'][$row_count]) == 1)?" selected":NULL; ?>>Null</option>
															</select>
<?PHP
					}
?>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input name="col_default[]" id="input" type="text" value="<?PHP echo (isset($_SESSION['form_post']) && !empty($_SESSION['last_query']))?stringIt($_SESSION['form_post']['col_default'][$row_count]):stringIt($row['Default']); ?>"></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="col_extra[]">
																<option></option>
<?PHP
					if(!isset($_SESSION['form_post']) || empty($_SESSION['last_query'])){
?>
																<option value="auto_increment"<?PHP echo ($row['Extra'] == "auto_increment")?" selected":NULL; ?>>auto_increment</option>
<?PHP
					} else {
?>
																<option value="auto_increment"<?PHP echo (stringIt($_SESSION['form_post']['col_extra'][$row_count]) == "auto_increment")?" selected":NULL; ?>>auto_increment</option>
<?PHP
					}
?>
														</select></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="center">
<?PHP
					if(empty($_SESSION['last_query'])){
?>
															<input type="checkbox" name="col_primary[]" value="<?PHP echo stringIt($row["Field"]); ?>"<?PHP echo ($col == 2)?" checked=\"checked\"":NULL; ?>>
<?PHP
					} else {
?>
															<input type="checkbox" name="col_primary[]" value="<?PHP echo stringIt($row["Field"]); ?>"<?PHP echo (in_array($row["Field"],$_SESSION['form_post']['col_primary']))?" checked=\"checked\"":NULL; ?>>
<?PHP
					}
?>
														</td>
													</tr>
<?PHP
					$row_count++;
				}
			}
		}
?>
												</table>
											</td>
										</tr>
									</table>
									<table cellpadding="0" cellspacing="0" style="padding:5px;" width="100%">
										<tr>
											<td align="left">
												<input type="submit" name="submit" value="<?PHP echo SAVE_TEXT; ?>" id="button">
											</td>
										</tr>
									</table>
								</form>