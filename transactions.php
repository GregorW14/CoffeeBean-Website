<?php
if(!isset($_SESSION))
{
	@session_start();
} 
if(!empty($_SESSION['loggedin']) && !empty($_SESSION['type']) &&  $_SESSION['loggedin'] == true && $_SESSION['type'] == "manager" || $_SESSION['type'] == "executive" || $_SESSION['type'] == "shopfloorstaffmember") {?>
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
				var box = document.getElementById('Filter');
				box.value = "";
			}
		</script>
		<div class="container">
		<h2>Transactions</h2>
		
		<div class="breadcrumbs"><a href="index.php">Home</a> > Transactions</div>
		<br>
		<br>
		


	</body>
</html>
<?php
}else
	header("location: index.php");
?>