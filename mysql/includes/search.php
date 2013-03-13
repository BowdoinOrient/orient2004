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
								<form name="search_table" action="actions.php?act=25" method="post">
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td id="title" align="left">
												<?PHP echo SEARCH_TABLE_TEXT; ?> '<?PHP echo stringIt($_SESSION['table']); ?>'
											</td>
										</tr>
										<tr>
											<td>
												<table width="100%" cellpadding="0" cellspacing="1">
													<tr>
														<td id="col2" align="left">
															<?PHP echo FIELD_NAME_TEXT; ?></td>
														<td id="col2" align="left">
															<?PHP echo TYPE_TEXT; ?></td>
														<td id="col2" align="left">
															<?PHP echo CLAUSE_TEXT; ?></td>
														<td id="col2" align="left">
															<?PHP echo VALUE_TEXT; ?></td>
														<td id="col2" align="center" width="10">
															<?PHP echo ORDER_TEXT; ?></td>
														<td id="col2" align="center" width="15">
															<?PHP echo FILTER_TEXT; ?></td>
														<td id="col2" align="center" width="7">
															<?PHP echo SHOW_TEXT; ?></td>
													</tr>
<?PHP
		$query_string = "SHOW COLUMNS FROM `".$_SESSION['table']."`";
		$result = mysql_query($query_string);
		
		$clause_class = array("=", ">", "<", ">=", "<=", "!=", "IS NOT NULL", "IS NULL", "BETWEEN", "LIKE", "NOT LIKE", "REGEXP");
		
		if(mysql_num_rows($result) > 0){
		
			$total = (is_array($_SESSION['form_post']['rows']))?count($_SESSION['form_post']['rows']):mysql_num_rows($result);
			
			$row_count = 0;
			
			while($row = mysql_fetch_assoc($result)){
				if(is_array($_SESSION['form_post']['rows'])){
					if(in_array($row['Field'], $_SESSION['form_post']['rows'])){
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
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<?PHP echo stringIt($row['Field']); ?>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<?PHP echo stringIt($row['Type']); ?>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="left">
															<input type="hidden" name="rows[]" value="<?PHP echo stringIt($row['Field']); ?>">
															<select style="width: 100%;" id="input" name="<?PHP echo stringItvTwo($row['Field']); ?>_clause">
<?PHP
					foreach($clause_class as $key=>$value){
?>
																<option><?PHP echo $value; ?></option>
<?PHP
					}
?>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input type="text" style="width: 100%;" name="<?PHP echo stringItvTwo($row['Field']); ?>" id="input">
														</td>
														<td align="center" id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<select name="<?PHP echo stringItvTwo($row['Field']); ?>_order" id="input">
																<option></option>
<?PHP
					for($i=0; $i<$total; $i++){
?>
																<option><?PHP echo $i+1; ?></option>
<?PHP
					}
?>
															</select>
														</td>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>" align="center">
															<select name="<?PHP echo stringItvTwo($row['Field']); ?>_filter" id="input">
																<option>ASC</option>
																<option>DESC</option>
															</select>
														</td>
														<td align="center" id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<input checked="checked" type="checkbox" name="show_rows[]" value="<?PHP echo stringIt($row['Field']); ?>">
														</td>
													</tr>
<?PHP
					$row_count++;
				}
			}
			
			$row_num = ($row_count % 2)?2:1; ?>
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
									<table width="100%" cellpadding="0" cellspacing="1" style="padding:5px;">
									<tr>
											<td style="padding-right:10px;" id="row1_1" width="100" align="left">
												<?PHP echo DISTINCT_TEXT; ?>:</td>
											<td style="padding-right:10px;" id="row1_1" align="left">
												<input type="radio" name="distinct_choose" value="no" id="Distinct_no" checked="checked"><label for="Distinct_no"> <?PHP echo NO_TEXT; ?></label> <input type="radio" name="distinct_choose" value="yes" id="Distinct_yes"><label for="Distinct_yes"> <?PHP echo YES_TEXT; ?></label>
											</td>
										</tr>
										<tr>
											<td style="padding-right:10px;" id="row1_2" width="100" align="left">
												<?PHP echo BROWSE_TEXT; ?>:</td>
											<td style="padding-right:10px;" id="row1_2" align="left">
												<input type="radio" name="browse_choose" value="all" id="Browse_all" checked="checked"><label for="Browse_all"> <?PHP echo ALL_FIELDS_TEXT; ?></label> <input type="radio" name="browse_choose" value="selected" id="Browse_selected"><label for="Browse_selected"> <?PHP echo SELECTED_FIELDS_TEXT; ?></label>
											</td>
										</tr>
										<tr>
											<td style="padding-right:10px;" id="row1_1" width="100" align="left">
												<?PHP echo SEARCH_TEXT; ?>:</td>
											<td style="padding-right:10px;" id="row1_1" align="left">
												<input type="radio" name="empty_choose" value="selected" id="Search_selected" checked="checked"><label for="Search_selected"> <?PHP echo UNEMPTY_VALS_TEXT; ?></label> <input type="radio" name="empty_choose" value="all" id="Search_all"><label for="Search_all"> <?PHP echo ALL_FIELDS_TEXT; ?></label>
											</td>
										</tr>
									</table>
									<table cellpadding="0" cellspacing="0" style="padding:5px;">
										<tr>
											<td align="left">
												<input type="submit" name="submit" value="<?PHP echo SEARCH_TEXT; ?>" id="button">
											</td>
										</tr>
									</table>
								</form>