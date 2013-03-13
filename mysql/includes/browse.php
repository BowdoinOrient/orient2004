<?PHP
defined('_VALID_INCLUDE') or die(header("Location: ../index.php"));
 
		$table_query_string = "SHOW TABLE STATUS FROM `".$_SESSION['database']."` LIKE '".mysql_escape_string($_SESSION['table'])."'";
		$table_result = mysql_query($table_query_string);

		$table_row = mysql_fetch_assoc($table_result);

		if(empty($_SESSION['ex_query_info']['start'])) $_SESSION['ex_query_info']['start'] = 0;
		if(empty($_SESSION['ex_query_info']['limit'])) $_SESSION['ex_query_info']['limit'] = 30;
		if(empty($_SESSION['ex_query_info']['page'])) $_SESSION['ex_query_info']['page'] = 1;
		if(!empty($_SESSION['ex_query_info']['sort_by'])){
			$sort_order = ($_SESSION['ex_query_info']['sort_order'] == ("asc" || "desc"))?" ".strtoupper($_SESSION['ex_query_info']['sort_order']):NULL;
			$order_by = " ORDER BY `".$_SESSION['ex_query_info']['sort_by']."`".$sort_order;
		}

		if(empty($_SESSION['browse_query'])){
			if(!empty($_SESSION['form_post']['rows'])){
				$query_select_count = count($_SESSION['form_post']['rows']);
				$a = 0;
	
				foreach($_SESSION['form_post']['rows'] as $value){
					$query_select = ($a != 0)?$query_select.",`".$value."`":"`".$value."`";
					$a++;
				}
			} else $query_select = "*";

			$query_string = "SELECT ".$query_select." FROM  `".$_SESSION['table']."`".$order_by." LIMIT ".$_SESSION['ex_query_info']['start'].",".$_SESSION['ex_query_info']['limit'];
		} else {
			if($_SESSION['search_q'] == true){
				if(!empty($_SESSION['ex_query_info']['sort_by'])){
					$sort_order = ($_SESSION['ex_query_info']['sort_order'] == ("asc" || "desc"))?" ".strtoupper($_SESSION['ex_query_info']['sort_order']):NULL;
					$order_by = " ORDER BY `".$_SESSION['ex_query_info']['sort_by']."`".$sort_order;
					if(eregi("ORDER BY", $_SESSION['browse_query'])){
						$new_string = explode(" ORDER BY", $_SESSION['browse_query']);						
						$new_query_string = $new_string[0].$order_by." LIMIT ".$_SESSION['ex_query_info']['start'].",".$_SESSION['ex_query_info']['limit'];
					} else {
						$new_query_string = $_SESSION['browse_query'].$order_by." LIMIT ".$_SESSION['ex_query_info']['start'].",".$_SESSION['ex_query_info']['limit'];
					}
				}
				$query_string = (empty($new_query_string))?$_SESSION['browse_query']." LIMIT ".$_SESSION['ex_query_info']['start'].",".$_SESSION['ex_query_info']['limit']:$new_query_string;
				$last_query_string = (empty($new_query_string))?$_SESSION['last_edit_query']." LIMIT ".$_SESSION['ex_query_info']['start'].",".$_SESSION['ex_query_info']['limit']:$new_query_string;
			} else {
				$query_string = $_SESSION['browse_query'];
			}
		}
		
		if(!empty($_SESSION['browse_query'])){
			$browse_query = $query_string;
		}

		$result = mysql_query($query_string);

		$_SESSION['last_query'] = stringIt($query_string);

		if(!$result) $_SESSION['mysql_error'] = mysql_error();

		if(empty($_SESSION['browse_query']) && $_SESSION['search_q'] != true){
			$num_pages = ceil($table_row['Rows'] / $_SESSION['ex_query_info']['limit']);
		} else {
			$num_pages = ceil(mysql_num_rows(mysql_query($_SESSION['browse_query'])) / $_SESSION['ex_query_info']['limit']);
		}
		
		$total_records = mysql_query("SELECT * FROM `".$_SESSION['table']."`");
		$total_recs = mysql_num_rows($total_records);
		
		if(!empty($_SESSION['last_edit_query'])){
			$_SESSION['last_query'] = (empty($last_query_string))?$_SESSION['last_edit_query']:$last_query_string;
		}

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
								<form name="browseproperties" action="actions.php?act=16" method="post">
									<table width="100%" cellpadding="10" cellspacing="0">
										<tr>
											<td align="left">
												<?PHP echo SHOW_TEXT; ?> <input size="2" id="input" type="text" name="limit" value="<?PHP echo stringIt($_SESSION['ex_query_info']['limit']); ?>"> <?PHP echo ROWS_START_ROW_TEXT; ?> <input size="2" id="input" type="text" name="start" value="<?PHP echo stringIt($_SESSION['ex_query_info']['start']); ?>"> <input type="submit" name="submit" value="<?PHP echo SHOW_TEXT; ?>" id="button">
											</td>
										</tr>
									</table>
								</form>
