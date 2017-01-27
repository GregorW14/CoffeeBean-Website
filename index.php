<?php
if(!isset($_SESSION))
{
	@session_start();
} ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/landing-page.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<meta charset="utf-8">
	<title>The Brown Bean Caf&eacute;</title>
  <link rel="shortcut icon" href="img/coffee_cup_icon.ico">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link href='https://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="css/custom.css">
  <script src="js/jquery-2.1.4.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/custom.js"></script>
	<script>
$(document).ready(function(){
		$("#div0").fadeIn(1000);
        $("#div1").fadeIn(2000);
        $("#div2").fadeIn(3000);
        $("#div3").fadeIn(4000);
});
</script>
</head>

<body>

   
    <!-- Header -->
    <a name="about"></a>
    <div class="full">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
					<div id="div0" style="display:none;">
						<div class="intro-message landingPageBackgroundColour">

							<div id="div1" style="display:none;"><h1 class="landingPageFont" style="font-size:52px;">The Brown Bean Caf&eacute;</h1></div><br>
							<div id="div2" style="display:none;"><h3 class="cheesyCoffeeQuotes landingPageFont" style="text-align:center; padding-top: 0px; padding-bottom: 0px;margin-top: 0px;" id="message"></h3></div><br>
							
							<div id="div3" style="display:none;">
							<?php if (!empty($_SESSION['loggedin'])): ?>
							
							<hr class="intro-divider">
							  <h2 class="landingPageFont">Welcome <?php echo $_SESSION['username'];?>!</h2>
							  <?php endif; ?>
							  <hr class="intro-divider">
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

			<ul class="list-inline intro-social-buttons">
				<li>
					<a href="stores.php" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Enter site</span></a>
				</li>
			</ul>
				
		<?PHP
	} 
	else
	{
		?>

		<ul class="list-inline intro-social-buttons">
			<li>
				<a href="loginDisplay.php" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Log in</span></a>
			</li>
			<li>
				<a href="register.php" class="btn btn-default btn-lg"><i class="fa fa-github fa-fw"></i> <span class="network-name">Register</span></a>
			</li>
		</ul>
				</div><br>
		<?PHP
		
		//include 'loginDisplay.php';
		
	}
	
  ?>
                    </div>
					</div>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.intro-header -->
	
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
