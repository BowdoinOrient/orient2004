<?PHP
defined('_VALID_INCLUDE') or die(header("Location: ../index.php"));
 
			$query_string = "SHOW VARIABLES";
			$result = @mysql_query($query_string);

			$row_count = 0; ?>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td id="title">
											<?PHP echo SYSTEM_VAR_TEXT; ?>
										</td>
									</tr>
									<tr>
										<td>
											<table width="100%" cellpadding="0" cellspacing="1">
												<tr>
													<td id="col1">
														<?PHP echo VAR_NAME_TEXT; ?></td>
													<td id="col1">
														<?PHP echo VALUE_TEXT; ?></td>
												</tr>
<?PHP
			while($rows = @mysql_fetch_assoc($result)){
				switch($rows['Variable_name']){
					case "character_sets":

					break;
				}

				$row_num = ($row_count % 2)?2:1; ?>
												<tr>
													<td id="row1_<?PHP echo $row_num; ?>">
														<?PHP echo stringIt($rows['Variable_name']); ?></td>
													<td id="row1_<?PHP echo $row_num; ?>">
														<?PHP echo stringIt($rows['Value']); ?></td>
												</tr>
<?PHP
				$row_count++;
			}
?>
											</table>
										</td>
									</tr>
								</table>