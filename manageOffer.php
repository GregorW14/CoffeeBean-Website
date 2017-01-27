<?php
if(!isset($_SESSION))
{
	@session_start();
} 
if(!empty($_SESSION['loggedin']) && !empty($_SESSION['type']) &&  $_SESSION['loggedin'] == true && $_SESSION['type'] == "executive"){ ?>
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
</head>
	<body>
		<?PHP
			include 'menu.php';
		?>
		
		<div class="container">
			<div class="breadcrumbs"><a href="index.php">Home</a> > Manage Offer</div>
			<br>
			<h1>Manage Offers</h1>
			<br>
		
			<?PHP
				if (!empty($_SESSION['errorCode']) && ($_SESSION["errorCode"] == 3 || $_SESSION["errorCode"] == 4)) {
					$activeAddTab="";
					$activeAddContent="tab-pane fade";
					$activeRemoveTab="active";
					$activeRemoveContent="tab-pane fade in active";
				} else {
					$activeAddTab="active";
					$activeAddContent="tab-pane fade in active";
					$activeRemoveTab="";
					$activeRemoveContent="tab-pane fade";
				}
				?>
				
			<ul class="nav nav-tabs">
			  <li class=<?php echo "\"".$activeAddTab."\""; ?> ><a data-toggle="tab" href="#add">Add</a></li>
			  <li class=<?php echo "\"".$activeRemoveTab."\""; ?> ><a data-toggle="tab" href="#remove">Remove</a></li>
			</ul>
		
			<div class="tab-content">
				<div id="add" class=<?php echo "\"".$activeAddContent."\""; ?>>
					<h2>Add offer</h2>
					
					<?PHP
						if (!empty($_SESSION['errorMessage'])) {

						  if($_SESSION['errorCode'] == 0)
						  { ?>
							<div class="alert alert-success col-xs-12">
								<center><strong><?php echo $_SESSION['errorMessage']; ?></strong></center>
							</div>
							  
						  <?php }elseif($_SESSION['errorCode'] == 1){ ?>
							<div class="alert alert-danger col-xs-12">
								<center><strong><?php echo $_SESSION['errorMessage']; ?></strong></center>
							</div>
						
					<?PHP }} ?>
				
					<form method="post" action="addoffer.php">
						<h3>Offer</h3>
						<p>Name<input id="name" type="text" name="name" value="" placeholder="Name" class="form-control"></p>
						<p>Description<input id="description" type="text" name="description" value="" placeholder="Description" class="form-control"></p>
						<p>Discount (%)<input id="discount" type="text" name="discount" value="" placeholder="Discount (%)" class="form-control"></p>
						<p>Start date<input id="startDate" type="date" name="startDate" value="" placeholder="Start Date (dd/mm/yyyy)" class="form-control"></p>
						<p>End date<input id="endDate" type="date" name="endDate" value="" placeholder="End Date (dd/mm/yyyy)" class="form-control"></p>
						
						<p id="error"></p>
						<p class="submit"><input type="submit" class="btn-primary form-control"name="commit" value="Add offer"></p>
					</form>
				</div>
				
				<div id="remove" class=<?php echo "\"".$activeRemoveContent."\""; ?>>
				<h2>Remove staff</h2>

				<?PHP
				if (!empty($_SESSION['errorCode']) && !empty($_SESSION['errorMessage'])) {
				  
				  if($_SESSION['errorCode'] == '3')
				  { ?>
					<div class="alert alert-success col-xs-12">
						<center><strong><?php echo $_SESSION['errorMessage']; ?></strong></center>
					</div>
					  
				  <?php }elseif($_SESSION['errorCode']  == 4){ ?>
					<div class="alert alert-danger col-xs-12">
						<center><strong><?php echo $_SESSION['errorMessage']; ?></strong></center>
					</div>
				
				<?PHP }} ?>
				
				<form method="post" action="removeOffer.php">
					<h3>Staff information</h3>
					<p>Offer
						<select id="offer" name="offer" class="form-control">
							<?php
								$host="silva.computing.dundee.ac.uk"; // Host name 
								$username="15ac3u03"; // Mysql username 
								$password="ab123c"; // Mysql password 
								$db_name="15ac3d03"; // Database name 

								// Connect to server and select databse.
								$db=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
								mysql_select_db("$db_name")or die("cannot select DB");
								
								$sql = "SELECT name FROM offer ORDER BY name";
								$res = mysql_query($sql);
								
								while($data=mysql_fetch_array($res)) {
								   echo "<option>".$data["name"]."</option>\n";
								}
								 
								// on ferme la connexion à mysql
								mysql_close($db);
							?>
						</select>
					</p>
					<p id="error"></p>
					<p class="submit"><input type="submit" class="btn-primary form-control" name="commit" onclick="return confirm('Are you sure you would like to remove this offer?');" value="Remove offer"></p>
				</form>
			  </div>
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