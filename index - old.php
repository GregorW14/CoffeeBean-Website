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
	include 'carousel.html';
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
		
		?>

			<div class="alert alert-success" role="alert">
				<strong>You're logged in!</strong> Good job.
			  </div>
				
		<?PHP
	} 
	else
	{
		?>

			<div class="alert alert-info" role="alert">
				<strong>You're not logged in!</strong> Log in here: <a href="loginDisplay.php">Log in</a>
				<strong> | Don't have an account?</strong> Register here: <a href="register.php">Register</a>
			  </div>
				
		<?PHP
		
		//include 'loginDisplay.php';
		
	}
	
  ?>
  
</div>
</body>
</html>