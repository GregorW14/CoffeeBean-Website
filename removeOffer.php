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
	
	// username and password sent from form 
	$name=$_POST['offer']; 
	
	if(!empty($name)) {
	// To protect MySQL injection (more detail about MySQL injection)
	$name = mysql_real_escape_string(stripslashes($name));

	$sql="DELETE FROM offer WHERE name='$name';";
	$result=mysql_query($sql);
	
	mysql_close($db);
	
		if ($result == true)
		{
			$errorCode = 3;
			$errorMessage = "Offer removed";	
		}
		else {
			$errorCode = 4;
			$errorMessage = "An error occur";
		}
	} else {
		$errorCode = 4;
		$errorMessage = "Please check all fields are filled in";
	}
	
	$_SESSION['errorCode'] = $errorCode;
	$_SESSION['errorMessage'] = $errorMessage;
	
	header('Location: manageOffer.php');  
} else 
	header("location: index.php"); 
?>