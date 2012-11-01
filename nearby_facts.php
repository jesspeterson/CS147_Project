<?php
	include("config.php");
	$query = "SELECT * FROM wikitour";
	$result = mysql_query($query);
	
	$my_lat = $_REQUEST['lat'];
	$my_long = $_REQUEST['long'];
	
	// $my_lat = "37.41935088358339";//$_REQUEST['lat'];
	// $my_long = "-122.16894757738555";//$_REQUEST['long'];
	$facts = array();
	while ($row = mysql_fetch_assoc($result)) {
					
		if( (floatval(substr($row["lat"],0,7) == floatval(substr($my_lat,0,7)))) && 
			(floatval(substr($row["long"],0,7) == floatval(substr($my_long,0,7)))) ){
			// print 123;
			$facts[$row["id"]]["lat"] = $row["lat"];
			$facts[$row["id"]]["long"] = $row["long"];
		}			
	}

	print json_encode($facts);
?>
