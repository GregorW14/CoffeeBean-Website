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
		$ShopInfo="";
		if (!empty($_POST)){	
			// username and password sent from form 
			$ShopInfo=$_POST['ShopInfo'];
		}
		?>
		
		<div class="container">
		<h2>Products</h2>
		
		<form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
			<h3>Choose your shop : </h3>
			<select id="ShopInfo" name="ShopInfo" class="form-control">
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
					
					echo "<option>Please select an option...</option>\n";
					
					while($data=mysql_fetch_array($res)) {
						$str=$data["streetName"].",".$data["city"].",".$data["country"];
					    echo "<option";
						if($ShopInfo == $str)
						{
							echo " selected=\"selected\"";
						}
					    echo ">".$str."</option>\n";
					}
					 
					// on ferme la connexion à mysql
					mysql_close($db);
				?>
			</select>
			<br/>
			<input type="submit" class="btn-primary"name="commit" value="Go">
		</form>
		<br>
		
		<?php 
		
		if (!empty($_POST)){
			
			if ($ShopInfo == "Please select an option...") { echo "<h3>Please selection an option from the drop down menu above.</h3>"; exit; }
			
			if(!empty($ShopInfo)) {
				$host="silva.computing.dundee.ac.uk"; // Host name 
				$username="15ac3u03"; // Mysql username 
				$password="ab123c"; // Mysql password 
				$db_name="15ac3d03"; // Database name 

				// Connect to server and select databse.
				$db=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
				mysql_select_db("$db_name")or die("cannot select DB");
				
				// To protect MySQL injection (more detail about MySQL injection)
				$ShopInfo = mysql_real_escape_string(stripslashes($ShopInfo));
				
				$ShopInfos = explode(",", $ShopInfo);

				$sql="SELECT name,price,image,currency FROM productbyshop WHERE streetName='$ShopInfos[0]' AND city='$ShopInfos[1]' AND country='$ShopInfos[2]';";
				$result=mysql_query($sql);
				
				mysql_close($db);
				
				$count=mysql_num_rows($result);

				$fmt = new NumberFormatter( 'en_GB', NumberFormatter::CURRENCY );
				$i=0;
				
				if ($count > 0) {
					while($row = mysql_fetch_assoc($result)) {
						if($i%4==0)
						{
							echo "<div class=\"row\">";
						}
						/*  
						
							<img data-src="holder.js/200x200" class="img-thumbnail" alt="200x200" src=
						
						*/
						echo "<div class=\"col-xs-6 col-md-3\" style=\"padding-top:5px;padding-bottom:10px;\">"
									."<center><img data-src=\"holder.js/200x200\" style=\"padding-top:5px;padding-bottom:10px;\" src=\"".$row["image"]."\" border=\"0\" align=\"center\" width=75%/></center>" 
									."<center><h4><strong>".$row["name"]." : ".$fmt->formatCurrency($row["price"], $row["currency"])."</strong></h4></center>"
								."</div>";
						if(($i+1)%4==0)
						{
							echo "</div>";
						}
						$i=$i+1;
					}
				} else 
				{
					echo "<h3>No results</h3>";
				}
			}
		}
		else
		{
			echo "<h3>Please selection an option from the drop down menu above.</h3>";
		}
		?>
		
		</div>
	</body>
</html>
<?php 
} else 
	header("location: index.php"); 
?>