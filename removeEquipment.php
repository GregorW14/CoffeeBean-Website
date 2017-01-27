<?php
if(!isset($_SESSION))
{
	@session_start();
} 
if(!empty($_SESSION['loggedin']) && !empty($_SESSION['type']) &&  $_SESSION['loggedin'] == true && $_SESSION['type'] == "manager" || $_SESSION['type'] == "executive" || $_SESSION['type'] == "shopfloorstaffmember"){ 
	$host="silva.computing.dundee.ac.uk"; // Host name 
	$username="15ac3u03"; // Mysql username 
	$password="ab123c"; // Mysql password 
	$db_name="15ac3d03"; // Database name 

	// Connect to server and select databse.
	$db=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");
	
	// username and password sent from form 
	$name = $_POST['name'];
	$ShopInfo = $_POST['ShopInfo'];
	
	if(!empty($name) && !empty($ShopInfo)) {
		// To protect MySQL injection (more detail about MySQL injection)
		$name = mysql_real_escape_string(stripslashes($name));
		$ShopInfo = mysql_real_escape_string(stripslashes($ShopInfo));
		
		$ShopInfos = explode(",", $ShopInfo);
		
		$sql="SELECT equipmentID FROM equipment WHERE name = '$name'  AND shopID = (SELECT shopID FROM shop WHERE shop.streetName='$ShopInfos[0]' AND shop.city='$ShopInfos[1]' AND shop.country='$ShopInfos[2]');";
		$result=mysql_query($sql);
		$count=mysql_num_rows($result);

		// If result matched $username and $password, table row must be 1 row
		if($count==1){
			$row = mysql_fetch_assoc($result);
			$id=$row["equipmentID"];
		
			$sql="DELETE FROM equipment WHERE equipmentID = '$id';";
			//echo $sql;
			$result=mysql_query($sql);
			
			if ($result == true)
			{
				$errorCode = 3;
				$errorMessage = "Equipment removed";	
			}
			else
			{
				$errorCode = 4;
				$errorMessage = "An error occur";	
			}
		}
		else
		{
			$errorCode = 4;
			$errorMessage = "Equipment not found";	
		}
		
		mysql_close($db);
	} 
	else
	{
		$errorCode = 4;
		$errorMessage = "All input are not informed";	
	}
	
	$_SESSION['errorCode'] = $errorCode;
	$_SESSION['errorMessage'] = $errorMessage;
	
	header('Location: manageEquipment.php');  
	
} else 
	header("location: index.php"); 
?>