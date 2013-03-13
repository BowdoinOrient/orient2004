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
								<form name="tableopperations" action="actions.php?act=18" method="post">
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td id="title">
												<?PHP echo ARE_YOU_SURE_DROP_FIELDS_TEXT; ?>
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
															<?PHP echo NULL_TEXT; ?></td>
														<td id="col2">
															<?PHP echo DEFAULT_TEXT; ?></td>
														<td id="col2">
															<?PHP echo EXTRA_TEXT; ?></td>
													</tr>

<?PHP
		$post = $_SESSION['form_post'];
		$fields = $post['rows'];
		
		foreach($fields as $key=>$value){
?>
													<input type="hidden" name="rows[]" value="<?PHP echo stringIt($value); ?>">
<?PHP
		}
				
		for($i=0;$i<(count($fields));$i++){
			$field_name = $fields[$i];
			$num_we = count($fields) - 1;
			if($i == $num_we){
				$fields_query = $fields_query."`$field_name`";
			} else {
				$fields_query = $fields_query."`$field_name`, ";
			}
		}
		
		$get_fields = "SELECT ".$fields_query." FROM `".$_SESSION['table']."`";
		$result = mysql_query($get_fields);
		$all_fields = mysql_query("SHOW COLUMNS FROM `".$_SESSION['table']."`");
		$row_num = 1;
		
		$all_field = array();
		while($row = mysql_fetch_array($all_fields)){
			$all_field[] = $row;
		}
		
		$fields_num = mysql_num_fields($result);
		$drop_query = array();		
		for($i=0;$i<$fields_num;$i++){
			$get_cur_field = mysql_fetch_field($result, $i);
			
			foreach($all_field as $key=>$value){
				if($get_cur_field->name == $value['Field']){
					$this_info = $value;
				}
			}	
			
			if($i == (mysql_num_fields($result) - 1)){
				$drop_query[$i] = "DROP `".$get_cur_field->name."`";
			} else {
				$drop_query[$i] = "DROP `".$get_cur_field->name."`, ";
			}
?>
													<input type="hidden" name="drop_query[]" value="<?PHP echo stringIt($drop_query[$i]); ?>">
<?PHP			
			$null = ($get_cur_field->not_null == 1)?"No":"Yes";
			
			if($enable_primary == true){
				$col = ($get_cur_field->primary_key == 1)?2:1;
			} else {
				$col = 1;
			}
			
?>
													<tr>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<?PHP echo stringIt($get_cur_field->name); ?>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<?PHP echo stringIt($this_info['Type']); ?>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<?PHP echo $null; ?>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<?PHP echo stringIt($this_info['Default']); ?>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<?PHP echo stringIt($this_info['Extra']); ?>
														</td>
													</tr>
<?PHP
			$row_num = ($row_num == 1)?2:1;
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