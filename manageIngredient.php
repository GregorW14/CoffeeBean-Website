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
</head>
	<body>
		<?PHP
			include 'menu.php';
		?>
		
		<div class="container">
			<div class="breadcrumbs"><a href="index.php">Home</a> > Manage Ingredient</div>
			<br>
			<h1>Manage Ingredients</h1>
			<br>
			
			<?PHP
				if (!empty($_SESSION['errorCode']) && ($_SESSION["errorCode"] == 3 || $_SESSION["errorCode"] == 4)) {
					$activeAddTab="";
					$activeAddContent="tab-pane fade";
					
					$activeAddToRecipeTab="";
					$activeAddToRecipeContent="tab-pane fade";
					
					$activeRemoveRecipeTab="active";
					$activeRemoveFRecipeContent="tab-pane fade in active";
					
					$activeRemoveTab="";
					$activeRemoveContent="tab-pane fade"; 		
				} elseif ($_SESSION["errorCode"] == 6 || $_SESSION["errorCode"] == 7) {
					$activeAddTab="";
					$activeAddContent="tab-pane fade";
					
					$activeAddToRecipeTab="active";
					$activeAddToRecipeContent="tab-pane fade in active";
					
					$activeRemoveRecipeTab="";
					$activeRemoveFRecipeContent="tab-pane fade"; 	
					
					$activeRemoveTab="";
					$activeRemoveContent="tab-pane fade"; 		
				} elseif ($_SESSION["errorCode"] == 9 || $_SESSION["errorCode"] == 10) {
					$activeAddTab="";
					$activeAddContent="tab-pane fade";
					
					$activeAddToRecipeTab="";
					$activeAddToRecipeContent="tab-pane fade";
					
					$activeRemoveRecipeTab="";
					$activeRemoveFRecipeContent="tab-pane fade"; 	
					
					$activeRemoveTab="active";
					$activeRemoveContent="tab-pane fade in active"; 		
				} else {
					$activeAddTab="active";
					$activeAddContent="tab-pane fade in active";
					
					$activeAddToRecipeTab="";
					$activeAddToRecipeContent="tab-pane fade";
					
					$activeRemoveRecipeTab="";
					$activeRemoveFRecipeContent="tab-pane fade";
					
					$activeRemoveTab="";
					$activeRemoveContent="tab-pane fade"; 		
				}
			?>
				
			<ul class="nav nav-tabs">
			  <li class=<?php echo "\"".$activeAddTab."\""; ?>><a data-toggle="tab" href="#add">Add</a></li>
			  <li class=<?php echo "\"".$activeAddToRecipeTab."\""; ?>><a data-toggle="tab" href="#addtoRecipe">Add product to recipe</a></li>
			  <li class=<?php echo "\"".$activeRemoveRecipeTab."\""; ?>><a data-toggle="tab" href="#removeFromRecipe">Remove product from recipe</a></li>
			  <li class=<?php echo "\"".$activeRemoveTab."\""; ?>><a data-toggle="tab" href="#remove">Remove</a></li>
			</ul>
			
			<div class="tab-content">
			  <div id="add" class=<?php echo "\"".$activeAddContent."\""; ?>>
				 <h2>Add Ingredient</h2>
				 
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
			
				<form method="post" action="addIngredient.php">
					<h3>Ingredient Information</h3>
					<p>Name : <input id="name" type="text" name="name" value="" placeholder="Name" class="form-control"></p>
					
					<p id="error"></p>
					<p class="submit"><input type="submit" class="btn-primary form-control"name="commit" value="Add Ingredient"></p>
				</form>
			  </div>
			
			
			
			
			
			<div id="addtoRecipe" class=<?php echo "\"".$activeAddToRecipeContent."\""; ?>>
			  
				<h2>Add product to recipe</h2>

				<?PHP
				if (!empty($_SESSION['errorCode']) && !empty($_SESSION['errorMessage'])) {
				  
				  if($_SESSION['errorCode'] == '6')
				  { ?>
					<div class="alert alert-success col-xs-12">
						<center><strong><?php echo $_SESSION['errorMessage']; ?></strong></center>
					</div>
					  
				  <?php }elseif($_SESSION['errorCode']  == 7){ ?>
					<div class="alert alert-danger col-xs-12">
						<center><strong><?php echo $_SESSION['errorMessage']; ?></strong></center>
					</div>
				
				<?PHP }} ?>
				
				<form method="post" action="addIngredientToRecipe.php">
					<h3>Recipe information</h3>
					<p>Choose the ingredient 
					<select id="nameIng" name="nameIng" class="form-control">
					<?php
							$host="silva.computing.dundee.ac.uk"; // Host name 
							$username="15ac3u03"; // Mysql username 
							$password="ab123c"; // Mysql password 
							$db_name="15ac3d03"; // Database name 

							// Connect to server and select databse.
							$db=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
							mysql_select_db("$db_name")or die("cannot select DB");
							
							$sql = "SELECT name FROM ingredient";
							$res = mysql_query($sql);
							
							while($data=mysql_fetch_array($res)) {
							   echo "<option>".$data["name"]."</option>\n";
							}
							
							// on ferme la connexion à mysql
							mysql_close($db);
						?>
					</select>
					</p>
					<p>Quantity of the ingredient<input id="quantity" type="text" name="quantity" value="" placeholder="Quantity" class="form-control"></p>
					<p>Unit for quantity<input id="unit" type="text" name="unit" value="" placeholder="Unit" class="form-control"></p>
					<p>Choose the product  
					<select id="namePr" name="namePr" class="form-control">
					<?php
							$host="silva.computing.dundee.ac.uk"; // Host name 
							$username="15ac3u03"; // Mysql username 
							$password="ab123c"; // Mysql password 
							$db_name="15ac3d03"; // Database name 

							// Connect to server and select databse.
							$db=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
							mysql_select_db("$db_name")or die("cannot select DB");
							
							$sql = "SELECT name FROM product";
							$res = mysql_query($sql);
							
							while($data=mysql_fetch_array($res)) {
							   echo "<option>".$data["name"]."</option>\n";
							}

							mysql_close($db);
						?>
					</select>
					</p>
					
					<p id="error"></p>
					<p class="submit"><input type="submit" class="btn-primary form-control" name="commit" value="Add To Recipe"></p>
				</form>
			  </div>
			
			
			
			

			<div id="removeFromRecipe" class=<?php echo "\"".$activeRemoveFRecipeContent."\""; ?>>
				<h2>Remove product from recipe</h2>

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
				
				<form method="post" action="removeIngredientFromRecipe.php">
					<h3>Product information</h3>
					<p>Choose the ingredient 
					<select id="nameIng" name="nameIng" class="form-control">
					<?php
							$host="silva.computing.dundee.ac.uk"; // Host name 
							$username="15ac3u03"; // Mysql username 
							$password="ab123c"; // Mysql password 
							$db_name="15ac3d03"; // Database name 

							// Connect to server and select databse.
							$db=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
							mysql_select_db("$db_name")or die("cannot select DB");
							
							$sql = "SELECT name FROM ingredient";
							$res = mysql_query($sql);
							
							while($data=mysql_fetch_array($res)) {
							   echo "<option>".$data["name"]."</option>\n";
							}
							
							// on ferme la connexion à mysql
							mysql_close($db);
						?>
					</select>
					</p>
					<p>Choose the product  
					<select id="namePr" name="namePr" class="form-control">
					<?php
							$host="silva.computing.dundee.ac.uk"; // Host name 
							$username="15ac3u03"; // Mysql username 
							$password="ab123c"; // Mysql password 
							$db_name="15ac3d03"; // Database name 

							// Connect to server and select databse.
							$db=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
							mysql_select_db("$db_name")or die("cannot select DB");
							
							$sql = "SELECT name FROM product";
							$res = mysql_query($sql);
							
							while($data=mysql_fetch_array($res)) {
							   echo "<option>".$data["name"]."</option>\n";
							}

							mysql_close($db);
						?>
					</select>
					</p>

					<p id="error"></p>
					<p class="submit"><input type="submit" class="btn-primary form-control" name="commit" onclick="return confirm('Are you sure');" value="Remove Product"></p>
				</form>
			  </div>
			  
			  
			  
			  
			  
			   <div id="remove" class=<?php echo "\"".$activeRemoveContent."\""; ?>>
				<h2>Remove</h2>

				<?PHP
				if (!empty($_SESSION['errorCode']) && !empty($_SESSION['errorMessage'])) {
				  
				  if($_SESSION['errorCode'] == '9')
				  { ?>
					<div class="alert alert-success col-xs-12">
						<center><strong><?php echo $_SESSION['errorMessage']; ?></strong></center>
					</div>
					  
				  <?php }elseif($_SESSION['errorCode']  == 10){ ?>
					<div class="alert alert-danger col-xs-12">
						<center><strong><?php echo $_SESSION['errorMessage']; ?></strong></center>
					</div>
				
				<?PHP }} ?>
				
				<form method="post" action="removeIngredient.php">
					<h3>Ingredient information</h3>
					<p>Ingredient that aren't in a recipe for a product :
					<select id="name" name="name" class="form-control">
					<?php
							$host="silva.computing.dundee.ac.uk"; // Host name 
							$username="15ac3u03"; // Mysql username 
							$password="ab123c"; // Mysql password 
							$db_name="15ac3d03"; // Database name 

							// Connect to server and select databse.
							$db=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
							mysql_select_db("$db_name")or die("cannot select DB");
							
							$sql = "SELECT name FROM ingredient WHERE ingredientID NOT IN (SELECT ingredientID FROM product_ingredient);";
							$res = mysql_query($sql);
							
							while($data=mysql_fetch_array($res)) {
							   echo "<option>".$data["name"]."</option>\n";
							}
							
							mysql_close($db);
						?>
					</select>
					</p>

					<p id="error"></p>
					<p class="submit"><input type="submit" class="btn-primary form-control" name="commit" onclick="return confirm('Are you sure');" value="Remove Product"></p>
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