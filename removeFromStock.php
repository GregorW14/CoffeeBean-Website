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
	
	// parameters sent from form 
	$ingName = $_POST['ingName'];
	$ShopInfo = $_POST['ShopInfo'];
	$addDate = $_POST['addDate'];
	
	
	// To protect MySQL injection (more detail about MySQL injection)
	$ingName = mysql_real_escape_string(stripslashes($ingName));
	$ShopInfo = mysql_real_escape_string(stripslashes($ShopInfo));
	$addDate = mysql_real_escape_string(stripslashes($addDate));
	
	
	if(!empty($ingName) && !empty($ShopInfo) && !empty($addDate))
	{
		$addDate = date('Y-m-d', strtotime(str_replace('/', '-', $addDate)));
		
		$ShopInfos = explode(",", $ShopInfo);
	
		$sql="SELECT stockID FROM stock WHERE ingredientID=(SELECT ingredientID FROM ingredient WHERE name='$ingName') AND shopID=(SELECT shopID FROM shop WHERE streetName='$ShopInfos[0]' AND city='$ShopInfos[1]' AND country='$ShopInfos[2]') AND date='$addDate';";
		$result=mysql_query($sql);
		$count=mysql_num_rows($result);

		// If result matched $username and $password, table row must be 1 row
		if($count==1){
			$row = mysql_fetch_assoc($result);
			
			$id=$row["stockID"];
			
			$sql="DELETE FROM stock WHERE stockID='$id';";
			$result=mysql_query($sql);
			
			if ($result == true)
			{
				$errorCode = 3;
				$errorMessage = "Ingredient removed from stock";
			}
			else
			{
				$errorCode = 4;
				$errorMessage = "An error occur";
			}
		} else {
			$errorCode = 4;
			$errorMessage = "Ingredient haven't been found in stock";
		}
	}
	else
	{
		$errorCode = 4;
		$errorMessage = "Please check all fields are filled in";
	}
	
	
	mysql_close($db);
	
	$_SESSION['errorCode'] = $errorCode;
	$_SESSION['errorMessage'] = $errorMessage;
	
	header("location: manageStock.php"); 

} else 
	header("location: index.php"); 
?>