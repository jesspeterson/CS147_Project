<?php
	include("config.php");
	$query = "SELECT * FROM wikitour";
	$result = mysql_query($query);
	
	$my_lat = $_REQUEST['lat'];
	$my_long = $_REQUEST['long'];
	$facts = array();
	while ($row = mysql_fetch_assoc($result)) {
		$address = $row["address"];
		$id = $row["id"];
		$lat = $row["lat"];
		$long = $row["long"];

		if( (floatval(substr($lat,0,4)) == floatval(substr($my_lat,0,4))) && 
			(floatval(substr($long,0,4)) == floatval(substr($my_long,0,4))) ){
			if(!array_key_exists($address,$facts)){
				$facts[$address] = array();
			}
			$facts[$address][$id]["lat"] = $lat;
			$facts[$address][$id]["long"] = $long;
			$facts[$address][$id]["fact"] = $row["fact"];
			$facts[$address][$id]["address"] = $address;
			$facts[$address][$id]["source"] = $row["source"];
			$facts[$address][$id]["id"] = $row["id"];			
		}			
	}
	print json_encode($facts);
?>
