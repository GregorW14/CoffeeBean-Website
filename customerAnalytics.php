<?php
if(!isset($_SESSION))
{
	@session_start();
} 
if(!empty($_SESSION['loggedin']) && !empty($_SESSION['type']) && $_SESSION['type'] == "executive"){ ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<title>The Brown Bean Cafe</title>
	<link rel="shortcut icon" href="img/coffee_cup_icon.ico">

	<!-- Bootstrap -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/custom.css">
	<script src="js/jquery-2.1.4.js"></script>
	<script src="js/bootstrap.js"></script>
	
	<!-- Custom JavaScript -->
	<script src="js/custom.js"></script>

	<!-- Animated charts -->
	<!-- Source: http://www.highcharts.com/ -->
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
</head>
<body>
	<?PHP
		// Used in graph
		$graphTitle = "Transaction Analytics";
		$yAxis = "Sum of total profits";
		$xAxis = "Present > past";
		$typeOfAnalysis = "All total profits from transactions";
	
		include 'menu.php';
	?>
	
	<div class="container">
		<h1>Customer Analytics</h1>
		
		<!-- Tool bar -->

		<!-- Database -->
		<?PHP
			$servername = "silva.computing.dundee.ac.uk";
			$username = "15ac3u03";
			$password = "ab123c";
			$dbname = "15ac3d03";

			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			
			// Check connection
			if ($conn->connect_error) 
			{
				 die("Connection failed: " . $conn->connect_error);
			} 
			

			$sql = "CALL countCustomers()";
			
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();

			$numberOfLoyaltyCustomer = $row['total'];
			//echo "<h2>Total Loyalty Customers = ". $row['total']. "</h2>";
			
			$conn->close();
		?>  
		
		
				<?PHP echo "<h2>Total Loyalty Customers = $numberOfLoyaltyCustomer</h2>" ?>
				
</div>


</body>
</html>
<?php 
$_SESSION['errorCode']="";
$_SESSION['errorMessage']="";
} else 
	header("location: index.php"); 
?>