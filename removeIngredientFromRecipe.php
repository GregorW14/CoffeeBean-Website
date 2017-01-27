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
	$nameIng = $_POST['nameIng'];
	$namePr = $_POST['namePr'];
	
	if(!empty($nameIng) && !empty($namePr)) {
		// To protect MySQL injection (more detail about MySQL injection)
		$nameIng = mysql_real_escape_string(stripslashes($nameIng));
		$namePr = mysql_real_escape_string(stripslashes($namePr));
		
		$sql="SELECT quantity FROM product, ingredient, product_ingredient WHERE product.productID=product_ingredient.productID AND ingredient.ingredientID=product_ingredient.ingredientID AND product.name='$namePr' AND ingredient.name='$nameIng';";
		$result=mysql_query($sql);
		//echo $sql;
		$count=mysql_num_rows($result);
		
		// If result matched $username and $password, table row must be 1 row
		if($count==1){
			$sql="CALL ingredientFromRecipeDetele('$namePr','$nameIng');";
			//echo $sql;
			$result=mysql_query($sql);
			
			if ($result == true)
			{
				$errorCode = 3;
				$errorMessage = "Ingredient from recipe removed";	
			}
			else
			{
				$errorCode = 4;
				$errorMessage = "An error occur";	
			}
		} else {
			$errorCode = 4;
			$errorMessage = "Error : ingredient not found in recipe";	
		}
	} else
	{
		$errorCode = 4;
		$errorMessage = "Please check all fields are filled in";	
	}
	
	mysql_close($db);
	
	$_SESSION['errorCode'] = $errorCode;
	$_SESSION['errorMessage'] = $errorMessage;
	
	header('Location: manageIngredient.php');  
	
} else 
	header("location: index.php"); 
?>