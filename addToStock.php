<?php
if(!isset($_SESSION))
{
	@session_start();
} 
if(!empty($_SESSION['loggedin']) && !empty($_SESSION['type']) &&  $_SESSION['loggedin'] == true && ($_SESSION['type'] == "manager" || $_SESSION['type'] == "executive"  || $_SESSION['type'] == "shopfloorstaffmember")){ 

	$host="silva.computing.dundee.ac.uk"; // Host name 
	$username="15ac3u03"; // Mysql username 
	$password="ab123c"; // Mysql password 
	$db_name="15ac3d03"; // Database name 

	// Connect to server and select databse.
	$db=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");
	
	// username and password sent from form 
	$ingName = $_POST['ingName'];
	$ShopInfo = $_POST['ShopInfo'];
	$price = $_POST['price'];
	$expDate = $_POST['ExpDate'];
	$quantity = $_POST['quantity'];
	$unit = $_POST['unit'];
	$supplierName=$_POST['supplierName']; 
	
	// To protect MySQL injection (more detail about MySQL injection)
	if(!empty($ingName) && !empty($ShopInfo) && !empty($price) && !empty($expDate) && !empty($quantity) && !empty($unit) && !empty($supplierName))
	{
		$ingName = mysql_real_escape_string(stripslashes($ingName));
		$ShopInfo = mysql_real_escape_string(stripslashes($ShopInfo));
		$price = mysql_real_escape_string(stripslashes($price));
		$expDate = mysql_real_escape_string(stripslashes($expDate));
		$quantity = mysql_real_escape_string(stripslashes($quantity));	
		$unit = mysql_real_escape_string(stripslashes($unit));
		$supplierName = mysql_real_escape_string(stripslashes($supplierName));
		
		$expDate = date('Y-m-d', strtotime(str_replace('/', '-', $expDate)));
		$date = date('Y-m-d');
		
		$ShopInfos = explode(",", $ShopInfo);

		$sql="CALL stockInsert('$ingName','$price','$expDate','$quantity','$unit','$date','$ShopInfos[0]','$ShopInfos[1]','$ShopInfos[2]','$supplierName');";
		echo $sql;
		$result=mysql_query($sql);
		
		mysql_close($db);
		
		if ($result == true)
		{
			$errorCode = 0;
			$errorMessage = "Ingredient has been added to the stock";
		}
		else
		{
			$errorCode = 1;
			$errorMessage = "An error occured";
		}
	}
	else
	{
		$errorCode = 1;
		$errorMessage = "Please check all fields are filled in";
	}
	
	$_SESSION['errorCode'] = $errorCode;
	$_SESSION['errorMessage'] = $errorMessage;
	
	header('Location: manageStock.php');
	
} else 
	header("location: index.php"); 
?>

