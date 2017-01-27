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
			<div class="breadcrumbs"><a href="index.php">Home</a> > Manage Store</div>
			<br>
			<h1>Manage Stores</h1>
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
			  <li class=<?php echo "\"".$activeAddTab."\""; ?>><a data-toggle="tab" href="#add">Add</a></li>
			  <li class=<?php echo "\"".$activeRemoveTab."\""; ?>><a data-toggle="tab" href="#remove">Remove</a></li>
			</ul>

			<div class="tab-content">
			  <div id="add" class=<?php echo "\"".$activeAddContent."\""; ?>>
				<h2>Add store</h2>
				
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
				
				<form method="post" action="addstore.php">
					<h3>Store information</h3>
					<p>Street name<input id="streetname" type="text" name="streetname" value="" placeholder="Street Name" class="form-control"></p>
					<p>City<input id="city" type="text" name="city" value="" placeholder="City" class="form-control"></p>
					<p>Area<input id="area" type="text" name="area" value="" placeholder="Area" class="form-control"></p>
					<p>Country<select id="country" name="country"class="form-control">
							<option value="AF">Afghanistan</option>
							<option value="AX">Åland Islands</option>
							<option value="AL">Albania</option>
							<option value="DZ">Algeria</option>
							<option value="AS">American Samoa</option>
							<option value="AD">Andorra</option>
							<option value="AO">Angola</option>
							<option value="AI">Anguilla</option>
							<option value="AQ">Antarctica</option>
							<option value="AG">Antigua and Barbuda</option>
							<option value="AR">Argentina</option>
							<option value="AM">Armenia</option>
							<option value="AW">Aruba</option>
							<option value="AU">Australia</option>
							<option value="AT">Austria</option>
							<option value="AZ">Azerbaijan</option>
							<option value="BS">Bahamas</option>
							<option value="BH">Bahrain</option>
							<option value="BD">Bangladesh</option>
							<option value="BB">Barbados</option>
							<option value="BY">Belarus</option>
							<option value="BE">Belgium</option>
							<option value="BZ">Belize</option>
							<option value="BJ">Benin</option>
							<option value="BM">Bermuda</option>
							<option value="BT">Bhutan</option>
							<option value="BO">Bolivia</option>
							<option value="BA">Bosnia and Herzegovina</option>
							<option value="BW">Botswana</option>
							<option value="BV">Bouvet Island</option>
							<option value="BR">Brazil</option>
							<option value="IO">British Indian Ocean Territory</option>
							<option value="BN">Brunei Darussalam</option>
							<option value="BG">Bulgaria</option>
							<option value="BF">Burkina Faso</option>
							<option value="BI">Burundi</option>
							<option value="KH">Cambodia</option>
							<option value="CM">Cameroon</option>
							<option value="CA">Canada</option>
							<option value="CV">Cape Verde</option>
							<option value="KY">Cayman Islands</option>
							<option value="CF">Central African Republic</option>
							<option value="TD">Chad</option>
							<option value="CL">Chile</option>
							<option value="CN">China</option>
							<option value="CX">Christmas Island</option>
							<option value="CC">Cocos (Keeling) Islands</option>
							<option value="CO">Colombia</option>
							<option value="KM">Comoros</option>
							<option value="CG">Congo</option>
							<option value="CD">Congo, The Democratic Republic of The</option>
							<option value="CK">Cook Islands</option>
							<option value="CR">Costa Rica</option>
							<option value="CI">Cote D'ivoire</option>
							<option value="HR">Croatia</option>
							<option value="CU">Cuba</option>
							<option value="CY">Cyprus</option>
							<option value="CZ">Czech Republic</option>
							<option value="DK">Denmark</option>
							<option value="DJ">Djibouti</option>
							<option value="DM">Dominica</option>
							<option value="DO">Dominican Republic</option>
							<option value="EC">Ecuador</option>
							<option value="EG">Egypt</option>
							<option value="SV">El Salvador</option>
							<option value="GQ">Equatorial Guinea</option>
							<option value="ER">Eritrea</option>
							<option value="EE">Estonia</option>
							<option value="ET">Ethiopia</option>
							<option value="FK">Falkland Islands (Malvinas)</option>
							<option value="FO">Faroe Islands</option>
							<option value="FJ">Fiji</option>
							<option value="FI">Finland</option>
							<option value="FR">France</option>
							<option value="GF">French Guiana</option>
							<option value="PF">French Polynesia</option>
							<option value="TF">French Southern Territories</option>
							<option value="GA">Gabon</option>
							<option value="GM">Gambia</option>
							<option value="GE">Georgia</option>
							<option value="DE">Germany</option>
							<option value="GH">Ghana</option>
							<option value="GI">Gibraltar</option>
							<option value="GR">Greece</option>
							<option value="GL">Greenland</option>
							<option value="GD">Grenada</option>
							<option value="GP">Guadeloupe</option>
							<option value="GU">Guam</option>
							<option value="GT">Guatemala</option>
							<option value="GG">Guernsey</option>
							<option value="GN">Guinea</option>
							<option value="GW">Guinea-bissau</option>
							<option value="GY">Guyana</option>
							<option value="HT">Haiti</option>
							<option value="HM">Heard Island and Mcdonald Islands</option>
							<option value="VA">Holy See (Vatican City State)</option>
							<option value="HN">Honduras</option>
							<option value="HK">Hong Kong</option>
							<option value="HU">Hungary</option>
							<option value="IS">Iceland</option>
							<option value="IN">India</option>
							<option value="ID">Indonesia</option>
							<option value="IR">Iran, Islamic Republic of</option>
							<option value="IQ">Iraq</option>
							<option value="IE">Ireland</option>
							<option value="IM">Isle of Man</option>
							<option value="IL">Israel</option>
							<option value="IT">Italy</option>
							<option value="JM">Jamaica</option>
							<option value="JP">Japan</option>
							<option value="JE">Jersey</option>
							<option value="JO">Jordan</option>
							<option value="KZ">Kazakhstan</option>
							<option value="KE">Kenya</option>
							<option value="KI">Kiribati</option>
							<option value="KP">Korea, Democratic People's Republic of</option>
							<option value="KR">Korea, Republic of</option>
							<option value="KW">Kuwait</option>
							<option value="KG">Kyrgyzstan</option>
							<option value="LA">Lao People's Democratic Republic</option>
							<option value="LV">Latvia</option>
							<option value="LB">Lebanon</option>
							<option value="LS">Lesotho</option>
							<option value="LR">Liberia</option>
							<option value="LY">Libyan Arab Jamahiriya</option>
							<option value="LI">Liechtenstein</option>
							<option value="LT">Lithuania</option>
							<option value="LU">Luxembourg</option>
							<option value="MO">Macao</option>
							<option value="MK">Macedonia, The Former Yugoslav Republic of</option>
							<option value="MG">Madagascar</option>
							<option value="MW">Malawi</option>
							<option value="MY">Malaysia</option>
							<option value="MV">Maldives</option>
							<option value="ML">Mali</option>
							<option value="MT">Malta</option>
							<option value="MH">Marshall Islands</option>
							<option value="MQ">Martinique</option>
							<option value="MR">Mauritania</option>
							<option value="MU">Mauritius</option>
							<option value="YT">Mayotte</option>
							<option value="MX">Mexico</option>
							<option value="FM">Micronesia, Federated States of</option>
							<option value="MD">Moldova, Republic of</option>
							<option value="MC">Monaco</option>
							<option value="MN">Mongolia</option>
							<option value="ME">Montenegro</option>
							<option value="MS">Montserrat</option>
							<option value="MA">Morocco</option>
							<option value="MZ">Mozambique</option>
							<option value="MM">Myanmar</option>
							<option value="NA">Namibia</option>
							<option value="NR">Nauru</option>
							<option value="NP">Nepal</option>
							<option value="NL">Netherlands</option>
							<option value="AN">Netherlands Antilles</option>
							<option value="NC">New Caledonia</option>
							<option value="NZ">New Zealand</option>
							<option value="NI">Nicaragua</option>
							<option value="NE">Niger</option>
							<option value="NG">Nigeria</option>
							<option value="NU">Niue</option>
							<option value="NF">Norfolk Island</option>
							<option value="MP">Northern Mariana Islands</option>
							<option value="NO">Norway</option>
							<option value="OM">Oman</option>
							<option value="PK">Pakistan</option>
							<option value="PW">Palau</option>
							<option value="PS">Palestinian Territory, Occupied</option>
							<option value="PA">Panama</option>
							<option value="PG">Papua New Guinea</option>
							<option value="PY">Paraguay</option>
							<option value="PE">Peru</option>
							<option value="PH">Philippines</option>
							<option value="PN">Pitcairn</option>
							<option value="PL">Poland</option>
							<option value="PT">Portugal</option>
							<option value="PR">Puerto Rico</option>
							<option value="QA">Qatar</option>
							<option value="RE">Reunion</option>
							<option value="RO">Romania</option>
							<option value="RU">Russian Federation</option>
							<option value="RW">Rwanda</option>
							<option value="SH">Saint Helena</option>
							<option value="KN">Saint Kitts and Nevis</option>
							<option value="LC">Saint Lucia</option>
							<option value="PM">Saint Pierre and Miquelon</option>
							<option value="VC">Saint Vincent and The Grenadines</option>
							<option value="WS">Samoa</option>
							<option value="SM">San Marino</option>
							<option value="ST">Sao Tome and Principe</option>
							<option value="SA">Saudi Arabia</option>
							<option value="SN">Senegal</option>
							<option value="RS">Serbia</option>
							<option value="SC">Seychelles</option>
							<option value="SL">Sierra Leone</option>
							<option value="SG">Singapore</option>
							<option value="SK">Slovakia</option>
							<option value="SI">Slovenia</option>
							<option value="SB">Solomon Islands</option>
							<option value="SO">Somalia</option>
							<option value="ZA">South Africa</option>
							<option value="GS">South Georgia and The South Sandwich Islands</option>
							<option value="ES">Spain</option>
							<option value="LK">Sri Lanka</option>
							<option value="SD">Sudan</option>
							<option value="SR">Suriname</option>
							<option value="SJ">Svalbard and Jan Mayen</option>
							<option value="SZ">Swaziland</option>
							<option value="SE">Sweden</option>
							<option value="CH">Switzerland</option>
							<option value="SY">Syrian Arab Republic</option>
							<option value="TW">Taiwan, Province of China</option>
							<option value="TJ">Tajikistan</option>
							<option value="TZ">Tanzania, United Republic of</option>
							<option value="TH">Thailand</option>
							<option value="TL">Timor-leste</option>
							<option value="TG">Togo</option>
							<option value="TK">Tokelau</option>
							<option value="TO">Tonga</option>
							<option value="TT">Trinidad and Tobago</option>
							<option value="TN">Tunisia</option>
							<option value="TR">Turkey</option>
							<option value="TM">Turkmenistan</option>
							<option value="TC">Turks and Caicos Islands</option>
							<option value="TV">Tuvalu</option>
							<option value="UG">Uganda</option>
							<option value="UA">Ukraine</option>
							<option value="AE">United Arab Emirates</option>
							<option value="GB">United Kingdom</option>
							<option value="US">United States</option>
							<option value="UM">United States Minor Outlying Islands</option>
							<option value="UY">Uruguay</option>
							<option value="UZ">Uzbekistan</option>
							<option value="VU">Vanuatu</option>
							<option value="VE">Venezuela</option>
							<option value="VN">Viet Nam</option>
							<option value="VG">Virgin Islands, British</option>
							<option value="VI">Virgin Islands, U.S.</option>
							<option value="WF">Wallis and Futuna</option>
							<option value="EH">Western Sahara</option>
							<option value="YE">Yemen</option>
							<option value="ZM">Zambia</option>
							<option value="ZW">Zimbabwe</option>
					</select>				
					</p>
					<p>Rent per month (currency used in area)<input id="rent" type="number" name="rent" value="" placeholder="Rent per month (currency used in area)" class="form-control"></p>
					
					<h3>Demographic information</h3>
					
					<p>Average salary for area<input id="averageSalaryForArea" type="text" name="averageSalaryForArea" value="" placeholder="Average salary for area name" class="form-control"></p>
					<p>Average coffee price<input id="averageCoffeePrice" type="text" name="averageCoffeePrice" value="" placeholder="Average coffee price" class="form-control"></p>
					<p>Currency used (e.g. - GBP)<input id="currency" type="text" name="Currency" value="" placeholder="Currency" class="form-control"></p>

					<p id="error"></p>
					<p class="submit"><input type="submit" class="btn-primary form-control"name="commit" value="Add store"></p>
				</form>
			  </div>
			  
			  <div id="remove" class=<?php echo "\"".$activeRemoveContent."\""; ?>>
				<h2>Remove Store</h2>

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
				
				<form method="post" action="removeStore.php">
					<h3>Store information</h3>
					<p>Store
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
								
								echo "<option></option>\n";
								
								while($data=mysql_fetch_array($res)) {
								   echo "<option>".$data["streetName"].",".$data["city"].",".$data["country"]."</option>\n";
								}
								 
								// on ferme la connexion à mysql
								mysql_close($db);
							?>
						</select>
					</p>
					
					<p id="error"></p>
					<p class="submit"><input type="submit" class="btn-primary form-control" name="commit" onclick="return confirm('Are you sure you would like to remove this store?');" value="Remove store"></p>
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