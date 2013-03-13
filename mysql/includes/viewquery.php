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
			
			$query = $_SESSION['prev_query'][$_SESSION['form_post']['query']]; ?>
								<table width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td id="title"><?PHP echo VIEW_QUERY_NUM_TEXT; ?> '<?PHP echo stringIt($_SESSION['form_post']['query']+1); ?>'</td>
									</tr>
									<tr>
										<td>
											<table width="100%" cellpadding="0" cellspacing="1">
												<tr>
													<td id="row1_1">
														<?PHP echo nl2br(stringIt($query)); ?>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>