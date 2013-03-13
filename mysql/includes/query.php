<?PHP
defined('_VALID_INCLUDE') or die(header("Location: ../index.php"));
 
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

			if(!empty($_SESSION['last_query'])){
?>
								<table width="100%" cellpadding="0" cellspacing="1">
									<tr>
										<td id="query_bottom">
											<?PHP echo LAST_QUERY; ?>:
										</td>
									</tr>
									<tr>
										<td id="query">
											<?PHP echo nl2br(stringIt(stripslashes($_SESSION['last_query']))); ?>
										</td>
									</tr>
								</table>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr><td style="height:4px;"></td></tr>
								</table>
<?PHP
			}
?>
								<form name="tableopperations" action="actions.php?act=11" method="post">
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td id="title">
												<?PHP echo QUERY_WINDOW_TEXT; ?>
											</td>
										</tr>
										<tr>
											<td>
												<table width="100%" cellpadding="0" cellspacing="1">
													<tr>
														<td id="row1_1">
															<textarea id="input" name="query" style="width:100%" rows="10"><?PHP echo $_SESSION['query_line']; ?></textarea></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr><td style="height:4px;"></td></tr>
									</table>
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td>
												<input type="submit" value="<?PHP echo EXECUTE_TEXT; ?>" name="submit" id="button"></td>
										</tr>
									</table>
								</form>
								<form name="tableopperations" action="actions.php?act=17" method="post" enctype="multipart/form-data">
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr><td style="height:4px;"></td></tr>
									</table>
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td id="title">
												<?PHP echo LOAD_FILE_TEXT; ?>
											</td>
										</tr>
										<tr>
											<td>
												<table width="100%" cellpadding="0" cellspacing="1">
													<tr>
														<td id="row1_1">
															<?PHP echo LOAD_FILE_MESS_TEXT; ?></td>
													</tr>
													<tr>
														<td id="row1_2">
															<?PHP echo FILE_TEXT; ?>: <input type="file" name="file" id="input"></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr><td style="height:4px;"></td></tr>
									</table>
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td>
												<input type="submit" value="<?PHP echo LOAD_TEXT; ?>" name="submit" id="button"></td>
										</tr>
									</table>
								</form>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr><td style="height:4px;"></td></tr>
								</table>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td id="title">
											<?PHP echo PREV_QUERY_TEXT; ?>
										</td>
									</tr>
									<tr>
										<td>
											<table width="100%" cellpadding="0" cellspacing="1">
												<tr>
													<td id="col1" width="2%">&nbsp;</td>
													<td id="col2" colspan="3"></td>
													<td id="col2">
														<?PHP echo QUERY_TEXT; ?>
													</td>
												</tr>
<?PHP
			$not_empty = 0;
			$row_num = 1;
			for($i=0;$i<5;$i++){
				if(!empty($_SESSION['prev_query'][$i])){
					$not_empty++;
				}
			}
			
			if($not_empty > 0){
				for($i=0;$i<5;$i++){
					if(!empty($_SESSION['prev_query'][$i])){
						$numm = $i + 1; ?>
												<tr>
													<td align="center" id="row1_<?PHP echo $row_num; ?>" width="2%">
														<?PHP echo $numm; ?>
													</td>
													<td id="row1_<?PHP echo $row_num; ?>" width="10" align="center">
															<a href="actions.php?act=11&query=<?PHP echo $i; ?>"><img src="themes/<?PHP echo $_THEME; ?>/images/executequery_button.gif" alt="<?PHP echo EXECUTE_QUERY_TEXT; ?>" title="<?PHP echo EXECUTE_QUERY_TEXT; ?>" border="0"></a></td>
													<td id="row1_<?PHP echo $row_num; ?>" width="10" align="center">
															<a href="actions.php?act=5&do=view_query&query=<?PHP echo $i; ?>"><img src="themes/<?PHP echo $_THEME; ?>/images/viewquery_button.gif" alt="<?PHP echo VIEW_QUERY_TEXT; ?>" title="<?PHP echo VIEW_QUERY_TEXT; ?>" border="0"></a></td>
													<td id="row1_<?PHP echo $row_num; ?>" width="10" align="center">
															<a href="actions.php?act=5&do=edit_query&query=<?PHP echo $i; ?>"><img src="themes/<?PHP echo $_THEME; ?>/images/editquery_button.gif" alt="<?PHP echo EDIT_QUERY_TEXT; ?>" title="<?PHP echo EDIT_QUERY_TEXT; ?>" border="0"></a></td>
													<td id="row1_<?PHP echo $row_num; ?>">
														<?PHP echo substr(stringIt($_SESSION['prev_query'][$i]), 0, 110); ?><?PHP echo (strlen($_SESSION['prev_query']) > 110)?"...":NULL; ?>
													</td>
												</tr>
<?PHP
						$row_num = ($row_num == 1)?2:1;
					}
				}
			} else {
?>
												<tr>
													<td id="error" colspan="5">
														<b><?PHP echo NO_QUERY_ERROR_TEXT; ?></b>
													</td>
												</tr>
<?PHP
			}
?>
											</table>
										</td>
									</tr>
								</table>