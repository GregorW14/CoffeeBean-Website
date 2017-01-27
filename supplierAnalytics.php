<?php
if(!isset($_SESSION))
{
	@session_start();
} 
if(!empty($_SESSION['loggedin']) && !empty($_SESSION['type']) &&  $_SESSION['loggedin'] == true && $_SESSION['type'] == "executive") {?>
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
		<h1>Supplier Analytics</h1>
		
		<!-- Tool bar -->
		<form class="noBackground" action="" method="post">
			Display:
			<select name="formSelectPeriod">
				<option value="This year">This year</option>
				<option value="This month">This month</option>
				<option value="Last 7 days">Last 7 days</option>
				<option value="Last 3 days">Last 3 days</option>
				<option value="Today">Today</option>
				
				
				
				
			</select>
			<input type="submit" value="Update"/>
		</form>

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
			
			$optionArray = array("Today", "Last 3 days", "Last 7 days", "This month", "This year");
			
			$selection="This year";
			if (isset($_POST['formSelectPeriod']))
			{
				$selection=$_POST['formSelectPeriod'];
			}
			
			echo "<p><strong>Displaying:</strong> " . $selection ."</p>";
			if ($selection == $optionArray[0])
			{
				// Today
				$sql = "CALL transactionAnalytics(\"TODAY\")";
			}
			else if ($selection == $optionArray[1])
			{
				// Last 3 days
				$sql = "CALL transactionAnalytics(\"LAST3DAYS\")";
			}
			else if ($selection == $optionArray[2])
			{
				// Last 7 days
				$sql = "CALL transactionAnalytics(\"LAST7DAYS\")";
			}
			else if ($selection == $optionArray[3])
			{
				// This month
				$sql = "CALL transactionAnalytics(\"THISMONTH\")";
			}
			else if ($selection == $optionArray[4])
			{
				// This year
				$sql = "CALL transactionAnalytics(\"THISYEAR\")";
			}

			$result = $conn->query($sql);

			if ($result->num_rows > 0) 
			{
				echo "<table border=\"1\" style=\"width:100%\">";
				$sum = 0;
				$array = array();
				echo "	<thead><tr>
							<td>Date</td> 
							<td>Total profit from transactions for that day</td>
						</tr></thead>
					";
				 
				 while($row = $result->fetch_assoc()) 
				 {
					 $sum = $sum + $row["totalProfit"];
					 $date=date_create($row["date"]);
					 echo 	"	
								<tr>
									<td>" . date_format($date,"d/m/Y") . "</td> 
									<td>" . $row["totalProfit"] . "</td>
								</tr>
							";	
							$array[] = $row["totalProfit"];
					
				 }
				 
				 echo "<thead>
						<tr>
							<td>Sum total</td> 
							<td>" . $sum . "</td>
						</tr></thead>
					";
				 echo "</table>";
				 ?> 
					

					<div id="chart" style="min-width: 310px; height: 400px; max-width: 800px; margin: 0 auto"></div>
				 
				 <?PHP
			} else 
			{
				echo "<p>No results.</p>";
			}

			$conn->close();
		?>  
	
</div>
</body>
</html>
<?php
}else
	header("location: index.php");
?>