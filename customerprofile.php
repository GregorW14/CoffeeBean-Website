<?php
if(!isset($_SESSION))
{
	@session_start();
} 
if(!empty($_SESSION['loggedin']) && !empty($_SESSION['type']) &&  $_SESSION['loggedin'] == true && $_SESSION['type'] == "customer"){ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>The Brown Bean Cafe</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link href='https://fonts.googleapis.com/css?family=Architects+Daughter|Permanent+Marker' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="css/custom.css">
  <script src="js/jquery-2.1.4.js"></script>
  <script src="js/bootstrap.js"></script>
  
  <link rel="shortcut icon" href="img/coffee_cup_icon.ico">
  
</head>
	<body>
		<?PHP
			include 'menu.php';
		?>
		
		<div class="container">
			

					<h2>My profile</h2>
						<form method="" action="" onsubmit="">
							
							<div class="formContent">
							
								
          
							
								<?php
									$servername = "silva.computing.dundee.ac.uk";
									$username = "15ac3u03";
									$password = "ab123c";
									$dbname = "15ac3d03";

									// Create connection
									$conn = new mysqli($servername, $username, $password, $dbname);
									// Check connection
									if ($conn->connect_error) {
										 die("Connection failed: " . $conn->connect_error);
									} 

									$sql = "SELECT * FROM customerprofile WHERE customerprofile.username = " . "'" . $_SESSION['username'] . "'";
									
									$result = $conn->query($sql);

									if ($result->num_rows > 0) {
										 // output data of each row
										 
										 /*
										 
										$date=date_create("2013-03-15");
										echo date_format($date,"Y/m/d H:i:s");
										 
										 */
										 while($row = $result->fetch_assoc()) 
										 {
											$DOBDate=date_create($row["DOB"]);
											$registeredDate=date_create($row["customerStartDate"]);
											 
											 echo "	
													
													
													<div id=\"customerProfileContainer\">
														<img id=\"customerProfileImage\" src=\"img/blackboard.jpg\" alt=\"Generic placeholder image\">
														<p id=\"customerProfileText\">
														
															
																Hey " . $row["name"] . ", you have " . $row["loyaltyPoints"] ." loyalty points. <br/> <br/>
																Date of birth: " . date_format($DOBDate,"d/m/Y") . " <br/>
																Registered: " . date_format($registeredDate,"d/m/Y") . " <br/>
																Username: " . $row["username"] . " <br/>
														</p>
														<p id=\"customerProfileTextNotWhite\">You gain 10 loyalty points for every purchase you make.</p>
													</div>";	
										 }
									} else {
										 echo "0 results";
									}
									
									$conn->close();
									
									
								?>  
								
							</div>
							
						</form>
			
				
	</body>
</html>
<?php } else 
	header("location: index.php"); 
?>