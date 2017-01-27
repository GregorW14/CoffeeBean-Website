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
		$graphTitle = "Transaction Analytics";
		$yAxis = "Sum of total profits";
		$xAxis = "Present > past";
		$typeOfAnalysis = "All total profits from transactions";
	
		include 'menu.php';
	?>
	
	<div class="container">
		<h1>Offer Analytics</h1>
		
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
			mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
			mysql_select_db("$db_name")or die("cannot select DB");
			
			$optionArray = array("Today", "Last 3 days", "Last 7 days", "This month", "This year");
			
			$selection="This year";
			if (isset($_POST['formSelectPeriod']))
			{
				$selection=$_POST['formSelectPeriod'];
			}
			
			echo "<p><strong>Displaying:</strong> " . $selection ."</p>";
			switch($selection) {
				case $optionArray[0]:
					$sql = "CALL 15ac3d03.countOfferByDay(\"TODAY\")";
					break;
				case $optionArray[1]:
					$sql = "CALL countOfferByDay(\"LAST3DAYS\")";
					break;
				case $optionArray[2]:
					$sql = "CALL countOfferByDay(\"LAST7DAYS\")";
					break;
				case $optionArray[3]:
					$sql = "CALL countOfferByDay(\"THISMONTH\")";
					break;
				case $optionArray[4]:
					$sql = "CALL countOfferByDay(\"THISYEAR\")";
					break;
				case $optionArray[5]:
					$sql = "CALL countOfferByDay(\"ALLTIME\")";
					break;
				default: echo "Error in selection";
			}
			
			//$sql = "SELECT * FROM 15ac3d03.countoffer";

			$result=mysql_query($sql);
			$count=mysql_num_rows($result);

			if ($count > 0) 
			{
				echo "<table id=\"datatable\" border=\"1\" style=\"width:100%\">";
				echo "	<thead><tr>
							<th>Offer Name</th>
							<th>Times offer used</th>
						</tr></thead><tbody>";
				 
				 while($row = mysql_fetch_assoc($result)) 
				 {
					echo "	
								<tr>
									<td>" . $row["offerName"] . "</td> 
									<td>" . $row["count"] . "</td>
								</tr>";	
				 }
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
					type: 'pie'
				},
				title: {
					text: 'Breakdown of Offers per Transaction'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b>: {point.percentage:.1f} %',
							style: {
								color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
							}
						}
					}
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				}
			});
		});
	</script>
</div>
</body>
</html>
<?php 
$_SESSION['errorCode']="";
$_SESSION['errorMessage']="";
} else 
	header("location: index.php"); 
?>