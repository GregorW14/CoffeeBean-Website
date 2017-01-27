<?php
	if(!isset($_SESSION))
	{
		@session_start();
	} 
	if(!empty($_SESSION['loggedin']) &&  $_SESSION['loggedin'] == true) {
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  <title>The Brown Bean Cafe</title>
	  <meta charset="utf-8">
	  <link rel="stylesheet" href="css/bootstrap.css">
	  <link href='https://fonts.googleapis.com/css?family=Rock+Salt|Shadows+Into+Light+Two' rel='stylesheet' type='text/css'>
	  <link rel="stylesheet" href="css/custom.css">
	  <script src="js/jquery-2.1.4.js"></script>
	  <script src="js/bootstrap.js"></script>
	  
	  <link rel="shortcut icon" href="img/coffee_cup_icon.ico">

		<!-- Using Javascript library Sorttable from http://www.kryogenix.org/code/browser/sorttable/ -->
		<script src="includes/sorttable.js"></script>
	</head>
	<body>
		<?PHP
			include 'menu.php';
		?>
		
		<script>
			function clearFilters() {
				var box = document.getElementById('streetFilter');
				box.value = "";
				var box = document.getElementById('cityFilter');
				box.value = "";
				var box = document.getElementById('countryFilter');
				box.value = "";
			}
		</script>
		
		<div class="container">

			 <h2>Stores</h2>
			 
			 <section class="col-xs-12 table-responsive">
		<table class="table table-bordered table-striped table-condensed">
			<tr>
				<form id="filters" method="POST">
					<td>
						<center>
							Street Name
							<input name="streetFilter" value="" placeholder="Filter Street Name" type="text" id="Street Filter">
						</center>
					</td>
					<td>
						<center>
							City
							<input name="cityFilter" value="" placeholder="Filter City" type="text" id="cityFilter">
						</center>
					</td>
					<td>
						<center>
							Country
							<input name="countryFilter" value="" placeholder="Filter Country" type="text" id="countryFilter">
						</center>
					</td>					
				</form>
			</tr>
			</table>
			
			<center>
				<button type="submit" form="filters">Submit Filters</button>
				<button onclick='clearFilters()' form="filters">Clear Filters</button>
			</center>
			
			<table class="sortable table table-bordered table-striped table-condensed">
			<tr>
				<th>Street Name</th>
				<th>City</th>
				<th>Country</th>
			</tr>
			<?php
				$host = "silva.computing.dundee.ac.uk";
				$username = "15ac3u03";
				$password = "ab123c";
				$db_name = "15ac3d03";

				// Create connection
				mysql_connect("$host", "$username", "$password")or die("cannot connect");
				mysql_select_db("$db_name")or die("cannot select DB");
				//$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				//if ($conn->connect_error) {
				//	 die("Connection failed: " . $conn->connect_error);
				//} 

				//set base sql statement
				$sql = "SELECT streetName, city, country, shopID, currency FROM stores";
					
				//check if form sort/filter data exists and append to sql statement
				if( isset($_POST['streetFilter'])  && $_POST['streetFilter'] != null ) {
					$sql .= " WHERE streetName LIKE '%";
					$sql .= $_POST['streetFilter'];
					$sql .= "%'";
				}
				else {
					$sql .= " WHERE streetName LIKE '%'";
				}
				if( isset($_POST['cityFilter'])  && $_POST['cityFilter'] != null ) {
				$sql .= " AND city LIKE '%";
				$sql .= $_POST['cityFilter'];
				$sql .= "%'";
				}
				if( isset($_POST['countryFilter'])  && $_POST['countryFilter'] != null ) {
					$sql .= " AND country LIKE '%";
					$sql .= $_POST['countryFilter'];
					$sql .= "%'";
				}
				
				//echo $sql;
				//$result = $conn->query($sql);
				$result=mysql_query($sql);
				$count=mysql_num_rows($result);

				$fmt = new NumberFormatter( 'en_GB', NumberFormatter::CURRENCY );
					
				if ($count > 0) {
					// output data of each row
					//while($row = $result->fetch_assoc()) {
					while($row = mysql_fetch_assoc($result)) {
						 echo "<tr>
									<td>" . $row["streetName"] . "</td>
									<td>" . $row["city"] . "</td>
									<td>" . $row["country"] . "</td>
								</tr>";
						 
					}
					echo "</tbody></table></section>";
					} else {
						 echo "0 results";
					}
					
					mysql_close();
				?>  
				<br><br>
				<iframe align="center" width="100%" height="400px;" src="map.php"></iframe>
		</div>
	</body>
</html>
<?php
		}else
			header("location: index.php");
	?>