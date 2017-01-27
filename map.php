<!--

Code based on Google Maps' Geocoding and Custom Icon tutorials
https://developers.google.com/maps/documentation/javascript/examples/icon-complex
https://developers.google.com/maps/documentation/javascript/geocoding

-->
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>map.php</title>
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
    </style>
	<?php
		$host = "silva.computing.dundee.ac.uk";
		$username = "15ac3u03";
		$password = "ab123c";
		$db_name = "15ac3d03";

		// Create connection
		mysql_connect("$host", "$username", "$password")or die("cannot connect");
		mysql_select_db("$db_name")or die("cannot select DB");
		
		//set base sql statement
		$sql = "SELECT streetName, city, country, shopID FROM stores;";
		
		$result=mysql_query($sql);
		$count=mysql_num_rows($result);
		
		
	?>
  </head>
  <body>
    <div id="map"></div>
    <script>

// The following example creates complex markers to indicate beaches near
// Sydney, NSW, Australia. Note that the anchor is set to (0,32) to correspond
// to the base of the flagpole.

function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 15,
    center: {lat: 56.458618, lng: -2.982659}
  });

  setMarkers(map);
}

// Data for the markers consisting of a name, a LatLng and a zIndex for the
// order in which these markers should display on top of each other.
var beaches = [
	<?php
	while($row = mysql_fetch_assoc($result)) {
		$streetName = $row["streetName"];
		$city  		= $row["city"];
		$country 	= $row["country"];
		$zIndex  	= $row["shopID"];
		
		$address  = $streetName;
		$address .= ", ";
		$address .= $city;
		$address .= ", ";
		$address .= $country;
		
		$url  = "https://maps.googleapis.com/maps/api/geocode/json?address=";
		$url .= urlencode($address);
		$url .= "&key=AIzaSyAnFuPLSU9kLuXrUY9Tzkh8mv0PvxHYYxE";
		
		$jsonData = json_decode(file_get_contents($url), true);
		if ($jsonData["status"] == "OK") {
			$lat = $jsonData["results"][0]["geometry"]["location"]["lat"];
			$long = $jsonData["results"][0]["geometry"]["location"]["lng"];

		echo "['";
		echo $streetName;
		echo "',";
		echo $lat;
		echo ",";
		echo $long;
		echo ", ";
		echo $zIndex;
		echo "], ";
		};
	}
	?>
	['Head Office', 56.458618, -2.982659, 0] 
];

function setMarkers(map) {
  // Adds markers to the map.

  // Marker sizes are expressed as a Size of X,Y where the origin of the image
  // (0,0) is located in the top left of the image.

  // Origins, anchor positions and coordinates of the marker increase in the X
  // direction to the right and in the Y direction down.
  var image = {
    url: 'img/coffee-bean.png',
    // This marker is 20 pixels wide by 32 pixels high.
    size: new google.maps.Size(20, 32),
    // The origin for this image is (0, 0).
    origin: new google.maps.Point(0, 0),
    // The anchor for this image is the base of the flagpole at (0, 32).
    anchor: new google.maps.Point(0, 32)
  };
  // Shapes define the clickable region of the icon. The type defines an HTML
  // <area> element 'poly' which traces out a polygon as a series of X,Y points.
  // The final coordinate closes the poly by connecting to the first coordinate.
  var shape = {
    coords: [1, 1, 1, 20, 18, 20, 18, 1],
    type: 'poly'
  };
  for (var i = 0; i < beaches.length; i++) {
    var beach = beaches[i];
    var marker = new google.maps.Marker({
      position: {lat: beach[1], lng: beach[2]},
      map: map,
      icon: image,
      shape: shape,
      title: beach[0],
      zIndex: beach[3]
    });
  }
}

    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3WdQANX6Ca4IuQhjjq7vl8-Zf-7H0PkI&signed_in=true&callback=initMap"></script>
  </body>
</html>
