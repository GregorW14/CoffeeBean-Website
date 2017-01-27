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
	$name = $_POST['name'];
	$ShopInfo = $_POST['ShopInfo'];
	
	if(!empty($name)) {
		// To protect MySQL injection (more detail about MySQL injection)
		$name = mysql_real_escape_string(stripslashes($name));
		$ShopInfo = mysql_real_escape_string(stripslashes($ShopInfo));
		
		$ShopInfos = explode(",", $ShopInfo);
		
		$sql="SELECT productID FROM productbyshop WHERE name='$name' AND streetname = '$ShopInfos[0]' AND city = '$ShopInfos[1]' AND country = '$ShopInfos[2]';";
		$result=mysql_query($sql);
		$count=mysql_num_rows($result);
		
		// If result matched $username and $password, table row must be 1 row
		if($count==1){
			$sql="CALL productToShopDelete('$name','$ShopInfos[0]','$ShopInfos[1]','$ShopInfos[2]');";
			$result=mysql_query($sql);
			
			mysql_close($db);
			
			if ($result == true)
			{
				$errorCode = 3;
				$errorMessage = "Product from shop removed";	
			}
			else
			{
				$errorCode = 4;
				$errorMessage = "An error occur";	
			}
		} else {
			$errorCode = 4;
			$errorMessage = "Error : product not found";	
		}
	} else
	{
		$errorCode = 4;
		$errorMessage = "Please check all fields are filled in";	
	}
	
	mysql_close($db);
	
	$_SESSION['errorCode'] = $errorCode;
	$_SESSION['errorMessage'] = $errorMessage;
	
	header('Location: manageProduct.php');  
	
} else 
	header("location: index.php"); 
?>