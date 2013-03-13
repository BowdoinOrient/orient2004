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
								<form name="dbopperations" action="actions.php?act=21" method="post">
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td id="title">
												<?PHP echo ARE_YOU_SURE_DROP_DATABASES_TEXT; ?>
											</td>
										</tr>
										<tr>
											<td>
												<table width="100%" cellpadding="0" cellspacing="1">
													<tr>
														<td id="col2" align="left">
															<?PHP echo NAME_TEXT; ?></td>
														<td id="col2" align="left">
															<?PHP echo TABLES_TEXT; ?></td>
														<td id="col2" align="left">
															<?PHP echo RECORDS_TEXT; ?></td>
														<td id="col2" align="left">
															<?PHP echo SIZE_TEXT; ?></td>
													</tr>

<?PHP
			$result = mysql_list_dbs();
			if(@mysql_num_rows($result) > 0){

				$row_count = 0;
				$total_rows = 0;
				$total_size = 0;

				while ($row = mysql_fetch_assoc($result)) {
					if(is_array($_SESSION['form_post']['rows'])){
						if(array_search($row['Database'],$_SESSION['form_post']['rows']) !== false){
							$continue = true;
						} else {
						$continue = false;
						}
					} else {
						$continue = true;
					}
					if($continue == true){
						$get_tables = mysql_query("SHOW TABLE STATUS FROM `".$row['Database']."`");
						$tables_num = mysql_num_rows($get_tables);
						while($row2 = mysql_fetch_assoc($get_tables)){
							$total_size += $row2['Index_length'];
							$total_rows += $row2['Rows'];
						}
						$row_num = ($row_count % 2)?2:1;
?>
													<tr>
														<td id="row1_<?PHP echo $row_num; ?>" align="left">
															<?PHP echo stringIt($row['Database']); ?>
														</td>
														<td id="row1_<?PHP echo $row_num; ?>" align="left">
															<?PHP echo stringIt($tables_num); ?>
														</td>
														<td id="row1_<?PHP echo $row_num; ?>" align="left">
															<?PHP echo stringIt($total_rows); ?>
														</td>
														<td id="row1_<?PHP echo $row_num; ?>" align="left">
															<?PHP echo stringIt(round($total_size/1024, 2)." KB"); ?>
														</td>
													</tr>
<?PHP
						$total_size = 0;
						$total_rows = 0;
						$row_count++;
					}
				}
			} else {
?>
													<tr>
														<td id="error" colspan="4">
															<?PHP echo UNABLE_GET_DATA_ERROR_TEXT; ?></td>
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