<div id="custom-bootstrap-menu" class="navbar navbar-default " role="navigation">
    <div class="container-fluid">
        <div class="navbar-header"><a class="navbar-brand" href="">The Brown Bean Cafe</a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-menubuilder"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
            </button>
        </div>
		<!-- Fixed navbar -->
		<nav class="navbar navbar-inverse navbar-fixed-top">
		  <div class="container">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="index.php"><font color="#0A0AAA">The Brown </font><font color="white">Bean </font><font color="#CD0000">Café</font></a>
			</div>
			<div id="navbar" class="navbar-collapse collapse" >
			  <ul class="nav navbar-nav">
				
				  <?PHP
					if(!isset($_SESSION))
					{
						@session_start();
					} 
					if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != '')) { ?>
						<li><a href = "loginDisplay.php">Log in</a></li>
						<li><a href = "register.php">Register</a></li>
					<?PHP
					}
					elseif ($_SESSION['type'] == 'executive'){ ?>
						
						<li class="dropdown">
						  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">View<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li class="backgroundColour"><a href="staff.php">Staff</a></li>
								<li class="backgroundColour"><a href="stores.php">Stores</a></li>
								<li class="backgroundColour"><a href="offers.php">Offers</a></li>
								<li class="backgroundColour"><a href="equipment.php">Equipment</a></li>
								<li class="backgroundColour"><a href="products.php">Products</a></li>
								<!--<li class="backgroundColour"><a href="ingredients.php">Ingredidents</a></li>-->
								<li class="backgroundColour"><a href="suppliers.php">Suppliers</a></li>
								<li class="backgroundColour"><a href="customers.php">Customers</a></li>

							</ul></li>
							
							<li class="dropdown">
						  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Manage<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li class="backgroundColour"><a href="manageStaff.php">Staff</a></li>
								<li class="backgroundColour"><a href="manageStore.php">Stores</a></li>
								<li class="backgroundColour"><a href="manageOffer.php">Offers</a></li>
								<li class="backgroundColour"><a href="manageEquipment.php">Equipment</a></li>
								<li class="backgroundColour"><a href="manageProduct.php">Products</a></li>
								<li class="backgroundColour"><a href="manageIngredient.php">Ingredients</a></li>
								<li class="backgroundColour"><a href="manageStock.php">Stock</a></li>
								<li class="backgroundColour"><a href="manageSupplier.php">Suppliers</a></li>
								<li class="backgroundColour"><a href="manageTransaction.php">Transactions</a></li>
							</ul></li>
							
							<li class="dropdown">
						  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Analytics<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li class="backgroundColour"><a href="staffAnalytics.php">Staff</a></li>
								<li class="backgroundColour"><a href="storeAnalytics.php">Stores</a></li>
								<li class="backgroundColour"><a href="offerAnalytics.php">Offers</a></li>
								<li class="backgroundColour"><a href="productAnalytics.php">Products</a></li>
								<li class="backgroundColour"><a href="transactionAnalytics.php">Transactions</a></li>
								<li class="backgroundColour"><a href="customerAnalytics.php">Customers</a></li>
							</ul></li>
						
						
						<li class="backgroundColour"><a href = "logout.php" onclick="return confirm('Are you sure you would like to log out?')">Log out</a></li>
					<?PHP
					}
					elseif ($_SESSION['type'] == 'manager'){ ?>
						
						<li class="dropdown">
						  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">View<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li class="backgroundColour"><a href="staff.php">Staff</a></li>
								<li class="backgroundColour"><a href="stores.php">Stores</a></li>
								<li class="backgroundColour"><a href="offers.php">Offers</a></li>
								<li class="backgroundColour"><a href="equipment.php">Equipment</a></li>
								<li class="backgroundColour"><a href="products.php">Products</a></li>
								<!--<li class="backgroundColour"><a href="ingredients.php">Ingredidents</a></li>-->
								<li class="backgroundColour"><a href="suppliers.php">Suppliers</a></li>

							</ul></li>
							
							<li class="dropdown">
						  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Manage<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li class="backgroundColour"><a href="manageStaff.php">Staff</a></li>
								<li class="backgroundColour"><a href="manageEquipment.php">Equipment</a></li>
								<li class="backgroundColour"><a href="manageProduct.php">Products</a></li>
								<li class="backgroundColour"><a href="manageIngredient.php">Ingredients</a></li>
								<li class="backgroundColour"><a href="manageStock.php">Stock</a></li>
								<li class="backgroundColour"><a href="manageTransaction.php">Transactions</a></li>
							</ul></li>
							
							<li class="dropdown">
						  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Analytics<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li class="backgroundColour"><a href="staffAnalytics.php">Staff</a></li>
								<li class="backgroundColour"><a href="storeAnalytics.php">Stores</a></li>
							</ul></li>
						
						
						<li class="backgroundColour"><a href = "logout.php" onclick="return confirm('Are you sure you would like to log out?')">Log out</a></li>
					<?PHP
					}
					elseif ($_SESSION['type'] == 'shopfloorstaffmember'){ ?>
						
						<li class="dropdown">
						  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">View<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li class="backgroundColour"><a href="stores.php">Stores</a></li>
								<li class="backgroundColour"><a href="offers.php">Offers</a></li>
								<li class="backgroundColour"><a href="equipment.php">Equipment</a></li>
								<li class="backgroundColour"><a href="products.php">Products</a></li>
							</ul></li>
							
							<li class="dropdown">
						  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Manage<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li class="backgroundColour"><a href="manageEquipment.php">Equipment</a></li>
								<li class="backgroundColour"><a href="manageStock.php">Stock</a></li>
								<li class="backgroundColour"><a href="manageTransaction.php">Transactions</a></li>
							</ul></li>
						
						<li class="backgroundColour"><a href = "logout.php" onclick="return confirm('Are you sure you would like to log out?')">Log out</a></li>
					<?PHP
					}
					elseif ($_SESSION['type'] == 'Employee'){ ?>
						<li class="backgroundColour"><a href="stores.php">Stores</a></li>
						<li class="backgroundColour"><a href="products.php">Products</a></li>
						<li class="backgroundColour"><a href="equipment.php">Equipment</a></li>
						<li class="backgroundColour"><a href = "logout.php" onclick="return confirm('Are you sure you would like to log out?')">Log out</a></li>
					<?PHP
					}
					elseif ($_SESSION['type'] == 'customer'){ ?>
						<li class="backgroundColour"><a href="customerprofile.php">My profile</a></li>
						<li class="backgroundColour"><a href="stores.php">Stores</a></li>
						<li class="backgroundColour"><a href="product.php">Products</a></li>
						<li class="backgroundColour"><a href = "logout.php" onclick="return confirm('Are you sure you would like to log out?')">Log out</a></li>
					<?PHP
					}
					?>
				  
				</li>
			  </ul>
			  <?php if (!empty($_SESSION['loggedin'])): ?>
			  <h4 class="navbar-text navbar-right">Signed in as <?php echo $_SESSION['username']; ?></h4>
			  <?php endif; ?>
			</div><!--/.nav-collapse -->
		  </div>
		</nav>
    </div>
</div>