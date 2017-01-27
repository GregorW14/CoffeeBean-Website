<?php
if(!isset($_SESSION))
{
	@session_start();
} 
if(!empty($_SESSION['loggedin']) && !empty($_SESSION['type']) &&  $_SESSION['loggedin'] == true && $_SESSION['type'] == "manager" || $_SESSION['type'] == "executive") {?>
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
	<script src="https://code.highcharts.com/modules/data.js"></script>
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
		<h1>Staff Analytics</h1>
		
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
			
			$sql = "SELECT * FROM transactionsbystaff";

			$result = $conn->query($sql);

			if ($result->num_rows > 0) 
			{
				echo "<table id=\"datatable\"  border=\"1\" style=\"width:100%\">";
				$sum = 0;
				$array = array();
				echo "	<thead><tr>
							<th>Staff Name</td> 
							<!--<th>Store Name</th>-->
							<th>Amount Taken</th>
						</tr></thead>
					";
				 
				 while($row = $result->fetch_assoc()) 
				 {
					 echo 	"	
								<tr>
									<td>" . $row["staff_Name"] . "</td> 
									<!--<td>" . $row["shopName"] . "</td>-->
									<td>" . $row["totalAmount"] . "</td>
								</tr>
							";	
					
				 }
				 echo "</table>";
			} else 
			{
				echo "<p>No results.</p>";
			}

			$conn->close();
		?>  
	
	
<div id="container">
			<script>
				$(function () {
					$('#container').highcharts({
						data: {
							table: 'datatable'
						},
						chart: {
							type: 'column'
						},
						title: {
							text: 'Revenue and Profit by Store'
						},
						yAxis: {
							allowDecimals: true,
							title: {
								text: 'Amount (GBP £)'
							}
						}
					});
				});
			</script>
		</div>
		</div>
</body>
</html>
<?php
}else
	header("location: index.php");
?>