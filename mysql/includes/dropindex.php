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
								<form name="dropins" action="actions.php?act=19" method="post">
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td id="title">
												<?PHP echo ARE_YOU_SURE_DROP_INDEX_TEXT; ?>
											</td>
										</tr>
										<tr>
											<td>
												<table width="100%" cellpadding="0" cellspacing="1">
													<tr>
														<td id="col2">
															<?PHP echo KEYNAME_TEXT; ?></td>
														<td id="col2">
															<?PHP echo TYPE_TEXT; ?></td>
														<td id="col2">
															<?PHP echo FIELD_TEXT; ?></td>
														<td id="col2">
															<?PHP echo CARDINALITY_TEXT; ?></td>
													</tr>
<?PHP
		
		$post = $_SESSION['form_post'];
		$indexes = $post['index'];
		$get_indexes = "SHOW INDEX FROM `".$_SESSION['table']."`";
		$result = mysql_query($get_indexes);
		
		$row_num = 1;
		
		while($in = mysql_fetch_assoc($result)){
			if(in_array($in["Key_name"], $indexes)){
				if($in["Key_name"] == "PRIMARY"){
					$col = 2;
				} else {
					$col = 1;
				}
				if(empty($in["Comment"])){
					if($in["Key_name"] == "PRIMARY"){
						$in['Comment'] = "PRIMARY";
					} else {
						if($in["Non_unique"] == 1){
							$in['Comment'] = "INDEX";
						} else {
							$in['Comment'] = "UNIQUE";
						}
					}
				}
				if(is_null($in['Cardinality'])){
					$in['Cardinality'] = "None";
				}
?>
													<tr>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<?PHP echo stringIt($in['Key_name']); ?>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<?PHP echo stringIt($in['Comment']); ?>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<?PHP echo stringIt($in['Column_name']); ?>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<?PHP echo stringIt($in['Cardinality']); ?>
														</td>
													</tr>
<?PHP
				$row_num = ($row_num == 1)?2:1;
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
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td id="error">
												<?PHP echo CANNOT_BE_UNDONE_TEXT; ?>
											</td>
										</tr>
									</table>	
									<table cellspacing="0" cellpadding="0" style="padding:5px;">
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