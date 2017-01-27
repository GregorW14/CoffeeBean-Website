<?php
if(!isset($_SESSION))
{
	@session_start();
} 
if(!empty($_SESSION['loggedin']) && !empty($_SESSION['type']) &&  $_SESSION['loggedin'] == true && $_SESSION['type'] == "manager" || $_SESSION['type'] == "executive" || $_SESSION['type'] == "shopfloorstaffmember"){ ?>
<html>
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
		<?php
			include 'menu.php';
		?>
		
		<script>
			function clearFilters() {
				var box = document.getElementById('idFilter');
				box.value = "";
				var box = document.getElementById('nameFilter');
				box.value = "";
				var box = document.getElementById('priceFilter');
				box.value = "";
				var box = document.getElementById('maintenanceFilter');
				box.value = "";
				var box = document.getElementById('expiryFilter');
				box.value = "";
				var box = document.getElementById('shopIdFilter');
				box.value = "";
			}
		</script>
		<div class="container">
		<h2>Equipment</h2>
		
		<div class="breadcrumbs"><a href="index.php">Home</a> > Equipment</div>
		
		<section class="col-xs-12 table-responsive">
		<table class="table table-bordered table-striped table-condensed">
			<tr>
				<form id="filters" method="POST">
					<td>
						<center>
							Name
							<input name="nameFilter" value="" placeholder="Filter Name" type="text" id="nameFilter">
						</center>
					</td>
					<td>
						<center>
							Price
							<input name="priceFilter" value="" placeholder="Filter Price" type="number" id="priceFilter">
						</center>
					</td>
					<td>
						<center>
							Maintenance Date
							<input name="maintenanceFilter" value="" placeholder="Filter Maintenance Date" type="date" id="maintenanceFilter">
						</center>
					</td>
					<td>
						<center>
							Broken?
							<input name="brokenFilter" value="" placeholder="" type="checkbox" id="brokenFilter">
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
				<th>Equipment Name</th>
				<th>Price</th>
				<th>Maintenance Date</th>
				<th>Broken</th>
				<th>Shop</th>
			</tr>
		
		<?php
			if($_SESSION['loggedin']) {
				
				$host="silva.computing.dundee.ac.uk"; // Host name 
				$username="15ac3u03"; // Mysql username 
				$password="ab123c"; // Mysql password 
				$db_name="15ac3d03"; // Database name 
				//$tbl_name="equipment"; // Table name 
				
				$nameFilter = "%"; //default nameFilter

				// Connect to server and select databse.
				mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
				mysql_select_db("$db_name")or die("cannot select DB");

				//set base sql statement
				$sql = "SELECT name, price, maintenanceDate, broken, shop, currency FROM equipmentview";
				
				//print post data for debugging
				//print_r($_POST);
				
				//check if form sort/filter data exists and append to sql statement
				if( isset($_POST['nameFilter'])  && $_POST['nameFilter'] != null ) {
					$sql .= " WHERE name LIKE '%";
					$sql .= $_POST['nameFilter'];
					$sql .= "%'";
				}
				else {
					$sql .= " WHERE name LIKE '%'";
				}
				
				if( isset($_POST['priceFilter'])  && $_POST['priceFilter'] != null ) {
					$sql .= ' AND price = ';
					$sql .= $_POST['priceFilter'];
				}
				if( isset($_POST['maintenanceFilter'])  && $_POST['maintenanceFilter'] != null ) {
					$sql .= ' AND maintenanceDate = ';
					$maintenanceFilter = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['maintenanceFilter'])));
					echo $maintenanceFilter;
					$sql .= "'";
					$sql .= $maintenanceFilter;
					$sql .= "'";
				}
				if( isset($_POST['brokenFilter'])) {
					$sql .= " AND broken = 1";
				}
				if( isset($_POST['shopFilter'])  && $_POST['shopFilter'] != null ) {
					$sql .= " AND shop LIKE '%";
					$sql .= $_POST['shopFilter'];
					$sql .= "%'";
				}
				
				if( isset($_POST['sortBy']) ) {
					$sql .= ' ORDER BY ';
					$sql .= $_POST["sortBy"];
				}
				
				//print sql statement for debugging
				//echo $sql;
				
				//get result
				$result=mysql_query($sql);
				$count=mysql_num_rows($result);
				
				$fmt = new NumberFormatter( 'en_GB', NumberFormatter::CURRENCY );
				
				//if rows exist
				if ($count > 0) {
					// output data of each row
					while($row = mysql_fetch_assoc($result)) {
						$maintenanceDate = new DateTime($row["maintenanceDate"]);
						if($row["broken"] == 0)
							$broken="false";
						else
							$broken="true";
						
						echo "<tr>";
						echo "<td>" 
							. $row["name"]. "</td><td>" 
							. $fmt->formatCurrency($row["price"], $row["currency"]). "</td><td>" 
							. $maintenanceDate->format('d/m/Y'). "</td><td>" 
							. $broken. "</td><td>" 
							. $row["shop"]. "</td>";
						echo "</tr>";
					}
				} else {
					echo "0 results";
				}
			} else {
				echo "Please log in first";
			}
			?>
			</table></section>
		</div>
	</body>
</html>
<?php 
$_SESSION['errorCode']="";
$_SESSION['errorMessage']="";
} else 
	header("location: index.php"); 
?>