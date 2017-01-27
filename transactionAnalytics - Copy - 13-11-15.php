<!DOCTYPE html>
<html lang="en">
<head>
  <title>The Brown Bean Cafe</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/custom.css">
  <script src="js/jquery-2.1.4.js"></script>
  <script src="js/bootstrap.js"></script>
  
  <!--  -->
  <!-- http://www.highcharts.com/ -->
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  
  <link rel="shortcut icon" href="img/coffee_cup_icon.ico">

</head>
<body>
<?PHP
	include 'menu.php';
?>
	
	<script src="js/custom.js"></script>
<!-- <?php
	header("Content-Type: text/html");
	require '/includes/AltoRouter.php';
	$router = new AltoRouter();
	$router->setBasePath('');
	
	/* Setup the URL routing. This is production ready. */
	// Main routes that non-customers see
	$router->map('GET','/', 'home.php', 'home');
	$router->map('GET','/home', 'home.php', 'home-home');
	$router->map('GET','/login', 'login.html', 'login');
	$router->map('GET','/register/', 'register.html', 'register');
	
	/* Match the current request */
	$match = $router->match();
	if($match) {
	  require $match['target'];
	}
	else {
		header("HTTP/1.0 404 Not Found");
		require '404.html';
	}
	
	// match current request
	$match = $router->match();
	?>
	<h1>AltoRouter</h1>

	<h3>Current request: </h3>
	<pre>
		Target: <?php var_dump($match['target']); ?>
		Params: <?php var_dump($match['params']); ?>
		Name: 	<?php var_dump($match['name']); ?>
	</pre> -->


<div class="container">
	
	<h1>Transaction Analytics</h1>
	
	
	<form class="noBackground" action="" method="post">
		Display:
		<select name="formSelectPeriod">
			<option value="Today">Today</option>
			<option value="Last 3 days">Last 3 days</option>
			<option value="Last 7 days">Last 7 days</option>
			<option value="This month">This month</option>
			<option value="This year">This year</option>
		</select>
	
		<input type="submit" value="Update"/>
	</form>

	<?PHP
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
		
		$optionsArray = array(	"Today", 
						"Last 3 days",
						"Last 7 days", 
						"This month", 
						"This year");
		
		$selection="Today";
		if (isset($_POST['formSelectPeriod']))
		{
			$selection=$_POST['formSelectPeriod'];
		}
		
		
		/*
		
			to do: 
			Expenses
		
		*/
		
		// Variables used in table
		
		
		// Variables used in graph
		$graphTitle = "Transaction Analytics";
		$yAxis = "Sum of total profits";
		$typeOfAnalysis = "";
		
		echo "<p><strong>Displaying:</strong> " . $selection ."</p>";
		if ($selection == $optionsArray[0])
		{
			// Today
			$sql = "SELECT * FROM transactionview_today";
		}
		else if ($selection == $optionsArray[1])
		{
			// Last 3 days
			$sql = "SELECT * FROM transactionview_lastthreedays";
		}
		else if ($selection == $optionsArray[2])
		{
			// Last 7 days
			$sql = "SELECT * FROM transactionview_lastsevendays";
		}
		else if ($selection == $optionsArray[3])
		{
			// This month
		}
		else if ($selection == $optionsArray[4])
		{
			// This year
		}

		// $sql = "SELECT * FROM transactionview WHERE customerprofile.username = " . "'" . $_SESSION['username'] . "'";
		//$sql = "SELECT * FROM transactionview";

		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			 // output data of each row
			 
			 /*
			 
			$date=date_create("2013-03-15");
			echo date_format($date,"Y/m/d H:i:s");
			 
			 */
			  
			 echo "<table border=\"1\" style=\"width:100%\">";
			 $sum = 0;
			 
			 $array = array();
			 echo "<thead>
					<tr>
						<td>Date</td> 
						<td>Total profit of transaction</td>
					</tr></thead>
				";
			 
			 $currentDate;
			 $previousDate;
			 $tempSum = 0;
			 while($row = $result->fetch_assoc()) 
			 {
				 // Get current row's date 
				 $currentDate = $row["date"];
				 
				 // If there isn't a previous date, set it to current
				 if (!isset($previousDate)) 
				 {
					$tempSum = $tempSum + $row["totalProfit"];
				 }
				 else
				 {
					 // Compare current date with previous date
					 if ($currentDate == $previousDate)
					 {
						$tempSum = $tempSum + $row["totalProfit"];
					 }
					 else
					 {
						 echo 	"	
								<tr>
									<td>" . $previousDate . "</td> 
									<td>" . $tempSum . "</td>
								</tr>
							";	
							$array[] = $tempSum;
						 
						 $tempSum = 0;
						 $tempSum = $tempSum + $row["totalProfit"];
					 }
				 }
				 $previousDate = $currentDate;
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
		} else {
			echo "<p>No results.</p>";
		}

		$conn->close();


	?>  
	
	<script>
	$(function () {
    $('#chart').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: '<?PHP echo $graphTitle; ?>'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
			
			<?PHP if ($selection == $optionsArray[0])
			{
				// Today
				?>
				categories: ['Today', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-']
				<?PHP
			}
			else if ($selection == $optionsArray[1])
			{
				// Last 3 days
				?>
				categories: ['1', '2', '3', '-', '-', '-', '-', '-', '-', '-', '-', '-']
				<?PHP
			}
			else if ($selection == $optionsArray[2])
			{
				// Last 7 days
				?>
				categories: ['1', '2', '3', '4', '5', '6', '7', '-', '-', '-', '-', '-']
				<?PHP
			}
			else if ($selection == $optionsArray[3])
			{
				// This month
				?>
				categories: ['Week 1', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
				<?PHP
			}
			else if ($selection == $optionsArray[4])
			{
				// This year
				?>
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
				<?PHP
			}	
			?>
            
        },
        yAxis: {
            title: {
                text: '<?PHP echo $yAxis; ?>'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
		series: [{
            name: 'All total profits from transactions',
            data: [
					<?PHP 

						// Date.UTC(2012, 2,     6,   1)
						// ------->(year, month, day, seperator)
						// echo substr("Hello world",6);
						// 2015-11-12
						for ($x = 0; $x <= sizeof($array)-1; $x++) 
						{
						echo "[" . $array[$x] . "],";
						} 
						echo "[" . $array[sizeof($array)-1] . "]";

					?>	
				  ]
        }]
		<?PHP $counter = 0; ?>
        // series: [{
            // name: 'Tokyo',
            // data: [
						// <?PHP 
					
							// Date.UTC(2012, 2,     6,   1)
							// ------->(year, month, day, seperator)
							// echo substr("Hello world",6);
							// 2015-11-12
							// for ($x = 0; $x <= sizeof($array)-1; $x++) 
							// {
							   // echo "[" . $array[$x] . "],";
							// } 
							// echo "[" . $array[sizeof($array)-1][0] . "," . $array[sizeof($array)-1][1] . "]";
						
						// ?>	
				  // ]
    });
});
	</script>
  
</div>
</body>
</html>