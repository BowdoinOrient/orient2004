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
		$rows = $post['rows']; ?>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td id="title"><?PHP echo VIEW_ROWS_TABLE_TEXT; ?> '<?PHP echo stringIt($_SESSION['table']); ?>'</td>
									</tr>
									<tr>
										<td>
											<table width="100%" cellpadding="0" cellspacing="1">
<?PHP		
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
													<td id="col2"><?PHP echo FIELD_NAME_TEXT; ?></td>
													<td id="col2"><?PHP echo VALUE_TEXT; ?></td>
												</tr>
<?PHP
			$edit_explode = $_SESSION['form_post']['values'][$value];
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
				
				$edit_explode[$r] = nl2br(stringIt($edit_explode[$r])); ?>
												<tr>
													<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" valign="top"><?PHP echo stringIt($field_name[$r]); ?></td>
													<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" style="white-space:normal;"><?PHP echo $edit_explode[$r]; ?></td>
												</tr>
<?PHP
				$row_num = ($row_num == 1)?2:1;
				
			}
			
			$r++;
		}
?>
											</table>
										</td>
									</tr>
								</table>