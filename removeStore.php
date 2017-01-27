<?php
if(!isset($_SESSION))
{
	@session_start();
} 
if(!empty($_SESSION['loggedin']) && !empty($_SESSION['type']) &&  $_SESSION['loggedin'] == true && $_SESSION['type'] == "executive"){ 
	$host="silva.computing.dundee.ac.uk"; // Host name 
	$username="15ac3u03"; // Mysql username 
	$password="ab123c"; // Mysql password 
	$db_name="15ac3d03"; // Database name 

	// Connect to server and select databse.
	$db=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");
	
	// parameters sent from form 
	$shopInfo = $_POST['ShopInfo'];
	
	// To protect MySQL injection (more detail about MySQL injection)
	$shopInfo = mysql_real_escape_string(stripslashes($shopInfo));
	
	$ShopInfos = explode(",", $shopInfo);
	
	$sql="CALL shopDelete('$ShopInfos[0]','$ShopInfos[1]','$ShopInfos[2]');";
	$result=mysql_query($sql);
	
	mysql_close($db);
	
	if ($result == true)
	{
		$errorCode = 3;
		$errorMessage = "Store removed";			
	}
	else
	{
		$errorCode = 4;
		$errorMessage = "An error occured";
	}
	
	$_SESSION['errorCode'] = $errorCode;
	$_SESSION['errorMessage'] = $errorMessage;
	
	header('Location: manageStore.php');  
} else 
	header("location: index.php"); 
?>