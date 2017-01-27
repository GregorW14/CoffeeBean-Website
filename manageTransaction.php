<?php
if(!isset($_SESSION))
{
	@session_start();
} 
if(!empty($_SESSION['loggedin']) && !empty($_SESSION['type']) &&  $_SESSION['loggedin'] == true && ($_SESSION['type'] == "manager" || $_SESSION['type'] == "shopfloorstaffmember" || $_SESSION['type'] == "executive" )){ ?>
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
		
		<script>
			var nbDivOrder=0;
			var discount=0;
			
			$(document).ready(function() {
				var $nameRole = $('#nameRole_1');
				
				for (var i = 0; i < product.length; i++) {
					$nameRole.append('<option value="'+ product[i] +'">'+ product[i] +'</option>');
				}
				
				create_champ(1);
				
				document.getElementById('totalPrice').innerHTML = 0;
				document.getElementById('totalCurrency').innerHTML = currency;
				
				document.getElementById('totalPrice2').innerHTML = 0;
				document.getElementById('totalCurrency2').innerHTML = currency;
			});
		
			function create_champ(i) {
			 
				var i2 = i + 1;
				 
				document.getElementById('leschamps_'+i).innerHTML =	'<p class="row" style="margin: 0px 0px 10px 0px;">'+
						'Product : '+
						'<select id="nameRole_'+i+'" name="nameRole_'+i+'" onchange="getPrice('+i+')">'+
							'<option></option>'+
						'</select>'+
						'<span class="col-xs-offset-1">Quantity : <input id="quantity_'+i+'" onchange="getPrice('+i+')" type="number" name="quantity_'+i+'" value="1" placeholder="quantity"></span>'+
						'<span class="col-xs-offset-1">Price : <span id="priceProducts_'+i+'"></span> <span id="currency_'+i+'"></span></span>'+
					'</p>';
				
				document.getElementById('leschamps_'+i).innerHTML += (i <=40 ) ? '<span id="leschamps_'+i2+'"><a href="javascript:create_champ('+i2+')" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> Add product</a></span>' : '';
				
				var $nameRole = $('#nameRole_'+i);
				
				for (var k = 0; k < product.length; k++) {
					$nameRole.append('<option value="'+ product[k] +'">'+ product[k] +'</option>');
				}
				
				document.getElementById('priceProducts_'+i).innerHTML = 0;
				document.getElementById('currency_'+i).innerHTML = currency;
				
				nbDivOrder=nbDivOrder+1;
			 
			}
			function getPrice(k){
				var quantity = document.getElementById('quantity_'+k).value;
				var name = document.getElementById('nameRole_'+k).value;
				
				
				// product price
				document.getElementById('priceProducts_'+k).innerHTML = getPriceByName(name)*quantity;
				document.getElementById('currency_'+k).innerHTML = currency;
				
				
				// total price
				var total = getPriceTotal();
				document.getElementById('totalPrice').innerHTML = total;
				document.getElementById('totalCurrency').innerHTML = currency;
				
				// discount price
				getPriceDiscount(total);
			}
			
			function getPriceByName(name)
			{
				for (var i = 0; i < product.length; i++) {
					if(name == product[i]){ break; }
				}
				
				return price[i];
			}
			
			function getPriceTotal(){			
				var total=0;
				
				for (var j = 1; j <= nbDivOrder; j++) {
					total = total + (getPriceByName(document.getElementById('nameRole_'+j).value) * document.getElementById('quantity_'+j).value);
				}
				
				return total;
			}
			
			function getPriceDiscount(total){			
				document.getElementById('totalPrice2').innerHTML = total-(total*(discount)/100);
				document.getElementById('totalCurrency2').innerHTML = currency;
			}
			
			function getOffer()
			{
				var offer=document.getElementById('OfferCode').value;
				
				$.ajax({
				   url : 'getOffer.php', // La ressource ciblée
				   type : 'GET', // Le type de la requête HTTP.
				   data : 'offerCode=' + offer,
				   success : function(returnData, statut){
						discount = returnData;
						
						getPriceDiscount(getPriceTotal());
					}
				});				
			}
			
			<?php
				$host="silva.computing.dundee.ac.uk"; // Host name 
				$username="15ac3u03"; // Mysql username 
				$password="ab123c"; // Mysql password 
				$db_name="15ac3d03"; // Database name 

				// Connect to server and select databse.
				$db=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
				mysql_select_db("$db_name")or die("cannot select DB");
				
				$staffUsername = $_SESSION['username'];
				
				$sql = "SELECT name,price,currency FROM productbyshop WHERE shopID = (SELECT shopID FROM staff WHERE username='$staffUsername');";
				$res = mysql_query($sql);
				
				?>var product = new Array();<?php
				?>var price = new Array();<?php
				?>var currency;<?php
				
				while($data=mysql_fetch_array($res)) { ?>
					product.push(<?php echo "\"".$data["name"]."\""?>);
					price.push(<?php echo "\"".$data["price"]."\""?>);
					currency=<?php echo "\"".$data["currency"]."\""?>;
				<?php }
				 
				// on ferme la connexion à mysql
				mysql_close($db);
			?>
		</script>
		
		<div class="container">
		
		<div class="breadcrumbs"><a href="index.php">Home</a> > Manage Transaction</div>
			<br>
			<h2>Record Transaction</h2>	
			
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
				
			<form method="post" action="addTransaction.php">
				<h3>Customer information</h3>
				<p><input id="customerUsername" type="text" name="customerUsername" value="" placeholder="customer username" class="form-control"></p>
				
				<h3>Order</h3>
				<fieldset>					
					<span id="leschamps_1"><a href="javascript:create_champ(1)" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> Add product</a></span>
					
					<h4>Total : <span id="totalPrice"></span> <span id="totalCurrency"></span></h4>
				</fieldset>

				<h3>Offer</h3>
				<p>
					<input id="OfferCode" type="text" name="OfferCode" value="" placeholder="offer code" class=""/>
					<span><a onclick="getOffer()" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-refresh"></span> </a></span>
				</p>
				<br>
				<h3><strong>Total with offer : <span id="totalPrice2"></span> <span id="totalCurrency2"></span></strong></h3>
				<br>
				<h3>Payment information</h3>
				<p>Payment method :
					<select id="paymentInformation" name="paymentInformation" class="form-control">
						<?php
							$host="silva.computing.dundee.ac.uk"; // Host name 
							$username="15ac3u03"; // Mysql username 
							$password="ab123c"; // Mysql password 
							$db_name="15ac3d03"; // Database name 

							// Connect to server and select databse.
							$db=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
							mysql_select_db("$db_name")or die("cannot select DB");
							
							$sql = "SELECT methodName FROM payementmethod;";
							$res = mysql_query($sql);
							
							while($data=mysql_fetch_array($res)) {
							   echo "<option>".$data["methodName"]."</option>\n";
							}
							 
							// on ferme la connexion à mysql
							mysql_close($db);
						?>
					</select>
				</p>
				
				<p id="error"></p>
				<p class="submit"><input type="submit" class="btn-primary form-control"name="commit" value="Add Staff Member"></p>
			</form>
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