<?php
if(!isset($_SESSION))
{
	@session_start();
} 
if(!empty($_SESSION['loggedin']) && !empty($_SESSION['type']) &&  $_SESSION['loggedin'] == true && $_SESSION['type'] == "executive" || $_SESSION['type'] == "manager"){ ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>The Brown Bean Café</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link href='https://fonts.googleapis.com/css?family=Rock+Salt|Shadows+Into+Light+Two' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="css/custom.css">
  <script src="js/jquery-2.1.4.js"></script>
  <script src="js/bootstrap.js"></script>
  
  <link rel="shortcut icon" href="img/coffee_cup_icon.ico">
  
	<!-- Animated charts -->
	<!-- Source: http://www.highcharts.com/ -->
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/data.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
</head>
	<body>
		<?PHP
			include 'menu.php';
		?>
    <div class="container">
       <h2>Store Transactions</h2>
       <div class="breadcrumbs"><a href="index.php">Home</a> > Store Analytics </div>
          <div class="row">    
           <section class="col-md-12 table-responsive">
                <table class="table table-bordered table-striped table-condensed">
                <form id="filters" method="POST">
                  <tr>
                      <td> 
                        <center>
                          Trasnactions Between
                          <input name="date1" value=""  type="date" id="date1">
                          <input name="date2" value=""  type="date" id="date2">
                        </center>
                      </td>
                  </tr>
                  </form>
                  </table>                  
                  <center>
                    <button type="submit" form="filters"> Submit Filters</button>
                    <button onclick='clearFilters()' form="filters"> Clear Filters</button>
                  </center>
                  
                  <table id="datatable" class="sortable table table-bordered table-striped table-condensed">
                  <tr>
                    <th>Shop Name</th>
                    <th>Revenue</th>
					<th>Cost</th>
					<th>Profit</th>
                  </tr>
                
                  <?php
                    $host = "silva.computing.dundee.ac.uk";
                    $username = "15ac3u03";
                    $password = "ab123c";
                    $db_name = "15ac3d03";
                    // Create connection
                    //$conn = new mysqli($servername, $username, $password, $dbname);
                    mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
                    mysql_select_db("$db_name")or die("cannot select DB");
					
					  $date1='0000-00-00';
                      $date2='0000-00-00';
                    if( isset($_POST['date1']) && isset($_POST['date2'])) {
                        $date1 =  $_POST['date1'];
                        $date2 =  $_POST['date2'];
                        if($date1 != null && $date2 != null)
                        {
                        $date1 = mysql_real_escape_string(stripslashes($date1));
                        $date1 = date('Y-m-d', strtotime(str_replace('/', '-', $date1)));
                        $date2 = mysql_real_escape_string(stripslashes($date2));
                        $date2 = date('Y-m-d', strtotime(str_replace('/', '-', $date2)));
                        }
                        else
                        {
                            $date1='0000-00-00';
                            $date2='0000-00-00';
                        }
                    }
					  
                    $sql = "CALL storeTransactions('$date1', '$date2')";
                    $result=mysql_query($sql);
                    $count=mysql_num_rows($result);

                    $fmt = new NumberFormatter( 'en_GB', NumberFormatter::CURRENCY );
                    
                    if ($count > 0) {
                       // output data of each row
                         
                      while($row = mysql_fetch_assoc($result)) {
                         echo "<tr>
                              <td>" . $row["Shop_Name"] . "</td>
							  <td>" . $row["Revenue"] . "</td>
							  <td>" . $row["Cost"] . "</td>
                              <td>" . $row["Profit"] . "</td>
                            </tr>";
                         
                      }
                    } else {
                      echo "0 results";
                    }
                      
                    mysql_close();  
                  ?>
                  </table>
            </div>
          </section>      
		<div id="chart">
			<script>
				$(function () {
					$('#chart').highcharts({
						data: {
							table: 'datatable'
						},
						chart: {
							type: 'column'
						},
						title: {
							text: 'Revenue and Profit by Store'
						},
						yAxis: {
							allowDecimals: true,
							title: {
								text: 'Amount (GBP £)'
							}
						}
					});
				});
			</script>
		</div>
		</div>
  </body>
	
</html>
<?php
		}else
			header("location: index.php");
	?>