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
	$price = $_POST['price'];
	$cost = $_POST['cost'];
	
	if(!empty($name) && !empty($ShopInfo) && !empty($price) && !empty($cost)) {
		// To protect MySQL injection (more detail about MySQL injection)
		$ShopInfo = mysql_real_escape_string(stripslashes($ShopInfo));
		$name = mysql_real_escape_string(stripslashes($name));
		$price = mysql_real_escape_string(stripslashes($price));
		$cost = mysql_real_escape_string(stripslashes($cost));
		
		$ShopInfos = explode(",", $ShopInfo);
		
		$sql="SELECT productID FROM productbyshop WHERE name='$name' AND streetname='$ShopInfos[0]' AND city='$ShopInfos[1]' AND country='$ShopInfos[2]';";
		$result = mysql_query($sql);
		$count=mysql_num_rows($result);
		
		if($count == 0)
		{
			$sql="CALL addProductToShop('$name','$ShopInfos[0]','$ShopInfos[1]','$ShopInfos[2]','$price','$cost');";
			echo $sql;
			$result=mysql_query($sql);
			
			mysql_close($db);
			
			if ($result == true)
			{
				$errorCode = 6;
				$errorMessage = "Product added to shop";	
			}
			else
			{
				$errorCode = 7;
				$errorMessage = "An error occurred";	
			}
		}
		else
		{
			$errorCode = 7;
			$errorMessage = "The product already exists in that shop";	
		}
	} 
	else
	{
		$errorCode = 7;
		$errorMessage = "Please check all fields are filled in";	
	}
	
	$_SESSION['errorCode'] = $errorCode;
	$_SESSION['errorMessage'] = $errorMessage;
	
	header('Location: manageProduct.php');  
	
} else 
	header("location: index.php"); 
?>