<?PHP
		if($num_pages > 1){
?>
								<table width="100%" cellpadding="10" cellspacing="0">
									<tr>
										<td align="left">
											<?PHP echo PAGES_TEXT; ?>: 
<?PHP
			if($_SESSION['ex_query_info']['page'] > 1){
?>
												<a href="actions.php?act=16&p=<?PHP echo $_SESSION['ex_query_info']['page']-1; ?>" style="padding: 0px 3px 0px 0px;"><<</a>
<?PHP
			}
			for($i=1;$i<=$num_pages;$i++){
				if($i == $_SESSION['ex_query_info']['page']){
?>
												<span style="padding: 0px 3px 0px 0px;"><b><?PHP echo $i; ?></b></span>
<?PHP
				} else {
?>
												<a href="actions.php?act=16&p=<?PHP echo $i; ?>" style="padding: 0px 3px 0px 0px;"><?PHP echo $i; ?></a>
<?PHP
				}
			}
			if($_SESSION['ex_query_info']['page'] < $num_pages){
?>
												<a href="actions.php?act=16&p=<?PHP echo $_SESSION['ex_query_info']['page']+1; ?>" style="padding: 0px 3px 0px 0px;">>></a>
<?PHP
			}
?>
										</td>
									</tr>
								</table>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr><td style="height:4px;"></td></tr>
								</table>
<?PHP
		}
?>
								<form name="tableoverview" action="actions.php?act=5" method="post">
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td id="title" align="left">
												<?PHP echo BROWSING_TABLE_TEXT; ?> '<?PHP echo stringIt($_SESSION['table']); ?>'<?PHP echo ($total_recs > 0)?" - [$total_recs ".TOTAL_RECORDS_TEXT."]":NULL?>
											</td>
										</tr>
										<tr>
											<td align="left">
												<table width="100%" cellpadding="0" cellspacing="1" style="overflow:auto;">
													<tr>
														<td id="col1" width="10">&nbsp;</td>
														<td id="col1" colspan="3">&nbsp;</td>
<?PHP
		$pri_keys = array();
		$i = 0;
		while ($i < mysql_num_fields($result)) {
			$meta = mysql_fetch_field($result, $i);
			if($enable_primary == true){
				$col = ($meta->primary_key == 1)?3:2;
			} else {
				$col = 2;
			}

			if($meta->primary_key == 1) $pri_keys[] = $i;
				if($_SESSION['ex_query_info']['sort_by'] == $meta->name){
					$img = "<img src=\"themes/".$_THEME."/images/".strtoupper($_SESSION['ex_query_info']['sort_order'])."_arrow.gif\">";
				}
?>
														<td id="col<?PHP echo $col; ?>">
															<?PHP echo $img; ?> <a href="actions.php?act=16&do=order&field=<?PHP echo urlencode($meta->name); ?>"><?PHP echo stringIt($meta->name); ?></a></td>
<?PHP
			$img = "";
			$i++;
		}
?>
													</tr>
