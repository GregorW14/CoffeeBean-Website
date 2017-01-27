<?php
if(!isset($_SESSION))
{
	@session_start();
} 
if(!empty($_SESSION['loggedin']) && !empty($_SESSION['type']) &&  $_SESSION['loggedin'] == true && $_SESSION['type'] == "manager" || $_SESSION['type'] == "executive"){ ?>
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
		$graphTitle = "Product Analytics";
		$yAxis = "";
		$xAxis = "";
		$typeOfAnalysis = "";
	
		include 'menu.php';
	?>
	
	<div class="container">
		<h1>Product Analytics</h1>
		
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
			$host = "silva.computing.dundee.ac.uk";
			$username = "15ac3u03";
			$password = "ab123c";
			$db_name = "15ac3d03";

			// Create connection
			//$conn = new mysqli($servername, $username, $password, $dbname);
			mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
			mysql_select_db("$db_name")or die("cannot select DB");
			
			$optionArray = array("Today", "Last 3 days", "Last 7 days", "This month", "This year", "All time");
			
			$selection="This year";
			if (isset($_POST['formSelectPeriod']))
			{
				$selection=$_POST['formSelectPeriod'];
			}
			else {
				$selection=$optionArray[2];
			}
			
			echo "<p><strong>Displaying:</strong> " . $selection ."</p>";
			switch($selection) {
				case $optionArray[0]:
					$sql = "CALL productAnalytics(\"TODAY\")";
					break;
				case $optionArray[1]:
					$sql = "CALL productAnalytics(\"LAST3DAYS\")";
					break;
				case $optionArray[2]:
					$sql = "CALL productAnalytics(\"LAST7DAYS\")";
					break;
				case $optionArray[3]:
					$sql = "CALL productAnalytics(\"THISMONTH\")";
					break;
				case $optionArray[4]:
					$sql = "CALL productAnalytics(\"THISYEAR\")";
					break;
				case $optionArray[5]:
					$sql = "CALL productAnalytics(\"ALLTIME\")";
					break;
				default: echo "Error in selection";
			}


			$result=mysql_query($sql);
			$count=mysql_num_rows($result);

			$fmt = new NumberFormatter( 'en_GB', NumberFormatter::CURRENCY );
			
			if ($count > 0) 
			{
				echo "<table id=\"datatable\"  border=\"1\" style=\"width:100%\">";
				$sumRevenue = 0;
				$sumProfit = 0;
				$sumCost = 0;
				$sumTotalSold = 0;
				$array = array();
				echo "	<thead><tr>
							<th>Product</th> 
							<th>Revenue</th>
							<th>Cost</th>
							<th>Profit</th>
							<th>Total Sold</th>
						</tr></thead><tbody>
					";
				 
				 while($row = mysql_fetch_assoc($result)) 
				 {
					 $sumRevenue = $sumRevenue + $row["Income"];
					 $sumCost = $sumCost + $row["Outgoings"];
					 $sumProfit = $sumProfit + $row["Profits"];
					 $sumTotalSold = $sumTotalSold + $row["Total_Sold"];
					 echo 	"	
								<tr>
									<th>" . $row["Product_Name"] . "</th> 
									<td>" . $row["Income"] . "</td>
									<td>" . $row["Outgoings"] . "</td>
									<td>" . $row["Profits"] . "</td>
									<td>" . $row["Total_Sold"] . "</td>
								</tr>
							";	
							$array[] = $row["Profits"];
					
				 }
				 
				 echo "</tbody></table>";
			} else 
			{
				echo "<p>No results.</p>";
			}

			mysql_close();
				 ?> 
					<div id="chart" style="min-width: 310px; height: 400px; max-width: 800px; margin: 0 auto"></div>
	<div id="chart">
			<script>
				$(function () {
					$('#chart').highcharts({
						data: {
							table: 'datatable'
						},
						chart: {
							type: 'column'
						},
						title: {
							text: 'Product Revenue, Cost, Profit & Total Sold'
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
$_SESSION['errorCode']="";
$_SESSION['errorMessage']="";
} else 
	header("location: index.php"); 
?>