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
		
		$post = $_SESSION['form_post'];
		$rows = $post['rows'];
		$row_num = 1;
		$this_tab_q = "SHOW COLUMNS FROM `".$_SESSION['table']."`";
		$this_result = mysql_query($this_tab_q);
		$num_fields = mysql_num_rows($this_result);
		$for_id = mysql_query("SELECT * FROM `".$_SESSION['table']."`"); ?>
							<form action="actions.php?act=13" method="POST">
								<table width="100%" cellpadding="0" cellspacing="1">
									<tr>
										<td id="title" colspan="<?PHP echo $num_fields; ?>">
											<?PHP echo ARE_YOU_SURE_DROP_ROWS_TEXT; ?>
										</td>
									</tr>
									<tr>
<?PHP
		$r = 0;
		while($ii_row = mysql_fetch_array($this_result)){
			$field[] = $ii_row['Field'];
			$field_id = mysql_fetch_field($for_id, $r);
			if($field_id->primary_key == 1){
				$id_row = $field_id->name;
			}
			
			if($enable_primary == true){
				$col_num = ($id_row == $ii_row['Field'])?3:2;
			} else {
				$col_num = 2;
			}
?>
											<td id="col<?PHP echo $col_num; ?>">
												<?PHP echo stringIt($ii_row['Field']); ?>
											</td>
<?PHP
			$r++;
		}
?>
								  </tr>
<?PHP
		foreach($rows as $key=>$drop_implode){
?>
										<tr>
<?PHP
			$drop_explode = $_SESSION['form_post']['values'][$drop_implode];
			$put_out_query = "DELETE FROM `".$_SESSION['table']."` ";
			for($l=0;$l<(count($drop_explode));$l++){
				$i_row = $l;
				if($enable_primary == true){
					$col = ($field[$i_row] == $id_row)?2:1;
					$primary = true;
				} else {
					$col = 1;
				}
					
				if($primary == true){
					if($col == 2){
						$put_out_where = "WHERE `".$field[$i_row]."` = '".mysql_escape_string($drop_explode[$i_row])."'";
						$put_out_where_2 = "WHERE `".$field[$i_row]."` = '".nl2br(stringIt($drop_explode[$i_row]))."'";
					}
				} else {
					if(empty($put_out_where)){
						$put_out_where = "WHERE `".$field[$i_row]."` = '".mysql_escape_string($drop_explode[$i_row])."'";
						$put_out_where_2 = "WHERE `".$field[$i_row]."` = '".nl2br(stringIt($drop_explode[$i_row]))."'";
					} else {
						$put_out_where = $put_out_where." AND `".$field[$i_row]."` = '".mysql_escape_string($drop_explode[$i_row])."'";
						$put_out_where_2 = $put_out_where_2." AND `".$field[$i_row]."` = '".nl2br(stringIt($drop_explode[$i_row]))."'";
					}
				}
				
				$value = (strlen($drop_explode[$i_row]) > 50)?substr($drop_explode[$i_row], 0, 50)."...":$drop_explode[$i_row]; ?>
											<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
												<?PHP echo stringIt($value); ?>
											</td>
<?PHP
			
			}
			
			$row_num = ($row_num == 1)?2:1;
			
			$final_drop_q = $put_out_query.$put_out_where." LIMIT 1";
			$final_drop_q_2 = $put_out_query.$put_out_where_2." LIMIT 1"; ?>
												<input type="hidden" name="drop_query[]" value="<?PHP echo stringIt($final_drop_q); ?>">
												<input type="hidden" name="drop_query_2[]" value="<?PHP echo stringIt($final_drop_q_2); ?>">
											
<?PHP
			$put_out_where = ""; ?>
										</tr>
<?PHP
		}
?>
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
									<table width="100%" cellspacing="0" cellpadding="0" style="padding:5px;">
										<tr>
											<td style="padding-right:10px;" id="row1_1" width="100">
												<?PHP echo OPTIMIZE_AFTER_DELETE_TEXT; ?>:</td>
											<td style="padding-right:10px;" id="row1_1">
												<input type="radio" id="no2" name="optimize_on" value="no" checked="checked"><label for="no2"> No</label> <input type="radio" id="yes2" name="optimize_on" value="yes"><label for="yes2"> Yes</label>
											</td>
										</tr>
									</table>
									<table cellspacing="0" cellpadding="0" style="padding:5px; padding-top:0px;">
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