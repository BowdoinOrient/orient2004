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
								<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td id="title">
												<?PHP echo VIEW_YOUR_THEMES_TEXT; ?>
											</td>
										</tr>
										<tr>
											<td>
												<table width="100%" cellpadding="0" cellspacing="1">
													<tr>
														<td id="col2">
															<?PHP echo NAME_TEXT; ?></td>
														<td id="col2">
															<?PHP echo VERSION_TEXT; ?></td>
														<td id="col2">
															<?PHP echo AUTHOR_TEXT; ?></td>
														<td id="col2">
															<?PHP echo MQA_VERSION_TEXT; ?></td>
														<td id="col2">
															<?PHP echo DESC_TEXT; ?></td>
													</tr>
<?PHP
		$lei = 0;
		$element_map = array("name", "author", "mqa_version", "description", "version");
		$all_theme = array();
		if($handle = opendir('themes/')){
			while(false !== ($file = readdir($handle))){
				if($file != "." && $file != "..") {
					if(file_exists('themes/'.$file.'/theme.xml')){
						$array = xml2array('themes/'.$file.'/theme.xml');
						if(is_array($array)){
							foreach($array[0]['elements'] as $element){
								if(in_array($element['name'], $element_map)){
									if($element['name'] == "name"){
										$all_theme[$lei][0] = $element['text'];
									} else if($element['name'] == "version"){
										$all_theme[$lei][1] = $element['text'];
									} else if($element['name'] == "author"){
										$all_theme[$lei][2] = $element['text'];
									} else if($element['name'] == "mqa_version"){
										$all_theme[$lei][3] = $element['text'];
									} else if($element['name'] == "description"){
										$all_theme[$lei][4] = $element['text'];
									}
									$all_theme[$lei]['file'] = $file;
								}
							}
						}
						
						$lei++;
					}
				}
			}
		}
		
		$row = 1;
		sort($all_theme);
		foreach($all_theme as $key=>$value){
			$name = (!empty($value[0]))?$value[0]:"Unknown";
			$version = (!empty($value[1]))?$value[1]:"Unknown";
			$author = (!empty($value[2]))?$value[2]:"Unknown";
			$mqa_version = (!empty($value[3]))?$value[3]:"Unknown";
			$desc = (!empty($value[4]))?$value[4]:"None";
?>
													<tr>
														<td id="row1_<?PHP echo $row; ?>" valign="top">
															<a href="actions.php?act=27&do=theme&theme=<?PHP echo urlencode($value['file']); ?>"><?PHP echo stringIt($name); ?></a>
														</td>
														<td id="row1_<?PHP echo $row; ?>" valign="top">
															<?PHP echo stringIt($version); ?>
														</td>
														<td id="row1_<?PHP echo $row; ?>" valign="top" style="white-space:normal;">
															<?PHP echo stringIt($author); ?>
														</td>
														<td id="row1_<?PHP echo $row; ?>" valign="top">
															<?PHP echo stringIt($mqa_version); ?>
														</td>
														<td id="row1_<?PHP echo $row; ?>" valign="top" style="white-space:normal;">
															<?PHP echo stringIt($desc); ?>
														</td>
													</tr>
<?PHP
			$row = ($row == 1)?2:1;
		}
?>
													<tr>
														<td id="row1_<?PHP echo $row;?>" colspan="5" align="right">
															<a href="http://mysqlquickadmin.com/themes.php">Get more themes</a>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>	