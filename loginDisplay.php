<!DOCTYPE html>
<html lang="en">
<head>
  <title>The Brown Bean Cafe</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/custom.css">
  <script src="js/jquery-2.1.4.js"></script>
  <script src="js/bootstrap.js"></script>

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
	
	<!--<h1>Home page</h1>-->

  <?php
  
	if (isset($_SESSION['loggedin']))
	{
		echo "<h3>You are logged in.</h3>";
		
		//echo "Starting connection ...<br>";
		// CONNECT TO DATABASE - use your own username and password
		$db = mysql_connect("silva.computing.dundee.ac.uk", "15ac3u03","ab123c");
		// SELECT DATABASE - use your own database name
		mysql_select_db("15ac3d03");
		if(!$db){
		echo mysql_error() ;
		}
		else
		{
		//echo "Successfully connected. <br>";
		}
		// CLOSE CONNECTION
		mysql_close($db);
	} 
	else
	{
		//echo "Not logged in";
		
		//echo "<h3>You must be logged in to view this.</h3>";
		?>
		<div class="login">


      <div class="row">
        <div class="col-lg-6">
          <img class="img-circle" src="img/customer.jpg" alt="Generic placeholder image" width="140" height="140">
          
		  <h2>Log in Customer</h2>
				<form method="post" action="loginCustomer.php" onsubmit="return validateCustomerLoginForm()">
					<div class="formHeader"">Please log in in order to access your content.</div>
					
					<div class="formContent">
						<p>Username<input id="usernameC" type="text" name="usernameC" value="" class="form-control" placeholder="Username"></p>
						<p>Password<input id="passwordC" type="password" name="passwordC" value="" class="form-control" placeholder="Password"></p>
						
						<p class="submit"><input class="btn btn-sm btn-primary" type="submit" name="commit" value="Login"></p>
						<p id="errorC">&zwnj;</p>
						<?PHP
						if (isset($_GET["customerLoginFail"]))
						{
							if ($_GET["customerLoginFail"] == true) 
							{ ?>
								<script>document.getElementById("errorC").innerHTML = "Login failed!";</script>
						<?PHP 
							}
						}
						?>
					</div>
				</form>
		</div>
			  
        <div class="col-lg-6">
          <img class="img-circle" src="img/staff.jpg" alt="Generic placeholder image" width="140" height="140">
          
		  <h2>Log in Staff</h2>
				<form method="POST" action="loginStaff.php" onsubmit="return validateStaffLoginForm()">
					<div class="formHeader"">Please log in in order to access your content.</div>
					
					<div class="formContent">		
						<p>Username<input id="usernameS" type="text" name="username" value="" class="form-control" placeholder="Username"></p>
						<p>Password<input id="passwordS" type="password" name="password" value="" class="form-control" placeholder="Password"></p>
						
						<p class="submit"><input class="btn btn-sm btn-primary" type="submit" name="commit" value="Login"></p>
						<p id="errorS">&zwnj;</p>
						
						<?PHP
						if (isset($_GET["staffLoginFail"]))
						{
							if ($_GET["staffLoginFail"] == true) 
							{ ?>
								<script>document.getElementById("errorS").innerHTML = "Login failed!";</script>
						<?PHP 
							}
						}
						?>
					</div>
				</form>
			</div>
      </div><!-- /.row -->
			  
				
			  <div class="alert alert-info" role="alert">
				<strong>Don't have an account?</strong> Register here: <a href="register.php">Register</a>
			  </div>
			  
				
</div>
<?PHP
	}
	
  ?>
  
</div>
</body>
</html>
