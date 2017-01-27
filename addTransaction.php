<?php
if(!isset($_SESSION))
{
	@session_start();
} 
if(!empty($_SESSION['loggedin']) && !empty($_SESSION['type']) &&  $_SESSION['loggedin'] == true && ($_SESSION['type'] == "manager" || $_SESSION['type'] == "shopfloorstaffmember" || $_SESSION['type'] == "executive")){

	$host="silva.computing.dundee.ac.uk"; // Host name 
	$username="15ac3u03"; // Mysql username 
	$password="ab123c"; // Mysql password 
	$db_name="15ac3d03"; // Database name 

	// Connect to server and select databse.
	$db=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");
	
	// username and password sent from form 
	$customerUsername = $_POST['customerUsername'];
	$paymentInformation = $_POST['paymentInformation'];
	$OfferCode = $_POST['OfferCode'];
	
	$staffUsername = $_SESSION['username'];
	$date=date('Y-m-d', strtotime('+0 years'));
	
	$time=time();
	$time=date("H:i:s", strtotime("-3 hours - 6 minutes", $time));
	
	$i=1;
	while (!empty($_POST['nameRole_'.$i]))
	{
		$productName[]=$_POST['nameRole_'.$i];
		$quantity[]=$_POST['quantity_'.$i];
		
		$i=$i+1;
	}
	
	$tabSize = $i-1;
	
	// To protect MySQL injection (more detail about MySQL injection)
	if(!empty($paymentInformation) && $tabSize > 0)
	{
		$customerUsername = mysql_real_escape_string(stripslashes($customerUsername));
		$paymentInformation = mysql_real_escape_string(stripslashes($paymentInformation));
		$OfferCode = mysql_real_escape_string(stripslashes($OfferCode));
		
		for ($i = 0; $i < $tabSize; $i++)
		{
			$productName[$i]=mysql_real_escape_string(stripslashes($productName[$i]));
			$quantity[$i]=mysql_real_escape_string(stripslashes($quantity[$i]));
		}
		
		if(!empty($OfferCode))
		{
			$sql="SELECT offerID FROM offer WHERE code = '$OfferCode' AND startDate <= '$date' AND endDate >= '$date';";
			$resultOffer=mysql_query($sql);
		}
		
		if(empty($OfferCode) || mysql_num_rows($resultOffer) == 1)
		{
			if(!empty($OfferCode))
			{
				$row = mysql_fetch_assoc($resultOffer);
				$offerID=$row["offerID"];
			}
			else{
				$offerID='NULL';
			}
			
			
			if(!empty($customerUsername))
			{
				$sql="SELECT customerID,loyaltyPoints FROM customer WHERE username = '$customerUsername';";
				$resultCustomer=mysql_query($sql);
			}
			
			if(empty($customerUsername) || mysql_num_rows($resultCustomer) == 1)
			{
				if(!empty($customerUsername))
				{
					$row = mysql_fetch_assoc($resultCustomer);
					$customerID=$row["customerID"];
					$loyaltyPoints=$row["loyaltyPoints"];
				} else {
					$customerID='NULL';
				}

				$sql="CALL transactionInsert('$date','$time','$staffUsername',$customerID,'$paymentInformation',$offerID);";
				//echo $sql;
				$result=mysql_query($sql);
				
				$sql="SELECT transactionID FROM transaction WHERE date='$date' AND time='$time' AND staffID=(SELECT staffID FROM staff WHERE staff.username='$staffUsername') AND payementMethodID=(SELECT payementMethodID FROM payementmethod WHERE payementmethod.methodName='$paymentInformation');";
				$result=mysql_query($sql);
				$row = mysql_fetch_assoc($result);
				$transactionID=$row["transactionID"];
				
				if ($transactionID > 0)
				{
					$error = false;
					
					for ($i = 0; $i < $tabSize; $i++)
					{
						$sql="CALL transactionProductInsert('$transactionID','$productName[$i]','$quantity[$i]');";
						$result=mysql_query($sql);
						
						if ($result != true)
							$error = true;
					}
					
					if($error == false)
					{
						$errorCode = 0;
						$errorMessage = "Transaction record with success";
						
						if(!empty($customerUsername) && mysql_num_rows($resultCustomer) == 1)
						{
							//Add loyalty point
							$loyaltyPoints=$loyaltyPoints+10;
							$sql="UPDATE customer SET loyaltyPoints=$loyaltyPoints WHERE customerID=$customerID;";
							mysql_query($sql);
						}
						
					} else {
						//DELETE data already insert
						$sql="DELETE FROM product_transaction WHERE transactionID=$transactionID;";
						$result=mysql_query($sql);
						
						$sql="DELETE FROM transaction WHERE transactionID=$transactionID;";
						$result=mysql_query($sql);
						
						//print error
						$errorCode = 1;
						$errorMessage = "Sorry, an error occurred during transaction recording";
					}
				}
				else
				{
					$errorCode = 1;
					$errorMessage = "Sorry, an error occurred during transaction recording";
				}
			}
			else
			{
				$errorCode = 1;
				$errorMessage = "Error : Customer not found";
			}
		}
		else
		{
			$errorCode = 1;
			$errorMessage = "Error : Offer not found or Date of offer is invalid";
		}
		
		
		mysql_close($db);
	}
	else
	{
		$errorCode = 1;
		$errorMessage = "All input are not informed";
	}
	
	$_SESSION['errorCode'] = $errorCode;
	$_SESSION['errorMessage'] = $errorMessage;
	
	header('Location: manageTransaction.php');
	
} else 
	header("location: index.php"); 
?>

