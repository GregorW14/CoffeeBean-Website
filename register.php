
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
			include 'carousel.html';
		?>
		
		<div class="container">
			 <h2>Register</h2>
			<script src="js/custom.js"></script>
			<div class="register">	
					<form method="post" action="addCustomer.php">
						<?php
							if(isset($_SESSION['registerFail']))
							{?>
							<h3>Registration Failed</h3>
							<?php
							unset($_SESSION['registerFail']);
							}
						?>
						<h3>Customer</h3>
						<p>Name<input id="name" type="text" name="name" value="" placeholder="Name" class="form-control"></p>
						<p>Date of Birth (dd/mm/yyyy)<input id="DOB" type="date" name="DOB" value="" placeholder="Date of Birth (dd/mm/yyyy)" class="form-control"></p>
						<p>Username<input id="username" type="text" name="username" value="" placeholder="Username" class="form-control"></p>
						<p>Password<input id="password" type="password" name="password" value="" placeholder="Password" class="form-control"></p>
						<p>Email<input id="email" type="email" name="email" value="" placeholder="Email" class="form-control"></p>
						
						<p id="error"></p>
						<p class="submit"><input class="btn btn-sm btn-primary" type="submit" name="commit" value="Register"></p>
			</div>
			
			<div class="alert alert-info" role="alert">
				<strong>Already have an account?</strong> Log in here: <a href="loginDisplay.php">Log in</a>
			  </div>
			
		</div>
	</body>
</html>