<?PHP
		if (mysql_num_rows($result) > 0) {
			$row_count = 0;
			
			if(!empty($browse_query)){
				$runat_query = $browse_query;
				if(preg_match("#(select) (distinct|sum|min|max|mix|count|avg|std|stddev|bit_or|bit_and)(.*?) (from) (.*?)#isU", $runat_query)){
					$disable = true;
				} else if(preg_match("#(select) (.*?) (from) (.*?)#isU", $runat_query, $matches)){
					if(eregi("sum", $matches[2]) || eregi("max", $matches[2]) || eregi("min", $matches[2]) || eregi("mix", $matches[2]) || eregi("count", $matches[2]) || eregi("avg", $matches[2]) || eregi("std", $matches[2]) || eregi("stddev", $matches[2]) || eregi("bit_or", $matches[2]) || eregi("bit_and", $matches[2])){
						$disable = true;
					} else {
						$browse_query = "SELECT * FROM ".$matches[4];
					}
				} else {
					$disable = true;
				}
				$info_query = mysql_query($browse_query);
			} else {
				$info_query = mysql_query("SELECT * FROM `".$_SESSION['table']."`".$order_by." LIMIT ".$_SESSION['ex_query_info']['start'].",".$_SESSION['ex_query_info']['limit']."");
			}
			
			$ww = 0;
			if($disable != true){
				while($l_row = mysql_fetch_array($info_query)){
					for($s=0;$s<mysql_num_fields($info_query);$s++){
?>
					<input type="hidden" name="values[<?PHP echo $ww; ?>][<?PHP echo $s; ?>]" value="<?PHP echo stringIt($l_row[$s]); ?>">
<?PHP
					}		
					$ww++;
				}
			}
			
			while ($row = mysql_fetch_array($result)) {
				$row_num = ($row_count % 2)?2:1; ?>
													<tr>
	
														<td align="center">
															<input type="checkbox" id="<?PHP echo $row_count; ?>" name="rows[]" value="<?PHP echo $row_count; ?>"<?PHP echo ($disable == true)?" disabled=\"disabled\"":NULL; ?>></td>
														<td id="row1_<?PHP echo $row_num; ?>" width="10" align="center">
															<?PHP if($disable != true){ ?><a href="javascript:manRow('<?PHP echo $row_count; ?>','viewrow');"><img src="themes/<?PHP echo $_THEME; ?>/images/view_button.gif" alt="<?PHP echo VIEW_ROW_TEXT; ?>" title="<?PHP echo VIEW_ROW_TEXT; ?>" border="0"></a><?PHP } else { ?><img src="themes/<?PHP echo $_THEME; ?>/images/view_button_disabled.gif"><?PHP } ?></td>
														<td id="row1_<?PHP echo $row_num; ?>" width="10" align="center">
															<?PHP if($disable != true){ ?><a href="javascript:manRow('<?PHP echo $row_count; ?>','editrow');"><img src="themes/<?PHP echo $_THEME; ?>/images/edit_button.gif" alt="<?PHP echo EDIT_ROW_TEXT; ?>" title="<?PHP echo EDIT_ROW_TEXT; ?>" border="0"></a><?PHP } else { ?><img src="themes/<?PHP echo $_THEME; ?>/images/edit_button_disabled.gif"><?PHP } ?></td>
														<td id="row1_<?PHP echo $row_num; ?>" width="10" align="center">
															<?PHP if($disable != true){ ?><a href="javascript:manRow('<?PHP echo $row_count; ?>','droprow');"><img src="themes/<?PHP echo $_THEME; ?>/images/delete_button.gif" alt="<?PHP echo DELETE_ROW_TEXT; ?>" title="<?PHP echo DELETE_ROW_TEXT; ?>" border="0"></a><?PHP } else { ?><img src="themes/<?PHP echo $_THEME; ?>/images/delete_button_disabled.gif"><?PHP } ?></td>
<?PHP
				for($b=0;$b<mysql_num_fields($result);$b++){
					if($enable_primary == true){
						$col = (array_search($b,$pri_keys) !== false)?2:1;
					} else {
						$col = 1;
					}
					$value = (strlen($row[$b]) > 50 && $disable != true)?substr($row[$b], 0, 50)."...":$row[$b]; ?>
														<td id="row<?PHP echo $col; ?>_<?PHP echo $row_num; ?>">
															<label for="<?PHP echo $row_count; ?>" style="display:block;width:100%;"><?PHP echo stringIt($value); ?></label></td>
<?PHP
				}
?>
													</tr>
<?PHP
				$row_count++;
			}
?>
													<tr>
														<td style="padding-top: 3px; padding-bottom: 3px;" align="center">
															<input type="checkbox" id="select_unselect" onClick="checkUncheckAll(this)"<?PHP echo ($disable == true)?" disabled=\"disabled\"":NULL; ?>>
														</td>
														<td colspan="<?PHP echo mysql_num_fields($result)+3; ?>" style="padding-top: 3px; padding-bottom: 3px; padding-left: 5px;">
															<label for="select_unselect" style="display:block;width:100%;"><?PHP echo SELECT_UNSELECT_TEXT; ?></label>
														</td>
													</tr>
<?PHP
		} else {
?>
													<tr>
														<td id="error" colspan="<?PHP echo mysql_num_fields($result)+4; ?>">
															<b><?PHP echo NO_ROWS_ERROR_TEXT; ?></b></td>
													</tr>
<?PHP
		}
?>
												</table>
											</td>
										</tr>
									</table>
									<table cellpadding="0" cellspacing="0" style="padding:5px;" width="100%">
										<tr>
											<td width="125" style="padding-right:10px;" align="left">
												<?PHP echo WITH_SELECTED_TEXT; ?>:</td>
											<td style="padding-right:10px;" align="left">
												<select name="action"<?PHP echo ($disable != true)?" onChange=\"javascript:document.tableoverview.submit();\"":" disabled=\"disabled\""; ?>>
													<option></option>
													<option value="viewrow"><?PHP echo VIEW_TEXT; ?></option>
													<option value="editrow"><?PHP echo EDIT_TEXT; ?></option>
													<option value="droprow"><?PHP echo DELETE_TEXT; ?></option>
												</select>
											</td>
										</tr>
									</table>
								</form>