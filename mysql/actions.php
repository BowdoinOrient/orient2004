<?PHP
require("includes/header.php");

switch($_GET['act']){
	case 1:		// LOGIN
		if(!empty($_POST['submit'])){

			$conntection = @mysql_connect($_POST['host'], $_POST['username'], $_POST['password']);

			if($conntection){
				$_SESSION['username'] = $_POST['username'];
				$_SESSION['password'] = $_POST['password'];
				$_SESSION['host'] = $_POST['host'];

				header("Location: main.php");
			} else {
				$_SESSION['mysql_error'] = @mysql_error();

				header("Location: login.php");
			}
		}
	break;
	case 2:		// LOGOUT
		session_destroy();

		header("Location: login.php");
	break;
	case 3:		// SELECT DATABASE
		$database = (!empty($_POST['database']))?$_POST['database']:$_GET['database'];

		if(!empty($database)){

			if($database == "Select a database..."){
				unset($_SESSION['database']);
				unset($_SESSION['table']);
				unset($_SESSION['show']);

				header("Location: main.php");
			} else {
				$conntection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
				$db = @mysql_select_db($database);

				if($db){
					$_SESSION['database'] = $database;
					unset($_SESSION['table']);
				} else {
					$_SESSION['mysql_error'] = @mysql_error();
				}

				unset($_SESSION['show']);
				unset($_SESSION['form_post']);

				header("Location: main.php");
			}
		}
	break;
	case 4:		// SELECT TABLE
		if(!empty($_GET['table'])){
			$conntection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
			$db = mysql_select_db($_SESSION['database']);

			$result = mysql_query("SHOW COLUMNS FROM `".$_GET['table']."`");

			if($result){
				$_SESSION['table'] = $_GET['table'];
				$_SESSION['show'] = "structure";
				unset($_SESSION['form_post']);
			} else {
				$_SESSION['mysql_error'] = @mysql_error();
			}

			header("Location: main.php");
		}
	break;
	case 5:		// SELECT VIEW
		$action = (!empty($_GET['do']))?strtolower($_GET['do']):strtolower($_POST['action']);
		if(!empty($action)){
			switch($action){
				case 'structure':		// TABLE STRUCTURE
					unset($_SESSION['form_post']);

					$_SESSION['show'] = $action;
				break;
				case 'backup':
					unset($_SESSION['form_post']);
					unset($_SESSION['table']);
					unset($_SESSION['backup_sql']);

					$_SESSION['show'] = $action;
				break;
				case 'backup_tables':
					unset($_SESSION['form_post']);

					if(!empty($_POST)) $_SESSION['form_post'] = $_POST;
					else unset($_SESSION['form_post']);

					if(!empty($_SESSION['form_post'])){
						$boxes = count($_SESSION['form_post']['rows']);
						if($boxes < 1){
							unset($_SESSION['form_post']);
						} else {
							$_SESSION['show'] = $action;
						}
					}
				break;
				case 'indexes':			// SHOW INDEXES
					unset($_SESSION['form_post']);

					$_SESSION['show'] = $action;
				break;
				case 'dropindex':		// DROP INDEXES
					unset($_SESSION['form_post']);

					if(!empty($_POST)) $_SESSION['form_post'] = $_POST;
					else unset($_SESSION['form_post']);

					if(!empty($_SESSION['form_post'])){
						$boxes = count($_SESSION['form_post']['index']);
						if($boxes < 1){
							unset($_SESSION['form_post']);
						} else {
							$_SESSION['show'] = $action;
						}
					}
				break;
				case 'browse':			// BROWSE TABLE
					if(!empty($_POST)) $_SESSION['form_post'] = $_POST;
					else unset($_SESSION['form_post']);
					
					unset($_SESSION['browse_query']);
					unset($_SESSION['search_q']);
					unset($_SESSION['ex_query_info']['start']);
					unset($_SESSION['ex_query_info']['limit']);
					unset($_SESSION['ex_query_info']['page']);
					unset($_SESSION['ex_query_info']['sort_by']);
					unset($_SESSION['ex_query_info']['sort_order']);

					$_SESSION['show'] = $action;
				break;
				case 'insert_row':		// INSERT FROM LINK
					$connection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
					$db = @mysql_select_db($_SESSION['database'],$connection);
				
					$check_table = mysql_query("SHOW TABLE STATUS LIKE '".mysql_escape_string($_GET['table'])."'");
					if(mysql_num_rows($check_table) > 0){
						unset($_SESSION['form_post']);
						$_SESSION['table'] = $_GET['table'];
						$_SESSION['show'] = "insert";
					}
				break;
				case 'addfield':		// ADD FIELD(S)
					unset($_SESSION['form_post']);

					if(!empty($_POST['add_where']) && !empty($_POST['numfields']) && is_numeric($_POST['numfields'])){
						$_SESSION['form_post'] = $_POST;
						$_SESSION['show'] = $action;
					} else {
						$_SESSION['show'] = "structure";
						unset($_SESSION['form_post']);
					}
				break;
				case 'dropfield':		// DROP FIELD(S)
					unset($_SESSION['form_post']);

					if(!empty($_POST)) $_SESSION['form_post'] = $_POST;
					else unset($_SESSION['form_post']);

					if(!empty($_SESSION['form_post'])){
						$boxes = count($_SESSION['form_post']['rows']);
						if($boxes < 1){
							unset($_SESSION['form_post']);
						} else {
							$_SESSION['show'] = $action;
						}
					}
				break;
				case 'changestructure':	// CHANGE TABLE STRUCTURE
					unset($_SESSION['form_post']);

					if(!empty($_POST)) $_SESSION['form_post'] = $_POST;
					else unset($_SESSION['form_post']);

					$_SESSION['show'] = $action;
				break;
				case 'make_primary':	// ADD PRIMARY
					if(count($_POST['rows']) > 0){
						$conntection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
						$db = mysql_select_db($_SESSION['database']);
						
						foreach($_POST['rows'] as $key=>$field){
							$fields .= ($key==0)?"`".$field."`":", `".$field."`";
						}
						
						$primary_query = "ALTER TABLE `".$_SESSION['table']."` DROP PRIMARY KEY, ADD PRIMARY KEY ( ".$fields." )";
						$result = mysql_query($primary_query);
						if(!$result){
							$_SESSION['mysql_error'] = mysql_error();		
						}
						$_SESSION['last_query'] = stringIt($primary_query);
					}
				break;
				case 'make_unique': 	// ADD UNIQUE
					if(count($_POST['rows']) > 0){	
						$conntection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
						$db = mysql_select_db($_SESSION['database']);
						
						foreach($_POST['rows'] as $key=>$field){
							$fields .= ($key==0)?"`".$field."`":", `".$field."`";
						}
						
						$primary_query = "ALTER TABLE `".$_SESSION['table']."` ADD UNIQUE ( ".$fields." )";
						$result = mysql_query($primary_query);
						
						if(!$result){
							$_SESSION['mysql_error'] = @mysql_error();
						}					
						$_SESSION['last_query'] = stringIt($primary_query);
					}
				break;
				case 'make_index':	// ADD INDEX
					if(count($_POST['rows']) > 0){
						$conntection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
						$db = mysql_select_db($_SESSION['database']);
						
						foreach($_POST['rows'] as $key=>$field){
							$fields .= ($key==0)?"`".$field."`":", `".$field."`";
						}
						
						$primary_query = "ALTER TABLE `".$_SESSION['table']."` ADD INDEX ( ".$fields." )";
						$result = mysql_query($primary_query);
						
						if(!$result){
							$_SESSION['mysql_error'] = @mysql_error();
						}					
						$_SESSION['last_query'] = stringIt($primary_query);
					}
				break;
				case 'make_fulltext':	// ADD FULLTEXT
					if(count($_POST['rows']) > 0){
						$conntection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
						$db = mysql_select_db($_SESSION['database']);
						
						foreach($_POST['rows'] as $key=>$field){
							$fields .= ($key==0)?"`".$field."`":", `".$field."`";
						}
						
						$primary_query = "ALTER TABLE `".$_SESSION['table']."` ADD FULLTEXT ( ".$fields." )";
						$result = mysql_query($primary_query);
						
						if(!$result){
							$_SESSION['mysql_error'] = @mysql_error();
						}					
						$_SESSION['last_query'] = stringIt($primary_query);
					}
				break;
				case 'viewrow':			// VIEW ROW(S)
					unset($_SESSION['form_post']);

					if(!empty($_POST)) $_SESSION['form_post'] = $_POST;
					else unset($_SESSION['form_post']);

					if(!empty($_SESSION['form_post'])){
						$boxes = count($_SESSION['form_post']['rows']);
						if($boxes < 1){
							unset($_SESSION['form_post']);
						} else {
							$_SESSION['show'] = $action;
						}
					}
				break;
				case 'insert':          // INSERT ROWS(S)
					unset($_SESSION['form_post']);

					if(!empty($_POST)) $_SESSION['form_post'] = $_POST;
					else unset($_SESSION['form_post']);

					$_SESSION['show'] = $action;
				break;
				case 'editrow':
					unset($_SESSION['form_post']);

					if(!empty($_POST)) $_SESSION['form_post'] = $_POST;
					else unset($_SESSION['form_post']);

					if(!empty($_SESSION['form_post'])){
						$boxes = count($_SESSION['form_post']['rows']);
						if($boxes < 1){
							unset($_SESSION['form_post']);
						} else {
							$_SESSION['show'] = $action;
						}
					}
				case 'droprow':           // DROP ROWS(S)
					unset($_SESSION['form_post']);

					if(!empty($_POST)) $_SESSION['form_post'] = $_POST;
					else unset($_SESSION['form_post']);

					if(!empty($_SESSION['form_post'])){
						$boxes = count($_SESSION['form_post']['rows']);
						if($boxes < 1){
							unset($_SESSION['form_post']);
						} else {
							$_SESSION['show'] = $action;
						}
					}
				break;
				case 'view_query':		// VIEW RAN QUERY
					unset($_SESSION['form_post']);
					
					$query = $_GET['query'];
					if(is_numeric($query)){
						$query = ceil($query);
						if($query >= 0 && $query <=4){
							$_SESSION['form_post']['query'] = $query;
							$_SESSION['show'] = $action;
						}
					}					
				break;
				case 'edit_query':
					unset($_SESSION['form_post']);
					
					$query = $_GET['query'];
					if(is_numeric($query)){
						$query = ceil($query);
						if($query >= 0 && $query <=4){
							$_SESSION['form_post']['query'] = $query;
							$_SESSION['show'] = $action;
						}
					}		
				break;
				case 'search':		// SEARCH
					unset($_SESSION['form_post']);
					
					if(!empty($_POST)) $_SESSION['form_post'] = $_POST;
					else unset($_SESSION['form_post']);
					
					$_SESSION['show'] = $action;
				break;		
				case 'makehtml':
					unset($_SESSION['form_post']);
					
					if(!empty($_POST)) $_SESSION['form_post'] = $_POST;
					else unset($_SESSION['form_post']);
					
					if(count($_POST['rows']) > 0){
						$_SESSION['show'] = $action;
					}
				break;				
				case 'emptytables':		// EMPTY TABLES
					unset($_SESSION['form_post']);
	
					if(count($_POST['rows']) > 0){
						if(!empty($_POST)) $_SESSION['form_post'] = $_POST;
						else unset($_SESSION['form_post']);
	
						$_SESSION['show'] = $action;
					}
				break;
				case 'droptables':		// DROP TABLES
					unset($_SESSION['form_post']);

					if(count($_POST['rows']) > 0){	
						if(!empty($_POST)) $_SESSION['form_post'] = $_POST;
						else unset($_SESSION['form_post']);
	
						$_SESSION['show'] = $action;
					} else if(!empty($_GET['table'])){
						unset($_SESSION['table']);
						$_SESSION['form_post']['rows'][0] = $_GET['table'];
						$_SESSION['show'] = $action;
					}
				break;
				case 'addtable':		// ADD TABLES
						unset($_SESSION['form_post']);
						$conntection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
						$db = mysql_select_db($_SESSION['database']);
						
						if($_POST['name']){
							$query = "SHOW TABLE STATUS LIKE '".mysql_escape_string($_POST['name'])."'";
							$result = @mysql_query($query);
							if(mysql_num_rows($result) == 0){
								if(!empty($_POST['name']) && !empty($_POST['numfields']) && is_numeric($_POST['numfields'])){
									$_SESSION['form_post'] = $_POST;
									$_SESSION['show'] = $action;
								}
							} else {
								$_SESSION['last_query'] = "CREATE TABLE `".stringIt($_POST['name'])."` (<br><br>)";
								$_SESSION['mysql_error'] = CREATE_TABLE_ERROR_TEXT_1." '".$_POST['name']."' ".CREATE_TABLE_ERROR_TEXT_2;
							}
						}
				break;
				case 'optimize':		// OPTIMIZE TABLES

					if(!empty($_POST)) $_SESSION['form_post'] = $_POST;
					else unset($_SESSION['form_post']);

					if(count($_POST['rows']) > 0){
						$connection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
						$db = @mysql_select_db($_SESSION['database'],$connection);
	
						$query_string = "OPTIMIZE TABLE ";
	
						$count = 0;
	
						foreach($_POST['rows'] as $key=>$value){
							$count++;
							$query_string .= ($count === 1)?"`".$value."`":", `".$value."`";
						}
						
						$query = @mysql_query($query_string);
						$_SESSION['last_query'] = stringIt($query_string);
	
						if(!$query){
							$_SESSION['mysql_error'] = mysql_error();
						} else {
							unset($_SESSION['form_post']);
						}
					} else if($_GET['all'] == "true"){
						$connection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
						$db = @mysql_select_db($_SESSION['database'],$connection);
						
						$get_all = mysql_query("SHOW TABLE STATUS FROM `".$_SESSION['database']."`");
						$count = 0;
						while($row = mysql_fetch_assoc($get_all)){
							$ops .= ($count == 0)?"`".$row['Name']."`":", `".$row['Name']."`";
							$count++;
						}
						
						$final = "OPTIMIZE TABLE ".$ops;
						$result = mysql_query($final);
						$_SESSION['last_query'] = stringIt($final);
						if(!$result){
							$_SESSION['mysql_error'] = @mysql_error();
						}
					}
				break;
				case 'query':		// QUERY
					unset($_SESSION['table']);

					$_SESSION['show'] = $action;
				break;
				case 'variables':	// VIEW SYSTEM VARIABLES
					unset($_SESSION['table']);

					$_SESSION['show'] = $action;
				break;
				case 'show_updates':	// SHOW TABLES
					unset($_SESSION['table']);
					unset($_SESSION['form_post']);
					
					$_SESSION['show'] = $action;
				break;
				case 'themes':		// LIST THEMES
					$_SESSION['show'] = $action;
					unset($_SESSION['table']);
				break;
				case 'languages':
					$_SESSION['show'] = $action;
					unset($_SESSION['table']);
				break;
				case 'dropdb':
					if(count($_POST['rows']) > 0){
						unset($_SESSION['form_post']);
						$_SESSION['form_post']['rows'][0] = $_POST['rows'][0];
						$_SESSION['show'] = $action;
					}
				break;
				case 'adddb':
					if(!empty($_POST['name'])){
						$db = $_POST['name'];
						$quer = mysql_query("CREATE DATABASE `".mysql_escape_string($db)."`");
						$_SESSION['last_query'] = "CREATE DATABASE `".htmlspecialchars($db)."`";
						if(!$quer){
							$_SESSION['mysql_error'] = mysql_error();
						}
					}
					header("Location: main.php");
				break;
				case 'show_dibs':	// VIEW DBS
					unset($_SESSION['show']);
				break;
				case 'download_software':
					$downloading = true;
				break;
			}
		}
		
		$connection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
		$db = @mysql_select_db($_SESSION['database'],$connection);
		
		$check_table = mysql_query("SHOW TABLE STATUS LIKE '".mysql_escape_string($_SESSION['table'])."'");
		if(mysql_num_rows($check_table) < 1){
			unset($_SESSION['table']);
		}
		
		unset($_SESSION['make_html_text']);
		
		if($downloading == true){
			header("Location: http://mysqlquickadmin.com/download.php");
		} else {
			header("Location: main.php");
		}
	break;
	case 6:		// CHANGE STRUCTURE

		$connection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
		$db = @mysql_select_db($_SESSION['database'],$connection);

		$query_string = "ALTER TABLE `".$_SESSION['table']."` ";
		$last_query_string = "ALTER TABLE `".stringIt($_SESSION['table'])."` ";

		$all_fields = @mysql_query("SELECT * FROM `".$_SESSION['table']."`");
		$check_drop_primary = mysql_query("ALTER TABLE `".$_SESSION['table']."` DROP PRIMARY KEY");
		
		if(count($_POST['col_primary']) > 0){
			$we_have = 1;
			$check_old_pri = mysql_query("SHOW INDEX FROM `".mysql_escape_string($_SESSION['table'])."`");
			while($i_row = mysql_fetch_assoc($check_old_pri)){
				if($i_row['Key_name'] == "PRIMARY" || $i_row['Comment'] == "PRIMARY"){
					$drop_pri_bool = true;
				}
			}
			$drop_primary = ($drop_pri_bool == true)?", DROP PRIMARY KEY ":NULL;
			$start_primary = ", ADD PRIMARY KEY ( ";
		}

		foreach($_POST['old_col_name'] as $key=>$value){
			$_POST['col_name'][$key] = str_replace("`", "", $_POST['col_name'][$key]);
			$type = (!empty($_POST['col_value'][$key]))?strtoupper($_POST['col_type'][$key])."(".stripslashes($_POST['col_value'][$key]).")":strtoupper($_POST['col_type'][$key]);
			$null = ($_POST['col_null'][$key] == 1)?"NULL":"NOT NULL";
			$extra = (!empty($_POST['col_extra'][$key]))?" ".strtoupper($_POST['col_extra'][$key]):NULL;
			$default = ($extra != "AUTO_INCREMENT")?" DEFAULT '".mysql_escape_string($_POST['col_default'][$key])."'":NULL;
			if(count($_POST['col_primary']) > 0){
				$we_need = count($_POST['col_primary']);
				if(in_array($value,$_POST['col_primary'])){
					$add_primaries .= ($we_need == $we_have)?"`".$_POST['col_name'][$key]."`":"`".$_POST['col_name'][$key]."`, ";
					$last_add_primaries .= ($we_need == $we_have)?"`".stringIt($_POST['col_name'][$key])."`":"`".stringIt($_POST['col_name'][$key])."`, ";
					$we_have++;
				}
			}

			$query_string .= ($key === 0)?"CHANGE `".$value."` `".$_POST['col_name'][$key]."` ".$type." ".$null.$default.$extra." ":", CHANGE `".$value."` `".$_POST['col_name'][$key]."` ".$type." ".$null.$default.$extra." ";
			$last_query_string .= ($key === 0)?"CHANGE `".stringIt($value)."` `".stringIt($_POST['col_name'][$key])."` ".stringIt($type)." ".stringIt($null).stringIt($default).stringIt($extra)." ":",<br> CHANGE `".stringIt($value)."` `".stringIt($_POST['col_name'][$key])."` ".stringIt($type)." ".stringIt($null).stringIt($default).stringIt($extra)." ";
		}

		$query_string .= (count($_POST['col_primary']) > 0)?$drop_primary.$start_primary.$add_primaries." )":NULL;
		$last_query_string .= (count($_POST['col_primary']) > 0)?$drop_primary.$start_primary.$last_add_primaries." )":NULL;
		$query_string = $query_string;
		$query = @mysql_query($query_string);
		$_SESSION['last_query'] = $last_query_string;

		if(!$query){
			$_SESSION['mysql_error'] = mysql_error();
			$_SESSION['form_post'] = $_POST;
		} else {
			$_SESSION['show'] = "structure";
			unset($_SESSION['form_post']);
		}

		header("Location: main.php");
	break;
	case 7:		// EMPTY TABLES
		if($_POST["confirm"] == "yes"){
			$connection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
			$db = @mysql_select_db($_SESSION['database'],$connection);

			foreach($_SESSION['form_post']['rows'] as $key=>$value){
				$query_string = "TRUNCATE `".$value."`";
				$result = @mysql_query($query_string);
				$last_query_string .= (empty($last_query_string))?"TRUNCATE `".stringIt($value)."`;":"<br>TRUNCATE `".stringIt($value)."`;";
				if($_POST["optimize_on"] == "yes"){
					$optimize = mysql_query("OPTIMIZE TABLE `".$value."`");
				}
			}

			if(!$result){
				$_SESSION['mysql_error'] = @mysql_error();
			}

			$_SESSION['last_query'] = $last_query_string;
		}
		$_SESSION['show'] = "structure";

		header("Location: main.php");
	break;
	case 8:		// DROP TABLES
		if($_POST['confirm'] == "yes"){
			$connection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
			$db = @mysql_select_db($_SESSION['database'],$connection);

			$query_string = "DROP TABLE ";

			$i = 0;

			foreach($_SESSION['form_post']['rows'] as $key=>$value){
				$query_string .= ($i === 0)?"`".$value."`":", `".$value."`";

				$i++;
			}

			$result = @mysql_query($query_string);

			if(!$result){
				$_SESSION['mysql_error'] = @mysql_error();
			}

			$_SESSION['last_query'] = stringIt($query_string);
		}
		$_SESSION['show'] = "structure";

		header("Location: main.php");
	break;
	case 9:		// ADD TABLE - ADD ROW
		if(!empty($_POST['submit']) && is_numeric($_POST['numfields'])){
			$_SESSION['form_post']['numfields'] = $_SESSION['form_post']['numfields'] + $_POST['numfields'];
		}
		header("Location: main.php");
	break;
	case 10:		// ADD TABLE
		unset($_SESSION['form_post']);

		$connection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
		$db = @mysql_select_db($_SESSION['database'],$connection);

		$_POST['name'] = str_replace("`", "", $_POST['name']);
		$query_string = "CREATE TABLE `".$_POST['name']."` (";
		$last_query_string = "CREATE TABLE `".stringIt($_POST['name'])."` (<br>";

		$comment = (!empty($_POST['comment']))?" COMMENT='".mysql_escape_string($_POST['comment'])."'":NULL;
		$storage = $_POST['storage'];

		foreach($_POST['col_name'] as $key=>$value){
			if(!empty($value)){
				$value = str_replace("`", "", $value);
				$type = (!empty($_POST['col_value'][$key]))?strtoupper($_POST['col_type'][$key])."(".stripslashes($_POST['col_value'][$key]).")":strtoupper($_POST['col_type'][$key]);
				$null = ($_POST['col_null'][$key] == 1)?"NULL":"NOT NULL";
				$extra = (!empty($_POST['col_extra'][$key]))?" ".strtoupper($_POST['col_extra'][$key]):NULL;
				$default = (!empty($_POST['col_default'][$key]))?" DEFAULT '".mysql_escape_string($_POST['col_default'][$key])."'":NULL;
				if($_POST['col_other'][$key] == "primary"){
					$primaries[] = "`".$_POST['col_name'][$key]."`";
				}
				if($_POST['col_other'][$key] == "unique"){
					$uniques[] = "`".$_POST['col_name'][$key]."`";
				}
				if($_POST['col_other'][$key] == "index"){
					$indexes[] = "`".$_POST['col_name'][$key]."`";
				}
				if($_POST['ft'.$key] == "true"){
					$fulltexts[] = "`".$_POST['col_name'][$key]."`";
				}

				$query_string .= ($key === 0)?"`".$value."` ".$type." ".$null.$default.$extra." ":", `".$value."` ".$type." ".$null.$default.$extra." ";
				$last_query_string .= ($key === 0)?"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`".stringIt($value)."` ".stringIt($type)." ".stringIt($null).stringIt($default).stringIt($extra)." ":",<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`".stringIt($value)."` ".stringIt($type)." ".stringIt($null).stringIt($default).stringIt($extra)." ";
			}
		}
		if(count($primaries) > 0){
			$primaries = implode(",", $primaries);
			$query_string .= ", PRIMARY KEY ( ".$primaries." )";
			$last_query_string .= ", <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRIMARY KEY ( ".stringIt($primaries)." )";
		}

		$query_string .= ") TYPE = ".$storage."". $comment ." ;";
		$last_query_string .= "<br>) TYPE = ".stringIt($storage)." ". stringIt($comment) .";";

		$num_uniques = count($uniques);
		$num_indexes = count($indexes);
		$num_fulltexts = count($fulltexts);
		$total_indexes = $num_uniques + $num_indexes + $num_fulltexts;
		if($total_indexes > 0){
			if($num_uniques > 0){
				for($i=0;$i<$num_uniques;$i++){
					$we_want = $num_uniques - 1;
					if($i == $we_want){
						$unique_query = $unique_query.$uniques[$i];
					} else {
						$unique_query = $unique_query.$uniques[$i].", ";
					}
				}
				$unique_query = "ADD UNIQUE ( ".$unique_query." )";
				$queries[] = $unique_query;
			}
			if($num_indexes > 0){
				for($i=0;$i<$num_indexes;$i++){
					$we_want = $num_indexes - 1;
					if($i == $we_want){
						$index_query = $index_query.$indexes[$i];
					} else {
						$index_query = $index_query.$indexes[$i].", ";
					}
				}
				$index_query = "ADD INDEX ( ".$index_query." )";
				$queries[] = $index_query;
			}
			if($num_fulltexts > 0){
				for($i=0;$i<$num_fulltexts;$i++){
					$we_want = $num_fulltexts - 1;
					if($i == $we_want){
						$ft_query = $ft_query.$fulltexts[$i];
					} else {
						$ft_query = $ft_query.$fulltexts[$i].", ";
					}
				}
				$ft_query = "ADD FULLTEXT ( ".$ft_query." )";
				$queries[] = $ft_query;
			}

			$query_num = count($queries);
			for($i=0;$i<$query_num;$i++){
				$we_want = $query_num - 1;
				if($i == $we_want){
					$final_index_query = $final_index_query.$queries[$i];
				} else {
					$final_index_query = $final_index_query.$queries[$i].", ";
				}
			}

			$completed_index_query = "ALTER TABLE `".$_POST['name']."` ".$final_index_query;
		}

		$query = @mysql_query($query_string);
		$last_query_string .= (!empty($completed_index_query))?"<p>".stringIt($completed_index_query):NULL;
		$_SESSION['last_query'] = stripslashes($last_query_string);

		if(!$query){
			$_SESSION['mysql_error'] = mysql_error();

			$_SESSION['form_post'] = (!empty($_POST))?$_POST:NULL;
		} else {
			if(!empty($completed_index_query)){
				$second_query = @mysql_query($completed_index_query);
				if(!$second_query){
					$_SESSION['mysql_error'] = @mysql_error();
				}
			}

			unset($_SESSION['show']);
			$_SESSION['table'] = $_POST['name'];
		}

		header("Location: main.php");
	break;
	case 11:		// PROCESS QUERY RUN
		if(isset($_GET['query'])){
			$_POST['query'] = $_SESSION['prev_query'][$_GET['query']];
		}
		if(!empty($_POST['query'])){
			if(substr_count($_POST['query'],";") > 1){
				$connection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
				$db = @mysql_select_db($_SESSION['database'],$connection);
				$batch_query = explode("\r\n",$_POST['query']);

				$query = "";

				$connect = @mysql_connect($db_host,$db_user,$db_pass);
				$db = mysql_select_db($db_name,$connect);

				foreach($batch_query as $sql_line) {
					$tsl = trim($sql_line);

					if (($tsl != "") && (substr($tsl, 0, 2) != "--") && (substr($tsl, 0, 1) != "#")) {
						$query .= $sql_line;
						if(preg_match("/;\s*$/", $sql_line)) {
							$result = @mysql_query($query);
							if(!$result){
								$_SESSION['mysql_error'] = mysql_error();
								$dont_array = true;
							}
								$query = "";
						}
					}

					$last_query = $last_query.$sql_line."\r\n";
				}
					$_SESSION['last_query'] = $last_query;
			} else {
				$runat_query = stripslashes($_POST['query']);
				$_SESSION['last_query'] = $runat_query;
				$connection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
				$db = @mysql_select_db($_SESSION['database'],$connection);
				if(!@mysql_query($runat_query)){
					$_SESSION['mysql_error'] = @mysql_error();
					$dont_array = true;
				} else {
					if(preg_match("#(select) (.*?) (from) (.*?)#isU", $runat_query)){
						$runat_query = str_replace("`", "", $runat_query);
						preg_match("#(select) (.*?) (from) (.*?)#isU", $runat_query, $matches);
						$matchess = explode(" ", $matches[4]);
						$matchess[0] = explode(",", $matchess[0]);
						$matchess[0] = $matchess[0][0];
						$_SESSION['table'] = $matchess[0];
						$_SESSION['show'] = "browse";
						$_SESSION['browse_query'] = $_POST['query'];
					}
				}
			}
			if($_POST['query'] != $_SESSION['prev_query'][0] && is_null($_GET['query'])){
				if($dont_array != true){
					$_SESSION['prev_query'][4] = $_SESSION['prev_query'][3];
					$_SESSION['prev_query'][3] = $_SESSION['prev_query'][2];
					$_SESSION['prev_query'][2] = $_SESSION['prev_query'][1];
					$_SESSION['prev_query'][1] = $_SESSION['prev_query'][0];
					$_SESSION['prev_query'][0] = $_POST['query'];
				}
			}
		} else {
			$_SESSION['mysql_error'] = RUN_QUERY_ERROR_TEXT;
		}

		if(is_null($_GET['query'])) $_SESSION['query_line'] = trim($_POST['query']);

		header("Location: main.php");
	break;
	case 12:		// INSERT A ROW	
		$connection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
		$db = @mysql_select_db($_SESSION['database'],$connection);

		$get_cols = "SHOW COLUMNS FROM `".$_SESSION['table']."`";
		$result = @mysql_query($get_cols);

		if(mysql_num_rows($result) > 0){
			$simple_array = array("varchar", "tinyint", "text", "smallint", "mediumint", "int", "bigint", "float", "double", "decimal", "year", "char", "tinyblob", "blob", "mediumblob", "longblob", "tinytext", "mediumtext", "longtext", "bool", "enum");
			$insert_cols = "";
			$insert_values = "";
			$number_of_fields = mysql_num_rows($result);
			$i = 0;

			while($row = mysql_fetch_assoc($result)){
				$type_length = strlen($row['Type']);
				$bracket_start = strpos($row['Type'],'(');
				if($bracket_start !== false){
					$bracket_end = $type_length - $bracket_start - 2;
					$row['Value'] = substr($row['Type'], ($bracket_start + 1), ($bracket_end));
					$row['Type'] = substr($row['Type'], 0, ($bracket_start));
				} else {
					$row['Value'] = NULL;
				}
				if(in_array($row['Type'], $simple_array)){
					$i++;
					$value_to_insert = $_POST[stringItvTwo($row["Field"])];
					if(isset($_POST[stringItvTwo($row["Field"])."_function"])){
						$function = $_POST[stringItvTwo($row["Field"])."_function"];
						$value_to_insert = ($function == "char")?chr($value_to_insert):$value_to_insert;
						$value_to_insert = ($function == "crypt")?crypt($value_to_insert):$value_to_insert;
						$value_to_insert = ($function == "htmlentities")?htmlentities($value_to_insert):$value_to_insert;
						$value_to_insert = ($function == "entity_decode")?html_entity_decode($value_to_insert):$value_to_insert;
						$value_to_insert = ($function == "htmlspecialchars")?htmlspecialchars($value_to_insert):$value_to_insert;
						$value_to_insert = ($function == "spchars_decode")?stringIt_decode($value_to_insert):$value_to_insert;
						$value_to_insert = ($function == "md5")?md5($value_to_insert):$value_to_insert;
						$value_to_insert = ($function == "money_format")?money_format($value_to_insert):$value_to_insert;
						$value_to_insert = ($function == "rand")?rand():$value_to_insert;
						$value_to_insert = ($function == "stripslashes")?stripslashes($value_to_insert):$value_to_insert;
						$value_to_insert = ($function == "strtolower")?strtolower($value_to_insert):$value_to_insert;
						$value_to_insert = ($function == "strtoupper")?strtoupper($value_to_insert):$value_to_insert;
						$value_to_insert = ($function == "trim")?trim($value_to_insert):$value_to_insert;
						if($function == "date"){
							$value_to_insert = str_replace("'", "", $value_to_insert);
							$value_to_insert = str_replace('"', "", $value_to_insert);
							$value_to_insert = (!empty($value_to_insert))?date($value_to_insert):date("F j, Y, g:i a");
						}
						$value_to_insert = ($function == "time")?time():$value_to_insert;
					}
					$values_to_insert_for_last = $value_to_insert;
					if($row['Type'] != "enum"){
						$value_to_insert = mysql_escape_string($value_to_insert);
					}			
					if($i == $number_of_fields){
						$insert_cols = $insert_cols."`".$row["Field"]."`";						
						$insert_values = $insert_values."'".$value_to_insert."'";
						$insert_values_2 = $insert_values_2."'".$values_to_insert_for_last."'";
					} else {
						$insert_cols = $insert_cols."`".$row["Field"]."`,";
						$insert_values = $insert_values."'".$value_to_insert."',";
						$insert_values_2 = $insert_values_2."'".$values_to_insert_for_last."',";
					}
				} else if($row['Type'] == "timestamp"){
					$i++;
					if($_POST[stringItvTwo($row["Field"])."_function"] != "now"){
						$values_to_insert = $_POST[stringItvTwo($row["Field"])];
						if($i == $number_of_fields){
							$insert_cols = $insert_cols."`".$row["Field"]."`";
							$insert_values = $insert_values."'".mysql_escape_string($values_to_insert)."'";
							$insert_values_2 = $insert_values_2."'".$values_to_insert."'";
						} else {
							$insert_cols = $insert_cols."`".$row["Field"]."`,";
							$insert_values = $insert_values."'".mysql_escape_string($values_to_insert)."',";
							$insert_values_2 = $insert_values_2."'".$values_to_insert."',";
						}
					} else {
						if($i == $number_of_fields){
							$insert_cols = $insert_cols."`".$row["Field"]."`";
							$insert_values = $insert_values."now()";
							$insert_values_2 = $insert_values_2."now()";
						} else {
							$insert_cols = $insert_cols."`".$row["Field"]."`,";
							$insert_values = $insert_values."now(),";
							$insert_values_2 = $insert_values_2."now(),";
						}
					}
				} else if($row['Type'] == "date"){
					$i++;
					if($_POST[stringItvTwo($row["Field"])."_function"] != "now"){
						$values_to_insert = $_POST[stringItvTwo($row["Field"])];
						$act_value = mysql_escape_string($values_to_insert[0])."-".mysql_escape_string($values_to_insert[1])."-".mysql_escape_string($values_to_insert[2]);
						$values_to_insert_for_last = $values_to_insert[0]."-".$values_to_insert[1]."-".$values_to_insert[2];
						if($i == $number_of_fields){
							$insert_cols = $insert_cols."`".$row["Field"]."`";
							$insert_values = $insert_values."'".$act_value."'";
							$insert_values_2 = $insert_values_2."'".$values_to_insert_for_last."'";
						} else {
							$insert_cols = $insert_cols."`".$row["Field"]."`,";
							$insert_values = $insert_values."'".$act_value."',";
							$insert_values_2 = $insert_values_2."'".$values_to_insert_for_last."',";
						}
					} else {
						$act_value = "now()";
						$values_to_insert_for_last = "now()";
						if($i == $number_of_fields){
							$insert_cols = $insert_cols."`".$row["Field"]."`";
							$insert_values = $insert_values."".$act_value."";
							$insert_values_2 = $insert_values_2."".$values_to_insert_for_last."";
						} else {
							$insert_cols = $insert_cols."`".$row["Field"]."`,";
							$insert_values = $insert_values."".$act_value.",";
							$insert_values_2 = $insert_values_2."".$values_to_insert_for_last.",";
						}
					}	
				} else if($row['Type'] == "datetime"){
					$i++;
					if($_POST[stringItvTwo($row["Field"])."_function"] != "now"){
						$values_to_insert = $_POST[stringItvTwo($row["Field"])];
						$act_value = $values_to_insert[0]."-".$values_to_insert[1]."-".$values_to_insert[2]." ".$values_to_insert[3].":".$values_to_insert[4].":".$values_to_insert[5];
						if($i == $number_of_fields){
							$insert_cols = $insert_cols."`".$row["Field"]."`";
							$insert_values = $insert_values."'".mysql_escape_string($act_value)."'";
							$insert_values_2 = $insert_values_2."'".$act_value."'";
						} else {
							$insert_cols = $insert_cols."`".$row["Field"]."`,";
							$insert_values = $insert_values."'".mysql_escape_string($act_value)."',";
							$insert_values_2 = $insert_values_2."'".$act_value."',";
						}
					} else {
						$act_value = "now()";
						$values_to_insert_for_last = "now()";
						if($i == $number_of_fields){
							$insert_cols = $insert_cols."`".$row["Field"]."`";
							$insert_values = $insert_values."".$act_value."";
							$insert_values_2 = $insert_values_2."".$values_to_insert_for_last."";
						} else {
							$insert_cols = $insert_cols."`".$row["Field"]."`,";
							$insert_values = $insert_values."".$act_value.",";
							$insert_values_2 = $insert_values_2."".$values_to_insert_for_last.",";
						}
					}
				} else if($row['Type'] == "time"){
					$i++;
					if($_POST[stringItvTwo($row["Field"])."_function"] != "now"){
						$values_to_insert = $_POST[stringItvTwo($row["Field"])];
						$act_value = $values_to_insert[0].":".$values_to_insert[1].":".$values_to_insert[2];
						if($i == $number_of_fields){
							$insert_cols = $insert_cols."`".$row["Field"]."`";
							$insert_values = $insert_values."'".mysql_escape_string($act_value)."'";
							$insert_values_2 = $insert_values_2."'".$act_value."'";
						} else {
							$insert_cols = $insert_cols."`".$row["Field"]."`,";
							$insert_values = $insert_values."'".mysql_escape_string($act_value)."',";
							$insert_values_2 = $insert_values_2."'".$act_value."',";
						}
					} else {
						$act_value = "now()";
						$values_to_insert_for_last = "now()";
						if($i == $number_of_fields){
							$insert_cols = $insert_cols."`".$row["Field"]."`";
							$insert_values = $insert_values."".$act_value."";
							$insert_values_2 = $insert_values_2."".$values_to_insert_for_last."";
						} else {
							$insert_cols = $insert_cols."`".$row["Field"]."`,";
							$insert_values = $insert_values."".$act_value.",";
							$insert_values_2 = $insert_values_2."".$values_to_insert_for_last.",";
						}
					}
				} else if($row['Type'] == "set"){
					$i++;
					$values_to_insert = $_POST[stringItvTwo($row["Field"])];
					$act_value = "";
					foreach($values_to_insert as $key=>$value){
						$num = count($values_to_insert) - 1;
						if($key == $num){
							$act_value = $act_value.$value;
						} else {
							$act_value = $act_value.$value.",";
						}
					}

					if($i == $number_of_fields){
						$insert_cols = $insert_cols."`".$row["Field"]."`";
						$insert_values = $insert_values."'".$act_value."'";
						$insert_values_2 = $insert_values_2."'".$act_value."'";
					} else {
						$insert_cols = $insert_cols."`".$row["Field"]."`,";
						$insert_values = $insert_values."'".$act_value."',";
						$insert_values_2 = $insert_values_2."'".$act_value."',";
					}
				}
			}

			$insert_query = "INSERT INTO `".$_SESSION['table']."` (".$insert_cols.") VALUES (".$insert_values.")";
			if($dont_do != true){
				$new_result = @mysql_query($insert_query);
			}
			if(!$new_result){
				$_SESSION['mysql_error'] = @mysql_error();
				$_SESSION['form_post'] = $_POST;
			} else {
				unset($_SESSION['form_post']);
			}
			$_SESSION['last_query'] = "INSERT INTO `".stringIt($_SESSION['table'])."` (".stringIt($insert_cols).") VALUES (".nl2br(stringIt($insert_values_2)).")";
		} else {
			$_SESSION['show'] = 'failure';
		}

		header("Location: main.php");
	break;
	case 13:		// DROP ROW(S)
		$connection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
		$db = @mysql_select_db($_SESSION['database'],$connection);

		if($_POST['confirm'] == "yes"){
			$drop_queries = $_POST['drop_query'];
			foreach($drop_queries as $key=>$value){
				$drop_q = mysql_query($value);
				if(count($drop_queries) == 1){
					$_SESSION['last_edit_query'] = $_POST['drop_query_2'][$key];
				} else {
					if((count($drop_queries) - 1) == $key){
						$_SESSION['last_edit_query'] .= $_POST['drop_query_2'][$key];
					} else {
						$_SESSION['last_edit_query'] .= $_POST['drop_query_2'][$key].",<br />";
					}
				}
				if(!$drop_q){
					$_SESSION['mysql_error'] = @mysql_error();
				}
			}
			if(empty($_SESSION['mysql_error']) && $_POST['optimize_on'] == "yes"){
				$optimize = mysql_query("OPTIMIZE TABLE `".$_SESSION['table']."`");
			}
		}

		$_SESSION['show'] = 'browse';
		unset($_SESSION['form_post']);

		header("Location: main.php");
	break;
	case 14:		// EDIT ROW(S)
		$connection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
		$db = @mysql_select_db($_SESSION['database'],$connection);

		if(!empty($_POST['submit'])){
			$_SESSION['form_post'] = $_POST;
			$this_tab_q = "SHOW COLUMNS FROM `".$_SESSION['table']."`";
			$this_result = mysql_query($this_tab_q);
			$num_fields = mysql_num_rows($this_result);
			while($row = mysql_fetch_assoc($this_result)){
				$type_length = strlen($row["Type"]);
				$bracket_start = strpos($row["Type"],'(');
				if($bracket_start !== false){
					$bracket_end = $type_length - $bracket_start - 2;
					$row["Value"] = substr($row["Type"], ($bracket_start + 1), ($bracket_end));
					$row["Type"] = substr($row["Type"], 0, ($bracket_start));
				} else {
					$row["Value"] = NULL;
				}

				$field_name[] = $row["Field"];
				$field_type[] = $row["Type"];
				$field_value[] = $row["Value"];
			}
			$i = 0;
			foreach($_POST['rows'] as $key=>$keynum){
				$old_explode = $_POST['old_values'][$keynum];
				for($r=0;$r<$num_fields;$r++){
					$num_we_want = $num_fields - 1;
					$for_html_name = stringItvTwo($field_name[$r]);
					$field_new_array = $_POST[$for_html_name];
					$simple_array = array("varchar", "tinyint", "text", "smallint", "mediumint", "int", "bigint", "float", "double", "decimal", "year", "char", "tinyblob", "blob", "mediumblob", "longblob", "tinytext", "mediumtext", "longtext", "bool", "enum");
					if(in_array($field_type[$r], $simple_array)){
						$functions = $_POST[stringItvTwo($field_name[$r])."_function"];
						if($functions[$i]){
							$function = $functions[$i];
							$field_new_array[$i] = ($function == "char")?chr($field_new_array[$i]):$field_new_array[$i];
							$field_new_array[$i] = ($function == "crypt")?crypt($field_new_array[$i]):$field_new_array[$i];
							$field_new_array[$i] = ($function == "htmlspecialchars")?htmlspecialchars($field_new_array[$i]):$field_new_array[$i];
							$field_new_array[$i] = ($function == "htmlentities")?htmlentities($field_new_array[$i]):$field_new_array[$i];
							$field_new_array[$i] = ($function == "entity_decode")?html_entity_decode($field_new_array[$i]):$field_new_array[$i];
							$field_new_array[$i] = ($function == "spchars_decode")?stringIt_decode($field_new_array[$i]):$field_new_array[$i];
							$field_new_array[$i] = ($function == "md5")?md5($field_new_array[$i]):$field_new_array[$i];
							$field_new_array[$i] = ($function == "money_format")?money_format($field_new_array[$i]):$field_new_array[$i];
							$field_new_array[$i] = ($function == "rand")?rand():$field_new_array[$i];
							$field_new_array[$i] = ($function == "stripslashes")?stripslashes($field_new_array[$i]):$field_new_array[$i];
							$field_new_array[$i] = ($function == "strtolower")?strtolower($field_new_array[$i]):$field_new_array[$i];
							$field_new_array[$i] = ($function == "strtoupper")?strtoupper($field_new_array[$i]):$field_new_array[$i];
							$field_new_array[$i] = ($function == "trim")?trim($field_new_array[$i]):$field_new_array[$i];
							$field_new_array[$i] = ($function == "time")?time():$field_new_array[$i];
							if($function == "date"){
								$date_value = $field_new_array[$i];
								$date_value = str_replace("'", "", $date_value);
								$date_value = str_replace('"', "", $date_value);
								$field_new_array[$i] = (!empty($field_new_array[$i]))?date($date_value):date("F j, Y, g:i a");
							}
						}
						if($r != $num_we_want){
							$set_queries = $set_queries."`".$field_name[$r]."` = '".mysql_escape_string($field_new_array[$i])."', ";
							$set_last = $set_last."`".stringIt($field_name[$r])."` = '".nl2br(stringIt($field_new_array[$i]))."', ";
							$where_last = $where_last."`".stringIt($field_name[$r])."` = '".nl2br(stringIt($old_explode[$r]))."' AND ";
							$where_queries = $where_queries."`".$field_name[$r]."` = '".mysql_escape_string($old_explode[$r])."' AND ";
						} else {
							$set_queries = $set_queries."`".$field_name[$r]."` = '".mysql_escape_string($field_new_array[$i])."'";
							$set_last = $set_last."`".stringIt($field_name[$r])."` = '".nl2br(stringIt($field_new_array[$i]))."'";
							$where_last = $where_last."`".stringIt($field_name[$r])."` = '".nl2br(stringIt($old_explode[$r]))."'";
							$where_queries = $where_queries."`".$field_name[$r]."` = '".mysql_escape_string($old_explode[$r])."'";
						}
					} else if($field_type[$r] == "timestamp"){
						$functions = $_POST[stringItvTwo($field_name[$r])."_function"];
						$function = $functions[$i];
						if($function != "now"){
							$date_toput = $field_new_array[$i];
							if($r != $num_we_want){
								$set_queries = $set_queries."`".$field_name[$r]."` = '".mysql_escape_string($date_toput)."', ";
								$set_last = $set_last."`".$field_name[$r]."` = '".nl2br(stringIt($date_toput))."', ";
								$where_last = $where_last."`".$field_name[$r]."` = '".nl2br(stringIt($old_explode[$r]))."' AND ";
								$where_queries = $where_queries."`".$field_name[$r]."` = '".mysql_escape_string($old_explode[$r])."' AND ";
							} else {
								$set_queries = $set_queries."`".$field_name[$r]."` = '".mysql_escape_string($date_toput)."'";
								$set_last = $set_last."`".$field_name[$r]."` = '".nl2br(stringIt($date_toput))."'";
								$where_last = $where_last."`".$field_name[$r]."` = '".nl2br(stringIt($old_explode[$r]))."'";
								$where_queries = $where_queries."`".$field_name[$r]."` = '".mysql_escape_string($old_explode[$r])."'";
							}
						} else {
							if($r != $num_we_want){
								$set_queries = $set_queries."`".$field_name[$r]."` = now(), ";
								$set_last = $set_last."`".$field_name[$r]."` = now(), ";
								$where_last = $where_last."`".$field_name[$r]."` = '".nl2br(stringIt($old_explode[$r]))."' AND ";
								$where_queries = $where_queries."`".$field_name[$r]."` = '".mysql_escape_string($old_explode[$r])."' AND ";
							} else {
								$set_queries = $set_queries."`".$field_name[$r]."` = now()";
								$set_last = $set_last."`".$field_name[$r]."` = now()";
								$where_last = $where_last."`".$field_name[$r]."` = '".nl2br(stringIt($old_explode[$r]))."'";
								$where_queries = $where_queries."`".$field_name[$r]."` = '".mysql_escape_string($old_explode[$r])."'";
							}
						}
					} else if($field_type[$r] == "date"){
						$functions = $_POST[stringItvTwo($field_name[$r])."_function"];
						$function = $functions[$i];
						if($function != "now"){
							$date_toput = $field_new_array[$i][0]."-".$field_new_array[$i][1]."-".$field_new_array[$i][2];
							if($r != $num_we_want){
								$set_queries = $set_queries."`".$field_name[$r]."` = '".mysql_escape_string($date_toput)."', ";
								$set_last = $set_last."`".$field_name[$r]."` = '".nl2br(stringIt($date_toput))."', ";
								$where_last = $where_last."`".$field_name[$r]."` = '".nl2br(stringIt($old_explode[$r]))."' AND ";
								$where_queries = $where_queries."`".$field_name[$r]."` = '".mysql_escape_string($old_explode[$r])."' AND ";
							} else {
								$set_queries = $set_queries."`".$field_name[$r]."` = '".mysql_escape_string($date_toput)."'";
								$set_last = $set_last."`".$field_name[$r]."` = '".nl2br(stringIt($date_toput))."'";
								$where_last = $where_last."`".$field_name[$r]."` = '".nl2br(stringIt($old_explode[$r]))."'";
								$where_queries = $where_queries."`".$field_name[$r]."` = '".mysql_escape_string($old_explode[$r])."'";
							}
						} else {
							if($r != $num_we_want){
								$set_queries = $set_queries."`".$field_name[$r]."` = now(), ";
								$set_last = $set_last."`".$field_name[$r]."` = now(), ";
								$where_last = $where_last."`".$field_name[$r]."` = '".nl2br(stringIt($old_explode[$r]))."' AND ";
								$where_queries = $where_queries."`".$field_name[$r]."` = '".mysql_escape_string($old_explode[$r])."' AND ";
							} else {
								$set_queries = $set_queries."`".$field_name[$r]."` = now()";
								$set_last = $set_last."`".$field_name[$r]."` = now()";
								$where_last = $where_last."`".$field_name[$r]."` = '".nl2br(stringIt($old_explode[$r]))."'";
								$where_queries = $where_queries."`".$field_name[$r]."` = '".mysql_escape_string($old_explode[$r])."'";
							}
						}
					} else if($field_type[$r] == "datetime"){
						$functions = $_POST[stringItvTwo($field_name[$r])."_function"];
						$function = $functions[$i];
						if($function != "now"){
							$date_toput = $field_new_array[$i][0]."-".$field_new_array[$i][1]."-".$field_new_array[$i][2]." ".$field_new_array[$i][3].":".$field_new_array[$i][4].":".$field_new_array[$i][5];
							if($r != $num_we_want){
								$set_queries = $set_queries."`".$field_name[$r]."` = '".mysql_escape_string($date_toput)."', ";
								$set_last = $set_last."`".$field_name[$r]."` = '".nl2br(stringIt($date_toput))."', ";
								$where_last = $where_last."`".$field_name[$r]."` = '".nl2br(stringIt($old_explode[$r]))."' AND ";
								$where_queries = $where_queries."`".$field_name[$r]."` = '".mysql_escape_string($old_explode[$r])."' AND ";
							} else {
								$set_queries = $set_queries."`".$field_name[$r]."` = '".mysql_escape_string($date_toput)."'";
								$set_last = $set_last."`".$field_name[$r]."` = '".nl2br(stringIt($date_toput))."'";
								$where_last = $where_last."`".$field_name[$r]."` = '".nl2br(stringIt($old_explode[$r]))."'";
								$where_queries = $where_queries."`".$field_name[$r]."` = '".mysql_escape_string($old_explode[$r])."'";
							}
						} else {
							if($r != $num_we_want){
								$set_queries = $set_queries."`".$field_name[$r]."` = now(), ";
								$set_last = $set_last."`".$field_name[$r]."` = now(), ";
								$where_last = $where_last."`".$field_name[$r]."` = '".nl2br(stringIt($old_explode[$r]))."' AND ";
								$where_queries = $where_queries."`".$field_name[$r]."` = '".mysql_escape_string($old_explode[$r])."' AND ";
							} else {
								$set_queries = $set_queries."`".$field_name[$r]."` = now()";
								$set_last = $set_last."`".$field_name[$r]."` = now()";
								$where_last = $where_last."`".$field_name[$r]."` = '".nl2br(stringIt($old_explode[$r]))."'";
								$where_queries = $where_queries."`".$field_name[$r]."` = '".mysql_escape_string($old_explode[$r])."'";
							}
						}
					} else if($field_type[$r] == "time"){
						$functions = $_POST[stringItvTwo($field_name[$r])."_function"];
						$function = $functions[$i];
						if($function != "now"){
							$time_toput = $field_new_array[$i][0].":".$field_new_array[$i][1].":".$field_new_array[$i][2];
							if($r != $num_we_want){
								$set_queries = $set_queries."`".$field_name[$r]."` = '".mysql_escape_string($time_toput)."', ";
								$set_last = $set_last."`".$field_name[$r]."` = '".nl2br(stringIt($time_toput))."', ";
								$where_last = $where_last."`".$field_name[$r]."` = '".nl2br(stringIt($old_explode[$r]))."' AND ";
								$where_queries = $where_queries."`".$field_name[$r]."` = '".mysql_escape_string($old_explode[$r])."' AND ";
							} else {
								$set_queries = $set_queries."`".$field_name[$r]."` = '".mysql_escape_string($time_toput)."'";
								$set_last = $set_last."`".$field_name[$r]."` = '".nl2br(stringIt($time_toput))."'";
								$where_last = $where_last."`".$field_name[$r]."` = '".nl2br(stringIt($old_explode[$r]))."'";
								$where_queries = $where_queries."`".$field_name[$r]."` = '".mysql_escape_string($old_explode[$r])."'";
							}
						} else {
							if($r != $num_we_want){
								$set_queries = $set_queries."`".$field_name[$r]."` = now(), ";
								$set_last = $set_last."`".$field_name[$r]."` = now(), ";
								$where_last = $where_last."`".$field_name[$r]."` = '".nl2br(stringIt($old_explode[$r]))."' AND ";
								$where_queries = $where_queries."`".$field_name[$r]."` = '".mysql_escape_string($old_explode[$r])."' AND ";
							} else {
								$set_queries = $set_queries."`".$field_name[$r]."` = now()";
								$set_last = $set_last."`".$field_name[$r]."` = now()";
								$where_last = $where_last."`".$field_name[$r]."` = '".nl2br(stringIt($old_explode[$r]))."'";
								$where_queries = $where_queries."`".$field_name[$r]."` = '".mysql_escape_string($old_explode[$r])."'";
							}
						}
					} else if($field_type[$r] == "set"){
						$for_to_split = $field_new_array[$i];
						$values = "";
						foreach($for_to_split as $key=>$value){
							$num_sets = count($for_to_split) - 1;
							if($key == $num_sets){
								$values = $values.$value;
							} else {
								$values = $values.$value.",";
							}
						}
						if($r != $num_we_want){
							$set_queries = $set_queries."`".$field_name[$r]."` = '".$values."', ";
							$set_last = $set_last."`".$field_name[$r]."` = '".nl2br(stringIt($values))."', ";
							$where_last = $where_last."`".$field_name[$r]."` = '".nl2br(stringIt($old_explode[$r]))."' AND ";
							$where_queries = $where_queries."`".$field_name[$r]."` = '".$old_explode[$r]."' AND ";
						} else {
							$set_queries = $set_queries."`".$field_name[$r]."` = '".$values."'";
							$set_last = $set_last."`".$field_name[$r]."` = '".nl2br(stringIt($values))."'";
							$where_last = $where_last."`".$field_name[$r]."` = '".nl2br(stringIt($old_explode[$r]))."'";
							$where_queries = $where_queries."`".$field_name[$r]."` = '".$old_explode[$r]."'";
						}
					}
				}

				$update_final[$i] = "UPDATE `".$_SESSION['table']."` SET ".$set_queries." WHERE ".$where_queries." LIMIT 1";
				$last_final[$i] = "UPDATE `".stringIt($_SESSION['table'])."` SET ".$set_last." WHERE ".$where_last." LIMIT 1";
				$set_queries = "";
				$where_queries = "";
				$set_last = "";
				$where_last = "";

				$i++;
			}

			foreach($update_final as $key=>$query){
				$result_of = mysql_query($query);
				if(!@$result_of){
					$_SESSION['mysql_error'] = @mysql_error();
					$_SESSION['last_query'] = $last_final[$key];
					$_SESSION['form_post']['rows'] = $_POST['rows'];
					$_SESSION['form_post']['values'] = $_POST['old_values'];
					$problem = true;
				}
				if(count($update_final) == 1){
					$last_edit_query = $last_final[$key];
				} else {
					$last_num = count($update_final) - 1;
					if($key == $last_num){
						$last_edit_query .= $last_final[$key];
					} else {
						$last_edit_query .= $last_final[$key].",<br />";
					}
				}
			}
		}

		if($problem == true){
			$_SESSION['show'] = "editrow";
		} else {
			unset($_SESSION['form_post']);
			$_SESSION['last_edit_query'] = $last_edit_query;
			$_SESSION['show'] = "browse";
		}

		header("Location: main.php");
	break;
	case 15:		// ADD FIELD(S)
		$connection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
		$db = @mysql_select_db($_SESSION['database'],$connection);

		$post = $_POST;
		if($_POST['submit']){
			unset($_SESSION['form_post']);
			$_SESSION['form_post'] = $post;

			$num_fields = count($post['field_name']);

			for($s=0;$s<$num_fields;$s++){
				if(empty($post['field_name'][$s])){
					unset($post['field_name'][$s]);
				}
				if(empty($post['ft'][$s])){
					unset($post['ft'][$s]);
				}
			}

			$num_full_texts = count($post['ft']);
			$cur_full_text = 0;
			$num_fields = count($post['field_name']);

			for($l=0;$l<$num_fields;$l++){
				if(!empty($post['field_name'][$l])){
					if($l == 0){
						if($post['add_where'] == "beginning"){
							$field_where = "FIRST";
						} else if($post['add_where'] == "end"){
							$field_where = "";
						} else if($post['add_where'] == "after"){
							$field_where = "AFTER `".$post['after_field']."`";
						}
					} else {
						$last_field = $post['field_name'][$l-1];
						$field_where = "AFTER `".$last_field."`";
						$continue = true;
					}
					$field_name = str_replace("`", "", $post['field_name'][$l]);
					$field_type = strtoupper($post['field_type'][$l]);
					$field_value = (!empty($post['field_value'][$l]))?"(".$post['field_value'][$l].")":"";
					$field_extra = $post['field_extra'][$l];
					$field_other = $post['field_other'][$l];
					if($field_extra != "auto_increment"){
						$field_default = " DEFAULT '".mysql_escape_string($post['field_default'][$l])."'";
					} else {
						$field_extra = " ".$field_extra;
					}
					$field_null = $post['field_null'][$l];
					if($field_other == "unique"){
						$uniques[] = "`".$field_name."`";
					}
					if($field_other == "index"){
						$indexes[] = "`".$field_name."`";
					}
					if($post['ft'.$l] == "true"){
						$fulltexts[] = "`".$field_name."`";
					}
					if($field_other == "primary"){
						$field_other = " PRIMARY KEY";
					} else {
						$field_other = NULL;
					}

					if($l == ($num_fields - 1)){
				 		$add_field_query[$l] = "ADD `".$field_name."` ".$field_type.$field_value." ".$field_null.$field_default.$field_extra.$field_other." ".$field_where;
					} else {
						if($num_fields != 1){
							$add_field_query[$l] = "ADD `".$field_name."` ".$field_type.$field_value." ".$field_null.$field_default.$field_extra.$field_other." ".$field_where.", ";
						} else {
							$add_field_query[$l] = "ADD `".$field_name."` ".$field_type.$field_value." ".$field_null.$field_default.$field_extra.$field_other." ".$field_where;
						}
					}
				}

			}

			$problem = false;
			if(count($add_field_query) > 0){
				$num_uniques = count($uniques);
				$num_indexes = count($indexes);
				$num_fulltexts = count($fulltexts);
				$total_indexes = $num_uniques + $num_indexes + $num_fulltexts;
				if($total_indexes > 0){
					if($num_uniques > 0){
						for($i=0;$i<$num_uniques;$i++){
							$we_want = $num_uniques - 1;
							if($i == $we_want){
								$unique_query = $unique_query.$uniques[$i];
							} else {
								$unique_query = $unique_query.$uniques[$i].", ";
							}
						}
						$unique_query = "ADD UNIQUE ( ".$unique_query." )";
						$queries[] = $unique_query;
					}
					if($num_indexes > 0){
						for($i=0;$i<$num_indexes;$i++){
							$we_want = $num_indexes - 1;
							if($i == $we_want){
								$index_query = $index_query.$indexes[$i];
							} else {
								$index_query = $index_query.$indexes[$i].", ";
							}
						}
						$index_query = "ADD INDEX ( ".$index_query." )";
						$queries[] = $index_query;
					}
					if($num_fulltexts > 0){
						for($i=0;$i<$num_fulltexts;$i++){
							$we_want = $num_fulltexts - 1;
							if($i == $we_want){
								$ft_query = $ft_query.$fulltexts[$i];
							} else {
								$ft_query = $ft_query.$fulltexts[$i].", ";
							}
						}
						$ft_query = "ADD FULLTEXT ( ".$ft_query." )";
						$queries[] = $ft_query;
					}

					$query_num = count($queries);
					for($i=0;$i<$query_num;$i++){
						$we_want = $query_num - 1;
						if($i == $we_want){
							$final_index_query = $final_index_query.$queries[$i];
						} else {
							$final_index_query = $final_index_query.$queries[$i].", ";
						}
					}

					$completed_index_query = "ALTER TABLE `".$_SESSION['table']."` ".$final_index_query;
				}

				$first_final = "ALTER TABLE `".$_SESSION['table']."` ";
				$first_final_for_last = "ALTER TABLE `".stringIt($_SESSION['table'])."`";
				foreach($add_field_query as $key=>$query){
					$first_final = $first_final.$query;
					$first_final_for_last = $first_final_for_last."<br>".stringIt($query);
				}
				$_SESSION['last_query'] = stripslashes($first_final_for_last);
				$_SESSION['last_query'] .= (!empty($completed_index_query))?"<p>".stringIt($completed_index_query):NULL;
				$result = @mysql_query($first_final);
				if(!$result){
					$_SESSION['show'] = "addfield";
					$_SESSION['mysql_error'] = @mysql_error();
				} else {
					if(!empty($completed_index_query)){
						$second_result = @mysql_query($completed_index_query);
						if(!$second_result){
							$_SESSION['mysql_error'] = @mysql_error();
						}
					}

					$_SESSION['show'] = "structure";

				}

			} else {
				$_SESSION['show'] = "structure";
			}
		}

		header("Location: main.php");
	break;
	case 16:		// LIMIT BROWSE QUERY
		if(!empty($_POST['submit'])){
			$_SESSION['ex_query_info']['limit'] = $_POST['limit'];
			$_SESSION['ex_query_info']['start'] = $_POST['start'];
		} else if(!empty($_GET['p'])){
			$page = $_GET['p'] - 1;

			$_SESSION['ex_query_info']['page'] = $_GET['p'];

			$start = $page * $_SESSION['ex_query_info']['limit'];
			$_SESSION['ex_query_info']['start'] = $start;
		} else if($_GET['do'] == "order"){
			$connection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
			$db = @mysql_select_db($_SESSION['database'],$connection);
		
			$check_field = mysql_query("SHOW COLUMNS FROM `".$_SESSION['table']."`");
			while($row = mysql_fetch_assoc($check_field)){
				if($_GET['field'] == $row['Field']){
					$set_order = true;
				}
			}
			
			if($set_order == true){
				if($_SESSION['ex_query_info']['sort_by'] == $_GET['field']){
					$_SESSION['ex_query_info']['sort_order'] = ($_SESSION['ex_query_info']['sort_order'] == "asc")?"desc":"asc";
				} else {
					$_SESSION['ex_query_info']['sort_by'] = $_GET['field'];
					$_SESSION['ex_query_info']['sort_order'] = "asc";
				}
			}
		}

		header("Location: main.php");
	break;
	case 17:		// LOAD QUERY FILE
		if(!empty($_FILES['file'])){
			if(!empty($_FILES['file']['tmp_name'])){
				$contents = file_get_contents($_FILES['file']['tmp_name']);

				$_SESSION['query_line'] = $contents;
			}
		}
		header("Location: main.php");
	break;
	case 18:		// DROP FIELD(S)
		$connection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
		$db = @mysql_select_db($_SESSION['database'],$connection);

		if($_POST['confirm'] == "yes"){
			foreach($_POST['drop_query'] as $key=>$query){
				$drop_query = $drop_query.$query;
			}

			$final_drop_query = "ALTER TABLE `".$_SESSION['table']."` ".$drop_query;
			$result = @mysql_query($final_drop_query);
			if(!$result){
				$_SESSION['mysql_error'] = @mysql_error();
			}

			unset($_SESSION['form_post']);

			$_SESSION['last_query'] = stringIt($final_drop_query);
		}

		$_SESSION['show'] = "structure";

		header("Location: main.php");
	break;
	case 19:		// DROP INDEXES
		$connection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
		$db = @mysql_select_db($_SESSION['database'],$connection);

		$post = $_SESSION['form_post'];
		if($_POST['confirm'] == "yes"){
			$index_num = count($post['index']);
			$i = 0;
			foreach($post['index'] as $key=>$value){
				$i++;
				if($i == $index_num){
					if($value == "PRIMARY"){
						$query = $query."DROP PRIMARY KEY";
					} else {
						$query = $query."DROP INDEX `".$value."`";
					}
				} else {
					if($value == "PRIMARY"){
						$query = $query."DROP PRIMARY KEY, ";
					} else {
						$query = $query."DROP INDEX `".$value."`, ";
					}
				}
			}

			$final_query = "ALTER TABLE `".$_SESSION['table']."` ".$query;
			$result = mysql_query($final_query);
			$_SESSION['mysql_error'] = @mysql_error();
			$_SESSION['last_query'] = stringIt($final_query);
		}

		$_SESSION['show'] = "indexes";

		header("Location: main.php");
	break;
	case 20:		// ADD INDEXES
		$connection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
		$db = @mysql_select_db($_SESSION['database'],$connection);

		unset($_SESSION['form_post']);
		$_SESSION['form_post'] = $_POST;
		$post = $_POST;
		if(!$post['index_name']){
			if($post['index_type'] == "PRIMARY"){
				if($post['index_field'] != NULL){
					$post['index_name'] = "PRIMARY";
				}
			}
		} else {
			if(eregi('primary', $post['index_name'])){
				if($post['index_type'] != "PRIMARY"){
					$_SESSION['mysql_error'] = ADD_PRIMARY_ERROR_TEXT;
					$problem = true;
				}
			}
		}
		if($post['index_name'] != NULL && $post['index_type'] != NULL && $post['index_field'] != NULL){
			if($post['index_type'] == "PRIMARY"){
				$query = "ALTER TABLE `".$_SESSION['table']."` ADD PRIMARY KEY (`".$post['index_field']."`)";
			} else {
				$query = "ALTER TABLE `".$_SESSION['table']."` ADD ".$post['index_type']." `".$post['index_name']."` (`".$post['index_field']."`)";
			}

			if($problem != true){
				$result = mysql_query($query);
			}
			if(!$result){
				if($problem != true) $_SESSION['mysql_error'] = @mysql_error();
			} else {
				unset($_SESSION['form_post']);
			}

			$_SESSION['last_query'] = stringIt($query);
		}

		header("Location: main.php");
	break;
	case 21:		// DROP A DATABASE
		if($_POST['confirm'] == "yes"){
			$connection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
			
			if(count($_SESSION['form_post']['rows']) > 0){
				$i = 0;
				foreach($_SESSION['form_post']['rows'] as $key=>$value){
					$query .= ($i == 0)?"`".mysql_escape_string($value)."`":", `".mysql_escape_string($value)."`";
					$i++;
				}
				$f_quer = "DROP DATABASE ".$query;
				$_SESSION['last_query'] = $f_quer;
				$final = mysql_query($f_quer);
				if(!$final){
					$_SESSION['mysql_error'] = mysql_error();
				}
			}
		}
		
		unset($_SESSION['show']);
		header("Location: main.php");
	break;
	case 22:		// BACKUP/EXPORT DATABASE
		$conntection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
		$db = mysql_select_db($_SESSION['database']);
		$db_name = $_SESSION['database'];

		function get_table_def($table, $crlf,$db_name)
		{
			$schema_create = "DROP TABLE IF EXISTS `$table`;$crlf";
			$db = $table;

			$schema_create .= "CREATE TABLE `$table` ($crlf";

			$result = mysql_query("SHOW FIELDS FROM `".$table."`") or die(mysql_error());
			echo "test";
			while($row = mysql_fetch_array($result))
			{
				$schema_create .= "  `$row[Field]` $row[Type]";

				if(isset($row["Default"]) && (!empty($row["Default"]) || $row["Default"] == "0"))
					$schema_create .= " DEFAULT '$row[Default]'";
				if($row["Null"] != "YES")
					$schema_create .= " NOT NULL";
				if($row["Extra"] != "")
					$schema_create .= " $row[Extra]";
				$schema_create .= ",$crlf";
			}
			$schema_create = ereg_replace(",".$crlf."$", "", $schema_create);
			$result = mysql_query("SHOW KEYS FROM `".$table."`") or die();
			while($row = mysql_fetch_array($result))
			{
				$kname=$row['Key_name'];
				$comment=(isset($row['Comment'])) ? $row['Comment'] : '';
				$sub_part=(isset($row['Sub_part'])) ? $row['Sub_part'] : '';

				if(($kname != "PRIMARY") && ($row['Non_unique'] == 0))
					$kname="UNIQUE|$kname";

				if($comment=="FULLTEXT")
					$kname="FULLTEXT|$kname";
				 if(!isset($index[$kname]))
					 $index[$kname] = array();

				if ($sub_part>1)
				 $index[$kname][] = $row['Column_name'] . "(" . $sub_part . ")";
				else
				 $index[$kname][] = "`".$row['Column_name']."`";
			}

			while(list($x, $columns) = @each($index))
			{
				 $schema_create .= ",$crlf";
				 if($x == "PRIMARY")
					$schema_create .= "   PRIMARY KEY (";
				 elseif (substr($x,0,6) == "UNIQUE")
					$schema_create .= "   UNIQUE `".substr($x,7)."` (";
				 elseif (substr($x,0,8) == "FULLTEXT")
					$schema_create .= "   FULLTEXT `".substr($x,9)."` (";
				 else
					$schema_create .= "   KEY `$x` (";
				$schema_create .= implode($columns,", ") . ")";
			}

			$schema_create .= "$crlf)";
			$tb_info = @mysql_query("SHOW TABLE STATUS LIKE '".$table."'");
			$tb_info = mysql_fetch_assoc($tb_info);
			$tb_type = (!empty($tb_info['Type']))?$tb_info['Type']:$tb_info['Engine'];
			$tb_comment = $tb_info['Comment'];
			$schema_create .= " TYPE = ".$tb_type."";
			$schema_create .= ($tb_comment != NULL)?" COMMENT='".addslashes($tb_comment)."'":NULL;
			if(get_magic_quotes_gpc()) {
			  return (stripslashes($schema_create));
			} else {
			  return ($schema_create);
			}
		}
		function get_table_content($db, $table, $limit_from = 0, $limit_to = 0,$handler)
		{
			// Defines the offsets to use
			if ($limit_from > 0) {
				$limit_from--;
			} else {
				$limit_from = 0;
			}
			if ($limit_to > 0 && $limit_from >= 0) {
				$add_query  = " LIMIT $limit_from, $limit_to";
			} else {
				$add_query  = '';
			}

			get_table_content_fast($db, $table, $add_query,$handler);

		}

		function get_table_content_fast($db, $table, $add_query = '',$handler)
		{
			$result = mysql_query('SELECT * FROM `'.$table.'`') or die();
			if ($result != false) {

				@set_time_limit(1200); // 20 Minutes

				// Checks whether the field is an integer or not
				for ($j = 0; $j < mysql_num_fields($result); $j++) {
					$field_set[$j] = mysql_field_name($result, $j);
					$type          = mysql_field_type($result, $j);
					if ($type == 'tinyint' || $type == 'smallint' || $type == 'mediumint' || $type == 'int' ||
						$type == 'bigint') {
						$field_num[$j] = true;
					} else {
						$field_num[$j] = false;
					}
				} // end for

				// Get the scheme
				if (isset($GLOBALS['showcolumns'])) {
					$fields        = implode(', ', $field_set);
					$schema_insert = "INSERT INTO `$table` ($fields) VALUES (";
				} else {
					$schema_insert = "INSERT INTO `$table` VALUES (";
				}

				$field_count = mysql_num_fields($result);

				$search  = array("\x0a","\x0d","\x1a"); //\x08\\x09, not required
				$replace = array("\\n","\\r","\Z");


				while ($row = mysql_fetch_row($result)) {
					for ($j = 0; $j < $field_count; $j++) {
						if (!isset($row[$j])) {
							$values[]     = 'NULL';
						} else if (!empty($row[$j])) {
							// a number
							if ($field_num[$j]) {
								$values[] = "'".$row[$j]."'";
							}
							// a string
							else {
								$values[] = "'" . str_replace($search, $replace, addslashes($row[$j])) . "'";
							}
						} else {
							$values[]     = "''";
						} // end if
					} // end for

					$insert_line = $schema_insert . implode(',', $values) . ')';
					unset($values);

					// Call the handler
					$handler($insert_line);
				} // end while
			} // end if ($result != false)

			return true;
		}


		function my_handler($sql_insert)
		{
			global $crlf, $asfile;
			global $tmp_buffer;

			if(empty($asfile))
				$tmp_buffer.= stringIt("$sql_insert;$crlf");
			else
				$tmp_buffer.= "$sql_insert;$crlf";
		}



		function faqe_db_error()
		{
			return mysql_error();
		}



		function faqe_db_insert_id($result)
		{
			return mysql_insert_id($result);
		}

		$post = $_POST;
		if(count($post['rows']) > 0){
			if($post['export_to'] == "textarea"){
				$_SESSION['backup_export_to'] = "textarea";
			} else if($post['export_to'] == "file"){
				$_SESSION['backup_export_to'] = "file";
			}
		}

		$crlf="\r\n";

		$dump_buffer="";

		$tables = mysql_query("show tables from `$db_name`");
		$num_tables = mysql_num_rows($tables);

		if($num_tables == 0)
		{
			unset($_SESSION['backup_sql']);
			header("Location: main.php");
		}
		$tables_Num = count($post['rows']);
		if($tables_Num < 1){
			unset($_SESSION['backup_sql']);
			$dont_run = true;
		}

		if($_POST['comments_or_not'] == "yes"){
			$dump_buffer.= "# MySQL Quick Admin Database Backup $crlf";
			$dump_buffer.= "# Backup made: ".date("F j, Y, g:i a")."$crlf";
			$dump_buffer.= "# Database: $db_name$crlf";
		}

		$i = 0;
		while($i < $num_tables)
		{
			$table = mysql_tablename($tables, $i);
			if(in_array($table, $post['rows'])){
				//echo $table . "<br>";
				if($_POST['comments_or_not'] == "yes"){
					$dump_buffer.= "# --------------------------------------------------------$crlf";
					$dump_buffer.= "$crlf#$crlf";
					$dump_buffer.= "# Table structure for table '$table'$crlf";
					$dump_buffer.= "#$crlf$crlf";
				}
				$db = $table;
			$dump_buffer.= get_table_def($table, $crlf,$db_name).";$crlf";
				if($post['rows_or_not'] == "yes"){
					if($_POST['comments_or_not'] == "yes"){
						$dump_buffer.= "$crlf#$crlf";
						$dump_buffer.= "# Dumping data for table '$table'$crlf";
						$dump_buffer.= "#$crlf$crlf";
					} else {
						$dump_buffer .= "$crlf";
					}
					$tmp_buffer="";
					$dump_buffer .= get_table_content($db_name, $table, 0, 0, 'my_handler', $db_name);
					$dump_buffer.=$tmp_buffer;
				}

				$dump_buffer.= "$crlf$crlf";
			}

			$i++;
		}
		if($dont_run != true){
			$_SESSION['backup_sql'] = $dump_buffer;
		}

		header("Location: main.php");
	break;
	case 24:	// SELECT A LANGUAGE
		if($_POST['lang']){
			$_SESSION['language'] = $_POST['lang'];
		}
		header("Location: main.php");
	break;
	case 25:
		if($_POST['submit']){	
			$conntection = @mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
			$db = mysql_select_db($_SESSION['database']);
				
			$row_count = 0;
			$orders = array();
			$filters = array();
			
			foreach($_POST['rows'] as $key=>$value){
				$clause = $_POST[urlencode($value)."_clause"];
				$term = $_POST[urlencode($value)];
				if($_POST['empty_choose'] == "selected"){
					if($term == NULL){
						if($clause == "IS NULL" || $clause == "IS NOT NULL"){
							$continue = true;
						} else {
							$continue = false;
						}
					} else {
						$continue = true;
					}
				} else {
					$continue = true;
				}
				
				if($continue == true){					
					$new_term = ($clause != "IS NULL" && $clause != "IS NOT NULL")?" '".mysql_escape_string($term)."' ":NULL;
					$new_term_2 = ($clause != "IS NULL" && $clause != "IS NOT NULL")?" '".$term."' ":NULL;
					if($clause == "BETWEEN"){
						$terms = trim($term);
						$terms = explode(",", $terms);
						$new_term = " '".mysql_escape_string($terms[0])."' AND '".mysql_escape_string($terms[1])."' ";
						$new_term_2 = " '".$terms[0]."' AND '".$terms[1]."' ";
					}
					
					$query_string .= ($row_count === 0)?" WHERE `".$value."` ".$clause.$new_term:" AND `".$value."` ".$clause.$new_term;
					$last_query_string .= ($row_count === 0)?" WHERE `".$value."` ".$clause.$new_term_2:" AND `".$value."` ".$clause.$new_term_2;
					
					$order = $_POST[urlencode($value)."_order"];
					if(!in_array($order, $orders) && !empty($order)){
						$orders[$value] = $order;
						$filters[$order] = $_POST[urlencode($value)."_filter"];
					}
					
					$row_count++;
				}
			}
			
			if(count($orders) > 0){
				$o_count = 0;
				asort($orders, SORT_NUMERIC);			
				foreach($orders as $key=>$value){
					$order_by .= ($o_count === 0)?" ORDER BY `".$key."` ".$filters[$value]:", `".$key."` ".$filters[$value];
					$o_count++;
				}
			}
			
			$distinct = ($_POST['distinct_choose'] == "yes")?"DISTINCT ":NULL;
			
			if($_POST['browse_choose'] == "all"){						
				$select = "*";
			} else {
				foreach($_POST['show_rows'] as $key=>$value){
					$select .= ($key === 0)?"`".$value."`":", `".$value."`";
				}
			}
			
			$final = "SELECT ".$distinct.$select." FROM `".$_SESSION['table']."`".$query_string.$order_by;
			$_SESSION['browse_query'] = $final;
			$_SESSION['last_edit_query'] = stringIt("SELECT ".$distinct.$select." FROM `".$_SESSION['table']."`".$last_query_string.$order_by);
			$result = mysql_query($final);
			
			$_SESSION['search_q'] = true;
			if(!$result){
				$_SESSION['mysql_error'] = @mysql_error();
			}
		}
		
		$_SESSION['show'] = "browse";
		header("Location: main.php");
	break;
	case 26:
		unset($_SESSION['form_post']);
	
		$new_query = $_POST['the_query'];
		if(!empty($new_query)){
			$_SESSION['prev_query'][$_GET['query']] = $new_query;
		}
		
		$_SESSION['show'] = "query";
		header("Location: main.php");
	break;
	case 27:
		$do = $_GET['do'];
		if($do == "theme" && file_exists("themes/".$_GET['theme'])){
			setcookie('theme', $_GET['theme'], time()+60*60*24*30);
			$_SESSION['theme'] = $_GET['theme'];
			unset($_SESSION['theme_name']);
		} else if($do == "lang" && file_exists("lang/".$_GET['lang'])){
			setcookie('language', $_GET['lang'], time()+60*60*24*30);
			$_SESSION['language'] = $_GET['lang'];
			unset($_SESSION['lang_name']);
		}
		header("Location: main.php");
	break;
	case 28:
		if(count($_SESSION['form_post']['rows']) > 0 && $_POST['submit']){
			if($_POST['html_template'] == "table"){
				foreach($_SESSION['form_post']['rows'] as $key=>$value){
					if($_POST['fix_field'] == "yes"){
						$value = trim(str_replace("_", " ", $value));
						$new_vals = explode(" ", $value);
						foreach($new_vals as $keyy=>$new_val){
							$f_val .= ($keyy === 0)?ucfirst($new_val):" ".ucfirst($new_val);
						}
						$f_html[] = "<td class=\"\">".$f_val."</td>";
						$f_val = "";
					} else {
						$f_html[] = "<td class=\"\">".$value."</td>";
					}
				}
				$all_html = "<table>";
				foreach($f_html as $key2=>$val2){
					$all_html .= "\n	<tr>\n		".$val2."\n	</tr>";
				}
				$all_html .= "\n</table>";
			} else if($_POST['html_template'] == "form"){
				$i = 0;
				foreach($_SESSION['form_post']['rows'] as $key=>$value){
					if($_POST['fix_field'] == "yes"){
						$value = trim(str_replace("_", " ", $value));
						$new_vals = explode(" ", $value);
						foreach($new_vals as $keyy=>$new_val){
							$f_val .= ($keyy === 0)?ucfirst($new_val):" ".ucfirst($new_val);
						}
						$f_html[$i][0] = "<td class=\"\">".$f_val.":</td>";
						$f_val = "";
					} else {
						$f_html[$i][0] = "<td class=\"\">".$value.":</td>";
					}
					
					$inp_val = str_replace(" ", "_", $value);
					$f_html[$i][1] = "<td class=\"\"><input type=\"text\" name=\"".$inp_val."\" value=\"\"></td>";
					
					$i++;
				}
				
				$all_html = "<form name=\"formname\" action=\"\" method=\"post\">\n	<table>";
				foreach($f_html as $key2=>$val2){
					$all_html .= "\n		<tr>\n			".$val2[0]."\n			".$val2[1]."\n		</tr>";
				}
				$all_html .= "\n	</table>\n</form>";
			}
			
			$_SESSION['make_html_text'] = $all_html;
		} else {
			$_SESSION['show'] = "structure";
		}
		
		header("Location: main.php");
	break;
	default:
		header("Location: main.php");
	break;
}
?>
