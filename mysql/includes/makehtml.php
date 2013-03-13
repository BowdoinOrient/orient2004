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
								<form name="makehtml" action="actions.php?act=28" method="post">
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td id="title" align="left">
												<?PHP echo MAKE_HTML_TITLE_TEXT; ?> '<?PHP echo stringIt($_SESSION['table']); ?>'
											</td>
										</tr>
<?PHP
		if(empty($_SESSION['make_html_text'])){
?>
										<tr>
											<td>
												<table width="100%" cellpadding="0" cellspacing="1">
													<tr>
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
													</tr>
<?PHP
		
			$query_string = "SHOW COLUMNS FROM  `".$_SESSION['table']."`";
			$result = mysql_query($query_string);
			
			if (mysql_num_rows($result) > 0) {
	
				$row_count = 0;
	
				while ($row = mysql_fetch_assoc($result)){
					if(is_array($_SESSION['form_post']['rows'])){
						if(array_search($row['Field'], $_SESSION['form_post']['rows']) !== false){
							$continue = true;
						} else {
						$continue = false;
						}
					} else {
						$continue = true;
					}
					
					if($continue == true){
						$row_num = ($row_count % 2)?2:1;
						if($enable_primary == true){
							$col = ($row['Key'] == "PRI")?2:1;
						} else {
							$col = 1;
						}
?>
													<tr>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left"><?PHP echo stringIt($row['Field']); ?></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left"><?PHP echo stringIt($row['Type']); ?></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left"><?PHP echo ($row['Null'] != "YES")?"No":"Yes"; ?></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left"><?PHP echo stringIt($row['Default']); ?></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left"><?PHP echo stringIt($row['Extra']); ?></td>
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
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr><td style="height:4px;"></td></tr>
									</table>
									<table width="100%" cellpadding="0" cellspacing="1" style="padding:5px;">
									<tr>
											<td style="padding-right:10px;" id="row1_1" width="100" align="left">
												<?PHP echo FIX_FIELD_TEXT; ?>:</td>
											<td style="padding-right:10px;" id="row1_1" align="left">
												<input type="radio" name="fix_field" value="yes" id="fix_field_yes" checked="checked"><label for="fix_field_yes"> <?PHP echo YES_TEXT; ?></label> <input type="radio" name="fix_field" value="no" id="fix_field_no"><label for="fix_field_no"> <?PHP echo NO_TEXT; ?></label>
											</td>
										</tr>
										<tr>
											<td style="padding-right:10px;" id="row1_2" width="100" align="left">
												<?PHP echo HTML_TEMPLATE_TEXT; ?>:</td>
											<td style="padding-right:10px;" id="row1_2" align="left">
												<input type="radio" name="html_template" value="table" id="table" checked="checked"><label for="table"> <?PHP echo HTML_TABLE_TEXT; ?></label> <input type="radio" name="html_template" value="form" id="form"><label for="form"> <?PHP echo HTML_FORM_TEXT; ?></label>
											</td>
										</tr>
									</table>
									<table cellpadding="0" cellspacing="0" style="padding:5px;">
										<tr>
											<td align="left">
												<input type="submit" name="submit" value="<?PHP echo MAKE_HTML_TEXT; ?>" id="button">
											</td>
										</tr>
									</table>
<?PHP
		} else {
?>
									<tr>
										<td>
											<table width="100%" cellpadding="0" cellspacing="1">
												<tr>
													<td id="row1_1" align="left">
														<textarea style="width:100%" rows="20"><?PHP echo stringIt($_SESSION['make_html_text']); ?></textarea></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</form>
<?PHP
		}
?>