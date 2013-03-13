<?PHP
defined('_VALID_INCLUDE') or die(header("Location: ../index.php"));
 
			$result = @mysql_query("SHOW TABLE STATUS FROM `".$_SESSION['database']."`");
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
											<?PHP echo LAST_MYSQL_QUERY; ?>:
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
								<form name="tableopperations" action="actions.php?act=8" method="post">
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td id="title">
												<?PHP echo ARE_YOU_SURE_DROP_TABLES_TEXT; ?>
											</td>
										</tr>
										<tr>
											<td>
												<table width="100%" cellpadding="0" cellspacing="1">
													<tr>
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
			if(@mysql_num_rows($result) > 0){

				$row_count = 0;

				while ($row = mysql_fetch_assoc($result)) {
					if(is_array($_SESSION['form_post']['rows'])){
						if(array_search($row['Name'],$_SESSION['form_post']['rows']) !== false){
							$continue = true;
						} else {
						$continue = false;
						}
					} else {
						$continue = true;
					}
					if($continue == true){
						$row_num = ($row_count % 2)?2:1;
						$col = ($row['Key'] == "PRI")?2:1; ?>
													<tr>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<?PHP echo stringIt($row['Name']); ?></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<?PHP echo (!empty($row['Type']))?stringIt($row['Type']):stringIt($row['Engine']); ?></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<?PHP echo stringIt($row['Rows']); ?></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<?PHP echo round($row['Index_length']/1024,2). " KB"; ?></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<?PHP echo round($row['Data_free']/1024,2). " KB"; ?></td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<?PHP echo stringIt($row['Comment']); ?></td>
													</tr>
<?PHP
						$row_count++;
					}
				}
			} else {
?>
													<tr>
														<td id="error" colspan="6">
															<?PHP echo NO_TABLES_IN_DB_TEXT; ?></td>
													</tr>
<?PHP
			}
?>
												</table>

											</td>
										</tr>
									</table>
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr><td style="height:4px;"></td></tr>
									</table>
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td id="error">
												<?PHP echo CANNOT_BE_UNDONE_TEXT; ?>
											</td>
										</tr>
									</table>
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr><td style="height:4px;"></td></tr>
									</table>
									<table cellpadding="0" cellspacing="0" style="padding:5px;">
										<tr>
											<td style="padding-right:10px;">
												<?PHP echo ARE_YOU_SURE_TEXT; ?>:</td>
											<td style="padding-right:10px;">
												<input type="radio" id="no" name="confirm" value="no" checked><label for="no"> <?PHP echo NO_TEXT; ?></label> <input type="radio" id="yes" name="confirm" value="yes"><label for="yes"> <?PHP echo YES_TEXT; ?></label>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="padding-top:10px;">
												<input type="submit" id="button" name="submit" value="<?PHP echo OK_TEXT; ?>">
											</td>
										</tr>
									</table>
								</form>