<?php

$host="silva.computing.dundee.ac.uk"; // Host name 
$username="15ac3u03"; // Mysql username 
$password="ab123c"; // Mysql password 
$db_name="15ac3d03"; // Database name 
$tbl_name="customer"; // Table name 

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

// username and password sent from form 
$username=$_POST['usernameC']; 
$password= $_POST['passwordC']; 

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
	session_start();
	$_SESSION['loggedin'] = true;
	$_SESSION['username'] = $username;
	$_SESSION['type'] = "customer";
	header("location: index.php");
}
else
{
	//$_SESSION['loginfail'] = "Wrong username and/or password.";
	header("location: loginDisplay.php?customerLoginFail=true");
}

exit();

?>



