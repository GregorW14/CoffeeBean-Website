<?php
if(!isset($_SESSION))
{
	@session_start();
} 
if(!empty($_SESSION['loggedin']) && !empty($_SESSION['type']) &&  $_SESSION['loggedin'] == true && $_SESSION['type'] == "manager" || $_SESSION['type'] == "executive"){ 
	$host="silva.computing.dundee.ac.uk"; // Host name 
	$username="15ac3u03"; // Mysql username 
	$password="ab123c"; // Mysql password 
	$db_name="15ac3d03"; // Database name 

	// Connect to server and select databse.
	$db=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");
	
	// parameters sent from form 
	$name = $_POST['name'];
	$DOB = $_POST['DOB'];
	
	// To protect MySQL injection (more detail about MySQL injection)
	$name = mysql_real_escape_string(stripslashes($name));
	$DOB = mysql_real_escape_string(stripslashes($DOB));

	$DOB = date('Y-m-d', strtotime(str_replace('/', '-', $DOB)));
	
	$sql="SELECT staffID FROM staff WHERE name='$name' AND DOB='$DOB';";
	$result=mysql_query($sql);
	$count=mysql_num_rows($result);

	// If result matched $username and $password, table row must be 1 row
	if($count==1){
		$row = mysql_fetch_assoc($result);
		
		$id=$row["staffID"];
		
		//$sql="DELETE FROM 14ac3d03.staff WHERE name='$name' AND DOB='$DOB';";
		$sql="UPDATE staff SET accountActivate=0 WHERE staffID='$id';";
		$result=mysql_query($sql);
		
		if ($result == true)
		{
			$errorCode = 3;
			$errorMessage = "Staff removed";
		}
		else
		{
			$errorCode = 4;
			$errorMessage = "An error occur";
		}
	} else {
		$errorCode = 4;
		$errorMessage = "Error : Staff member hasn't been found";
	}
	
	mysql_close($db);
	
	$_SESSION['errorCode'] = $errorCode;
	$_SESSION['errorMessage'] = $errorMessage;
	
	header("location: manageStaff.php"); 

} else 
	header("location: index.php"); 
?>