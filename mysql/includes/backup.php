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
											<?PHP echo stringIt($_SESSION['last_query']); ?>
										</td>
									</tr>
								</table>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr><td style="height:4px;"></td></tr>
								</table>
<?PHP
			}
			
			if(!isset($_SESSION['backup_sql'])){
?>
								<form name="backup_database" action="actions.php?act=22" method="post">
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td id="title">
												<?PHP echo EXPORT_TABLES_TEXT; ?> '<?PHP echo stringIt($_SESSION['database']); ?>'
											</td>
										</tr>
										<tr>
											<td>
												<table width="100%" cellpadding="0" cellspacing="1">
													<tr>
														<td id="col1" width="10">&nbsp;</td>
														<td id="col2">
															<?PHP echo NAME_TEXT; ?></td>
														<td id="col2">
															<?PHP echo TYPE_TEXT; ?></td>
														<td id="col2">
															<?PHP echo RECORDS_TEXT; ?></td>
														<td id="col2">
															<?PHP echo SIZE_TEXT; ?></td>
														<td id="col2">
															<?PHP echo OVERHEAD_TEXT; ?></td>
														<td id="col2">
															<?PHP echo COMMENT_TEXT; ?></td>
													</tr>
<?PHP
				$result = @mysql_query("SHOW TABLE STATUS FROM `".$_SESSION['database']."`");
				
				if(mysql_num_rows($result) > 0){
					
					$row_count = 0;
					$total_overhead = array();
					$total_overhead['bytes'] = 0;
					$total_overhead['count'] = 0;
					
					
					while ($row = mysql_fetch_assoc($result)) {
						$row_num = ($row_count % 2)?2:1;
						$col = ($row['Key'] == "PRI")?2:1;
		
						$col = (($row['Data_free'] != 0) && ($col != 2))?3:1;
		
						$total_overhead['bytes'] = ($row['Data_free'] != 0)?$total_overhead['bytes'] + $row['Data_free']:$total_overhead['bytes'];
						$total_overhead['count'] = ($row['Data_free'] != 0)?$total_overhead['count'] + 1:$total_overhead['count']; ?>
													<tr>
														<td align="center"><input type="checkbox" name="rows[]" value="<?PHP echo stringIt($row['Name']); ?>" id="<?PHP echo $row_count; ?>" checked="checked"></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><?PHP echo stringIt($row['Name']); ?></label></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
														<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><?PHP echo (!empty($row['Type']))?stringIt($row['Type']):stringIt($row['Engine']); ?></label></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><?PHP echo stringIt($row['Rows']); ?></label></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><?PHP echo round($row['Index_length']/1024,2). " KB"; ?></label></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><?PHP echo round($row['Data_free']/1024,2). " KB"; ?></label></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><?PHP echo stringIt($row['Comment']); ?></label></td>
													</tr>
<?PHP
						$row_count++;
					}
?>
													<tr>
														<td style="padding-top: 3px; padding-bottom: 3px;" align="center">
															<input type="checkbox" id="select_unselect" onClick="checkUncheckAll(this)" checked="checked">
														</td>
														<td colspan="<?PHP echo mysql_num_fields($result); ?>" style="padding-top: 3px; padding-bottom: 3px; padding-left: 5px;">
															<label for="select_unselect" style="display:block;width:100%;"><?PHP echo SELECT_UNSELECT_TEXT; ?></label>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr><td style="height:4px;"></td></tr>
									</table>
									<table width="100%" cellpadding="0" cellspacing="1" style="padding:5px;">
										<tr>
											<td style="padding-right:10px;" id="row1_1" width="100">
												<?PHP echo INCLUDE_ROWS_TEXT; ?>:</td>
											<td style="padding-right:10px;" id="row1_1">
												<input type="radio" name="rows_or_not" value="yes" id="yes" checked="checked"><label for="yes"> <?PHP echo YES_TEXT; ?></label> <input type="radio" name="rows_or_not" value="no" id="no"><label for="no"> <?PHP echo NO_TEXT; ?></label>
											</td>
										</tr>
										<tr>
											<td style="padding-right:10px;" id="row1_2" width="100">
												<?PHP echo INCLUDE_COMMENTS_TEXT; ?>:</td>
											<td style="padding-right:10px;" id="row1_2">
												<input type="radio" name="comments_or_not" value="yes" id="yes2" checked="checked"><label for="yes2"> <?PHP echo YES_TEXT; ?></label> <input type="radio" name="comments_or_not" value="no" id="no2"><label for="no2"> <?PHP echo NO_TEXT; ?></label>
											</td>
										</tr>
										<tr>
											<td style="padding-right:10px;" id="row1_1" width="100">
												<?PHP echo EXPORT_TO_TEXT; ?>:</td>
											<td style="padding-right:10px;" id="row1_1">
												<input type="radio" name="export_to" value="textarea" id="textarea" checked="checked"><label for="textarea"> <?PHP echo TEXTAREA_TEXT; ?></label> <input type="radio" name="export_to" value="file" id="file"><label for="file"> <?PHP echo FILE_TEXT; ?></label>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="padding-top:10px;">
												<input type="submit" id="button" name="submit" value="<?PHP echo EXPORT_BT_TEXT; ?>">
											</td>
										</tr>
									</table>
<?PHP
				} else {
?>
													<tr>
														<td id="error" colspan="7">
															<b><?PHP echo NO_TABLES_IN_DB_TEXT; ?></b></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>									
<?PHP
				}
?>
								</form>
<?PHP
			} else {
				if($_SESSION['backup_export_to'] == "textarea"){
?>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td id="title">
											<?PHP echo EXPORT_TABLES_TEXT; ?> '<?PHP echo stringIt($_SESSION['database']); ?>'
										</td>
									</tr>
									<tr>
										<td>
											<table width="100%" cellpadding="0" cellspacing="1">
												<tr>
													<td id="row1_1">
														<textarea style="width:100%;" rows="20"><?PHP echo stringIt($_SESSION['backup_sql']); ?></textarea>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr><td style="height:4px;"></td></tr>
								</table>
<?PHP				
					unset($_SESSION['backup_export_to']);
					unset($_SESSION['backup_sql']);
					
				}
			}
?>