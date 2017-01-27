<?php
if(!isset($_SESSION))
{
	@session_start();
} 
if(!empty($_SESSION['loggedin']) && !empty($_SESSION['type']) &&  $_SESSION['loggedin'] == true && ($_SESSION['type'] == "manager" || $_SESSION['type'] == "executive" || $_SESSION['type'] == "shopfloorstaffmember")){ 
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
	$status = $_POST['status'];
	
	if(!empty($name) && !empty($ShopInfo)) {
		// To protect MySQL injection (more detail about MySQL injection)
		$name = mysql_real_escape_string(stripslashes($name));
		$ShopInfo = mysql_real_escape_string(stripslashes($ShopInfo));
		$status = mysql_real_escape_string(stripslashes($status));
		
		if($status != 0)
			$status=1;
		
		$ShopInfos = explode(",", $ShopInfo);
		
		$sql="SELECT broken FROM equipmentview WHERE name = '$name' AND shop = '$ShopInfo';";
		$result=mysql_query($sql);
		$count=mysql_num_rows($result);

		// If result matched $username and $password, table row must be 1 row
		if($count==1){
			$row = mysql_fetch_assoc($result);
			if($row["broken"] != $status){
				$sql="UPDATE equipment SET broken='$status' WHERE name = '$name' AND shopID = (SELECT shopID FROM shop WHERE shop.streetName='$ShopInfos[0]' AND shop.city='$ShopInfos[1]' AND shop.country='$ShopInfos[2]');";
				$result=mysql_query($sql);
				
				if ($result == true)
				{
					$errorCode = 6;
					$errorMessage = "Equipment status updated";	
				}
				else
				{
					$errorCode = 7;
					$errorMessage = "An error occur";	
				}
			} else {
				$errorCode = 7;
				$errorMessage = "The equipment is already in this state";	
			}
		} else {
			$errorCode = 7;
			$errorMessage = "Equipment not found";	
		}
	} else
	{
		$errorCode = 7;
		$errorMessage = "All input are not informed";	
	}
	
	mysql_close($db);
	
	$_SESSION['errorCode'] = $errorCode;
	$_SESSION['errorMessage'] = $errorMessage;
	
	header('Location: manageEquipment.php');  
	
} else 
	header("location: index.php"); 
?>