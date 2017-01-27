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
	<script src="https://code.highcharts.com/modules/data.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
</head>
<body>
	<?PHP
/* 		// Used in graph
		$graphTitle = "Transaction Analytics";
		$yAxis = "Sum of total profits";
		$xAxis = "Present > past";
		$typeOfAnalysis = "All total profits from transactions";
	 */
		include 'menu.php';
	?>
	
	<div class="container">
		<h1>Transaction Analytics</h1>
		
		<!-- Tool bar -->
		<form class="noBackground" action="" method="post">
			Display:
			<select name="formSelectPeriod">
				<option value="All time">Since the beginning of time</option>
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
					$sql = "CALL 15ac3d03.transactionAnalytics(\"TODAY\")";
					break;
				case $optionArray[1]:
					$sql = "CALL transactionAnalytics(\"LAST3DAYS\")";
					break;
				case $optionArray[2]:
					$sql = "CALL transactionAnalytics(\"LAST7DAYS\")";
					break;
				case $optionArray[3]:
					$sql = "CALL transactionAnalytics(\"THISMONTH\")";
					break;
				case $optionArray[4]:
					$sql = "CALL transactionAnalytics(\"THISYEAR\")";
					break;
				case $optionArray[5]:
					$sql = "CALL transactionAnalytics(\"ALLTIME\")";
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
				$array = array();
				echo "	<thead><tr>
							<th>Date</th> 
							<th>Revenue</th>
							<th>Cost</th>
							<th>Profit</th>
						</tr></thead><tbody>
					";
				 
				 while($row = mysql_fetch_assoc($result)) 
				 {
					 $sumRevenue = $sumRevenue + $row["totalAmount"];
					 $sumCost = $sumCost + $row["totalCost"];
					 $sumProfit = $sumProfit + $row["totalProfit"];
					 $date=date_create($row["date"]);
					 echo 	"	
								<tr>
									<th>" . date_format($date,"d/m/Y") . "</th> 
									<td>" . $row["totalAmount"] . "</td>
									<td>" . $row["totalCost"] . "</td>
									<td>" . $row["totalProfit"] . "</td>
								</tr>
							";	
							$array[] = $row["totalProfit"];
					
				 }
				 
				 // echo "</tbody><thead>
						// <tr>
							// <td>Sum totals</td> 
							// <td>" . $fmt->formatCurrency($sumRevenue, "GBP") . "</td>
							// <td>" . $fmt->formatCurrency($sumCost, "GBP") . "</td>
							// <td>" . $fmt->formatCurrency($sumProfit, "GBP") . "</td>
						// </tr></thead>
					// ";
				  echo "</tbody></table>";
			} else 
			{
				echo "<p>No results.</p>";
			}

			mysql_close();
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
					text: 'Revenue and Profit by Day'
				},
				xAxis: {
					type: 'datetime'
				},
				plotOptions: {
					series: {
						pointInterval: 24 * 3600 * 1000 // one day
					}
				},
				yAxis: {
					allowDecimals: true,
					title: {
						text: 'Amount (GBP £)'
					}
				},
				tooltip: {
					formatter: function () {
						return '<b>' + this.series.name + '</b><br/>' +
							this.point.y + ' ' + this.point.name.toLowerCase();
					}
				}
			});
		});
	</script>
</div>
</body>
</html>
<?php
}else
	header("location: index.php");
?>