<?php
if(!isset($_SESSION))
{
	@session_start();
} 
if(!empty($_SESSION['loggedin']) &&  $_SESSION['loggedin'] == true){ ?>
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
		
		<?php 
			if(isset($_SESSION["ShopInfo"])) {
				$ShopInfos = $_SESSION["ShopInfo"];
				$ShopInfo = $_SESSION["ShopInfo"];
			}
			else {
				if (!empty($_POST)){	
					// username and password sent from form 
					$ShopInfo=$_POST['ShopInfo'];
				}
			}
		?>
		
		<script>
			function clearFilters() {
				var box = document.getElementById('nameFilter');
				box.value = "";
				var box = document.getElementById('priceFilter');
				box.value = "";
			}
		</script>
		<div class="container">
		<h2>Products</h2>
		
		<div class="breadcrumbs"><a href="index.php">Home</a> > Products</div>
		<br>
		<form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
			<h3>Choose your shop : </h3>
			<select id="ShopInfo" name="ShopInfo">
				<?php
					$host="silva.computing.dundee.ac.uk"; // Host name 
					$username="15ac3u03"; // Mysql username 
					$password="ab123c"; // Mysql password 
					$db_name="15ac3d03"; // Database name 
					
					// Connect to server and select databse.
					$db=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
					mysql_select_db("$db_name")or die("cannot select DB");
					
					$sql = "SELECT streetName, city, country FROM stores";
					$res = mysql_query($sql);
					
					//echo "<option>Select an option...</option>\n";
					
					while($data=mysql_fetch_array($res)) {
						$str=$data["streetName"].",".$data["city"].",".$data["country"];
						
					    echo "<option";
					    echo ">".$str."</option>\n";
					}
					 
					// on ferme la connexion à mysql
					mysql_close($db);
				?>
			</select>
			<input type="submit" class="btn-primary"name="commit" value="Go">
		</form>
		<br>
		
		<!--<section class="col-xs-12 table-responsive">
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
							<input name="priceFilter" value="" placeholder="Filter Price" type="number" step="any" id="priceFilter">
						</center>
					</td>	
				</form>
			</tr>
			</table>
			
			<center>
				<button type="submit" form="filters">Submit Filters</button>
				<button onclick='clearFilters()' form="filters">Clear Filters</button>
			</center>-->
			
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
				
				if(!empty($_POST)) {
					//$_POST["ShopInfo"]
					// To protect MySQL injection (more detail about MySQL injection)
					$ShopInfo = mysql_real_escape_string(stripslashes($_POST["ShopInfo"]));
						
					$ShopInfos = explode(",", $ShopInfo);
					
					$_SESSION["ShopInfo"] = $ShopInfos;
				}
				
				if(isset($_SESSION["ShopInfo"]) & !empty($_SESSION["ShopInfo"])) {
					$ShopInfos = $_SESSION["ShopInfo"];
				}
				else if (!empty($_POST)){
					// To protect MySQL injection (more detail about MySQL injection)
					$ShopInfo = mysql_real_escape_string(stripslashes($ShopInfo));
					$ShopInfos = explode(",", $ShopInfo);
					$_SESSION["ShopInfo"] = $ShopInfos;
				}
				else {
					$ShopInfo = "Seagate,Dundee,GB";
					$ShopInfos = explode(",", $ShopInfo);
					$_SESSION["ShopInfo"] = $ShopInfos;
				}
				
				$sql="SELECT name,price,currency,quantity FROM productbyshop WHERE streetName='$ShopInfos[0]' AND city='$ShopInfos[1]' AND country='$ShopInfos[2]'";
				
				//check if form sort/filter data exists and append to sql statement
				if( isset($_POST['nameFilter'])  && $_POST['nameFilter'] != null ) {
					$sql .= " AND name LIKE '%";
					$sql .= $_POST['nameFilter'];
					$sql .= "%'";
				}
				
				if( isset($_POST['priceFilter'])  && $_POST['priceFilter'] != null ) {
					$sql .= ' AND price = ';
					$sql .= $_POST['priceFilter'];
				}
				if( isset($_POST['sortBy']) ) {
					$sql .= ' ORDER BY ';
					$sql .= $_POST["sortBy"];
				}
				
				//get result
				$result=mysql_query($sql);
				$count=mysql_num_rows($result);
				
				$fmt = new NumberFormatter( 'en_GB', NumberFormatter::CURRENCY );
				
				echo "Showing products for " . $ShopInfos[0] . ", " . $ShopInfos[1] . ", " . $ShopInfos[2];
				
				echo "
				<table class='sortable table table-bordered table-striped table-condensed'>
					<tr>
						<th>Product Name</th>
						<th>Price</th>
						<th>Quantity in stock</th>
					</tr>
				";
				
				//if rows exist
				if ($count > 0) {
					// output data of each row
					while($row = mysql_fetch_assoc($result)) {
						echo "<tr>";
						echo "
							<td>" . $row["name"] . "</td>
							<td>" . $fmt->formatCurrency($row["price"], $row["currency"]) . "</td>
							<td>" . $row["quantity"] . "</td>
						</tr>";
					}
				} else {
					echo "0 results";
				}
			//} 
		} else {
			echo "Please log in first";
		}
		?>
			</table></section>
		</div>
	</body>
</html>
<?php 
} else 
	header("location: index.php"); 
?>