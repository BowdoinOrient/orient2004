<?php 

	$redirect = "admin.php";
	$username = $_POST["username"];
	$password = $_POST["password"];

	// Check for missing fields
	if($username == '' || $password == '')
	{
		header("Location: admin.php?redirect=$redirect&msg=missing_fields");
		exit;
	}

	// Connect to the LDAP server
	$ldapConnection = ldap_connect("ldap.bowdoin.edu", "389");
	if($ldapConnection)
	{
		// Attempt to authenticate user against student records in LDAP
		$ldapBind = ldap_bind($ldapConnection, "uid=".$username.", ou=Students, ou=People, o=Bowdoin College, c=US", $password);
		if($ldapBind)
		{
			$sr = ldap_search($ldapConnection, "ou=People, o=Bowdoin College, c=US", "uid=".$username);  
			$info = ldap_get_entries($ldapConnection, $sr);
			if($info["count"]!=1)
			{
				header("Location: admin.php?redirect=$redirect&msg=connection_error");
				exit;
			}
			
			$_SESSION["session_username"] = $username;
			$_SESSION["session_realname"] = $info[0]["cn"][0];
			$_SESSION["session_fullname"] = $info[0]["cn"][0];
			$_SESSION["session_class"] = $info[0]["classyear"][0];
			$_SESSION["session_siteid"] = md5($site_name);
			
			if(strpos($redirect,'signout.php') || strpos($redirect,'unauthorized.php'))
				$redirect = '../index.php';
				
			if(strpos($redirect,'index.php')) //If you sign in from index.php you just go to the admin page
				$redirect = '../admin.php';

			if($redirect)
				$location = $redirect;
			else
				$location = '../index.php';

			header("Location: $location");
			ldap_close($ldapConnection);
			exit;
		}
		
		// Attempt to authenticate user against employee records in LDAP
		$ldapBind = ldap_bind($ldapConnection, "uid=".$username.", ou=Employees, ou=People, o=Bowdoin College, c=US", $password);
		if($ldapBind)
		{
			$sr = ldap_search($ldapConnection, "ou=People, o=Bowdoin College, c=US", "uid=".$username);  
			$info = ldap_get_entries($ldapConnection, $sr);
			if($info["count"]!=1)
			{
				header("Location: ../signin.php?redirect=$redirect&msg=connection_error");
				exit;
			}
			
			$_SESSION["session_username"] = $username;
			$_SESSION["session_realname"] = $info[0]["cn"][0];
			$_SESSION["session_fullname"] = $info[0]["cn"][0];
			$_SESSION["session_siteid"] = md5($site_name);
		
			if(strpos($redirect,'signout.php') || strpos($redirect,'unauthorized.php'))
				$redirect = '../index.php';

			if($redirect)
				$location = $redirect;
			else
				$location = '../index.php';

			header("Location: $location");
			ldap_close($ldapConnection);
			exit;
		}

		// Attempt to authenticate user against student organization records in LDAP
		$ldapBind = ldap_bind($ldapConnection, "uid=".$username.", ou=Student Organizations, ou=People, o=Bowdoin College, c=US", $password);
		if($ldapBind)
		{
			$sr = ldap_search($ldapConnection, "ou=People, o=Bowdoin College, c=US", "uid=".$username);  
			$info = ldap_get_entries($ldapConnection, $sr);
			if($info["count"]!=1)
			{
				header("Location: ../signin.php?redirect=$redirect&msg=connection_error");
				exit;
			}
			
			$_SESSION["session_username"] = $username;
			$_SESSION["session_realname"] = $info[0]["cn"][0];
			$_SESSION["session_fullname"] = $info[0]["cn"][0];
			$_SESSION["session_siteid"] = md5($site_name);
			
			if(strpos($redirect,'signout.php') || strpos($redirect,'unauthorized.php'))
				$redirect = '../index.php';

			if($redirect)
				$location = $redirect;
			else
				$location = '../index.php';

			header("Location: $location");
			ldap_close($ldapConnection);
			exit;
		}

		ldap_close($ldapConnection);

		header("Location: ../signin.php?redirect=$redirect&msg=password_incorrect");
		exit;
	}
	else
	{
		header("Location: ../signin.php?redirect=$redirect&msg=connection_error");
		exit;
	}
	
?>
