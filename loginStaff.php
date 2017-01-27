<?php

$host="silva.computing.dundee.ac.uk"; // Host name 
$username="15ac3u03"; // Mysql username 
$password="ab123c"; // Mysql password 
$db_name="15ac3d03"; // Database name 
$tbl_name="staff"; // Table name 

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

// username and password sent from form 
$username=$_POST['username']; 
$password= $_POST['password']; 

if(!empty($username) && !empty($password))
{
	// To protect MySQL injection (more detail about MySQL injection)
	$username = stripslashes($username);
	$password = stripslashes($password);
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);
	$password = hash('sha256',$password);
	$sql="SELECT * FROM $tbl_name WHERE username='$username' and password='$password'";
	$result=mysql_query($sql);

	// Mysql_num_row is counting table row
	$count=mysql_num_rows($result);

	// If result matched $username and $password, table row must be 1 row
	if($count==1){
		$row = mysql_fetch_assoc($result);
		session_start();
		
		if($row["accountActivate"] == 1)
		{			
			$_SESSION['loggedin'] = true;
			$_SESSION['username'] = $username;
			
			$_SESSION['errorCode']="";
			$_SESSION['errorMessage']="";
			
			if ($row["staffRoleID"] == 1)
				$_SESSION['type'] = "shopfloorstaffmember";
			if ($row["staffRoleID"] == 2)
				$_SESSION['type'] = "manager";
			if ($row["staffRoleID"] == 3)
				$_SESSION['type'] = "executive";
			header("location: index.php");
		}
		else
			header("location: loginDisplay.php?staffLoginFail=true");
	}
	else
	{
		//echo "<h1>Wrong username and/or password.</h1>";
		//$_SESSION['loginfail'] = true;
		header("location: loginDisplay.php?staffLoginFail=true");
	}
}
else
{
	header("location: loginDisplay.php?staffLoginFail=true");
}

//header("Location: {$_SERVER['HTTP_REFERER']}");

?>



