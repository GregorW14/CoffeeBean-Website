<?php
if(!isset($_SESSION))
{
	@session_start();
} 
if(!empty($_SESSION['loggedin']) && !empty($_SESSION['type']) &&  $_SESSION['loggedin'] == true && $_SESSION['type'] == "manager" || $_SESSION['type'] == "executive") {?>
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
				var box = document.getElementById('nameFilter');
				box.value = "";
				var box = document.getElementById('emailFilter');
				box.value = "";
			}
		</script>
		<div class="container">
		<h2>Suppliers</h2>
		
		<div class="breadcrumbs"><a href="index.php">Home</a> > Suppliers</div>
		<br>
		<br>
		
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
							Email
							<input name="emailFilter" value="" placeholder="Filter Email" type="email" id="emailFilter">
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
				<th>Supplier Name</th>
				<th>Email Address</th>
			</tr>
			
		<?php 
		if ($_SESSION['loggedin']){
				$host="silva.computing.dundee.ac.uk"; // Host name 
				$username="15ac3u03"; // Mysql username 
				$password="ab123c"; // Mysql password 
				$db_name="15ac3d03"; // Database name 
				//$tbl_name="equipment"; // Table name 
				
				$nameFilter = "%"; //default nameFilter

				// Connect to server and select databse.
				mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
				mysql_select_db("$db_name")or die("cannot select DB");
				

				$sql="SELECT name, emailAddress FROM supplier";
				
				//check if form sort/filter data exists and append to sql statement
				if( isset($_POST['nameFilter'])  && $_POST['nameFilter'] != null ) {
					$sql .= " WHERE name LIKE '%";
					$sql .= $_POST['nameFilter'];
					$sql .= "%'";
				}
				else 
				{
					$sql .= " WHERE name LIKE '%'";
				}
				
				if( isset($_POST['emailFilter'])  && $_POST['emailFilter'] != null ) {
					$sql .= " AND emailAddress =";
					$sql .= "'" . $_POST['emailFilter'] . "'";
				}
				// if( isset($_POST['sortBy']) ) {
					// $sql .= " ORDER BY ";
					// $sql .= $_POST["sortBy"];
				// }
				
				//get result
				$result=mysql_query($sql);
				$count=mysql_num_rows($result);
				
				
				//if rows exist
				if ($count > 0) {
					// output data of each row
					while($row = mysql_fetch_assoc($result)) {
						echo "<tr>";
						echo "<td>" 
							. $row["name"]. "</td> <td>" 
							. $row["emailAddress"] . "</td>";
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
}else
	header("location: index.php");
?>