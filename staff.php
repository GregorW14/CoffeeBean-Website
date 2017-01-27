<?php
if(!isset($_SESSION))
{
	@session_start();
} 
if(!empty($_SESSION['loggedin']) && !empty($_SESSION['type']) &&  $_SESSION['loggedin'] == true && $_SESSION['type'] == "manager" || $_SESSION['type'] == "executive"){ ?>
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
		
	<div class="container">
			 <h2>Staff</h2>
			 <div class="breadcrumbs"><a href="index.php">Home</a> > Staff</div>
			 
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
							Date of Birth
							<input name="dobFilter" value="" placeholder="" type="date" id="dobFilter">
						</center>
					</td>
					<td>
						<center>
							Employment Start
							<input name="startFilter" value="" placeholder="" type="date" id="startFilter">
						</center>
					</td>
					<td>
						<center>
							Contract Length
							<input name="lengthFilter" value="" placeholder="Filter Contract Length" type="number" id="lengthFilter">
						</center>
					</td>
					</tr>
					<tr>
					<td>
						<center>
							Staff Role
							<input name="roleFilter" value="" placeholder="Filter Staff Role" type="text" id="roleFilter">
						</center>
					</td>	
					<td>
						<center>
							Salary
							<input name="salaryFilter" value="" placeholder="Filter Salary" type="number" id="salaryFilter">
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
				<th>Name</th>
				<th>Date of Birth</th>
				<th>Employment Start</th>
				<th>Contract Length (months)</th>
				<th>Employment End</th>
				<th>Staff Role</th>
				<th>Salary</th>
			</tr>
		
			<?php
				$host = "silva.computing.dundee.ac.uk";
				$username = "15ac3u03";
				$password = "ab123c";
				$db_name = "15ac3d03";

				// Create connection
				//$conn = new mysqli($servername, $username, $password, $dbname);
				mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
				mysql_select_db("$db_name")or die("cannot select DB");

				$sql = "SELECT name, DOB, employmentStartDate, contractLength, title, salary, currency FROM staffmembers";
				$DOB='0000-00-00';
                $startDate='0000-00-00';
                $name='NULL';
                $length='NULL';
                $role='NULL';
                $salary='NULL';
                $shopID='NULL';
				
				if( isset($_POST['nameFilter'])  && $_POST['nameFilter'] != null ) {
					$sql .= " WHERE name LIKE '%";
					$sql .= $_POST['nameFilter'];
					$sql .= "%'";
				}
				else 
				{
					$sql .= " WHERE name LIKE '%'";
				}
				if( isset($_POST['dobFilter'])  && $_POST['dobFilter'] != null ) {
					$sql .= " AND DOB LIKE '%";
					$sql .= $_POST['dobFilter'];
					$sql .= "%'";
				}
				if( isset($_POST['startFilter'])  && $_POST['startFilter'] != null ) {
					$sql .= " AND employmentStartDate LIKE '%";
					$sql .= $_POST['startFilter'];
					$sql .= "%'";
				}
				if( isset($_POST['lengthFilter'])  && $_POST['lengthFilter'] != null ) {
					$sql .= " AND contractLength =";
					$sql .= $_POST['lengthFilter'];
				}
				if( isset($_POST['roleFilter'])  && $_POST['roleFilter'] != null ) {
					$sql .= " AND title LIKE '%";
					$sql .= $_POST['roleFilter'];
					$sql .= "%'";
				}
				if( isset($_POST['salaryFilter'])  && $_POST['salaryFilter'] != null ) {
					$sql .= " AND salary =";
					$sql .= $_POST['salaryFilter'];
				}
				//$sql = "SELECT name, DOB, employmentStartDate, contractLength, shopid, title, salary, currency FROM staffmembers";
				
				//$sql = "CALL viewStaff('$name','$DOB','$startDate',$length,'$role',$salary,$shopID)";
				$result=mysql_query($sql);
				$count=mysql_num_rows($result);
				//$result = $conn->query($sql);

				$fmt = new NumberFormatter( 'en_GB', NumberFormatter::CURRENCY );
				
				if ($count > 0) {
					 // output data of each row
						 
					while($row = mysql_fetch_assoc($result)) {
						$DOB = new DateTime($row["DOB"]);
						$startDate = new DateTime($row["employmentStartDate"]);
						$endDate = new DateTime($row["employmentStartDate"]);
						$endDate->add(new DateInterval('P'.$row["contractLength"].'M'));
						 
						 echo "<tr>
									<td>" . $row["name"] . "</td>
									<td>" . $DOB->format('d/m/Y') . "</td>
									<td>" . $startDate->format('d/m/Y') . "</td>
									<td>" . $row["contractLength"] . "</td>
									<td>" . $endDate->format('d/m/Y') . "</td>
									<td>" . $row["title"] . "</td>
									<td>" . $fmt->formatCurrency($row["salary"], $row["currency"]) . "</td>
								</tr>";
						 
					}
				} else {
					echo "0 results";
				}
					
				mysql_close();	
			?>
			</table></section>		
		</div>	
	</body>
</html>
<?php
}else
	header("location: index.php");
?>