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
	
	// username and password sent from form 
	$offerCode = $_GET['offerCode'];
	
	if(!empty($offerCode)) {
		// To protect MySQL injection (more detail about MySQL injection)
		$offerCode = mysql_real_escape_string(stripslashes($offerCode));;
		
		$sql="SELECT discount FROM offer WHERE code=$offerCode;";
		$result = mysql_query($sql);
			
		mysql_close($db);
		
		$count=mysql_num_rows($result);
		if($count == 0)
			echo 0;
		else{
			$row = mysql_fetch_assoc($result);
			echo $row["discount"];
		}
	}
	else
		echo 0;
}
?>