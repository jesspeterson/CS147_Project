<?php
	include("config.php");
	$query = "SELECT * FROM wikitour";
	$result = mysql_query($query);
	
	$my_lat = $_REQUEST['lat'];
	$my_long = $_REQUEST['long'];
	// $my_lat = "37.4307151";
	// $my_long = "-122.1733189";
	// $my_lat = "37.41935088358339";//$_REQUEST['lat'];
	// $my_long = "-122.16894757738555";//$_REQUEST['long'];
	$facts = array();
	while ($row = mysql_fetch_assoc($result)) {
		$address = $row["address"];
		$id = $row["id"];
		$lat = $row["lat"];
		$long = $row["long"];
		// print $row["address"];
		// print "+";
		// print floatval(substr($lat,0,4));
		// print "+";
		// print floatval(substr($my_lat,0,4));
		// print "+";
		// 
		// print floatval(substr($long,0,4));
		// print "+";
		// 
		// print floatval(substr($my_long,0,4));
		// print "+";
		
		// print "<br />";
		if( (floatval(substr($lat,0,4)) == floatval(substr($my_lat,0,4))) && 
			(floatval(substr($long,0,4)) == floatval(substr($my_long,0,4))) ){
			// print 123;
			// $latlongkey = (string)(substr($lat,0,6)+","+substr($long,0,6));
			if(!array_key_exists($address,$facts)){
				$facts[$address] = array();
			}
			$facts[$address][$id]["lat"] = $lat;
			$facts[$address][$id]["long"] = $long;
			$facts[$address][$id]["fact"] = $row["fact"];
			$facts[$address][$id]["address"] = $address;
			$facts[$address][$id]["source"] = $row["source"];
			$facts[$address][$id]["id"] = $row["id"];
			
			
			// $facts[$address][$id]["id"] = $row["id"];
			
		}			
	}
	// print $my_lat;
	// print $my_long;
	print json_encode($facts);
?>
