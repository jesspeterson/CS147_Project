<?php
	include('header.php');
	include('config.php');
	$sourcepage = $_POST["sourcepage"];
	$facttext = $_POST["facttext"];
	$lat = (double) $_POST["latitude"];
	$lng = (double) $_POST["longitude"];
	$address = $_POST["address"];
	$source = str_replace(" ", "_", $sourcepage);
	$fact = str_replace("\\", "", $facttext);
?>

<?php
	$query = "INSERT INTO  `wikitour` (
		`fact` ,
		`source` ,
		`lat` ,
		`long`,
		`address`
		)
		VALUES (
		'$fact',  '$source', '$lat',  '$lng', '$address'
		)";
	
	$result = mysql_query($query);
	
	if ($result) {
		echo "<p>Thanks! Your fact has been added.</p>";
	}
	else {
		echo "<p>Something went wrong. Sorry!</p>";
	}
?>

<a href="index.php"><button>Home</button></a>

<?php include('footer.php'); ?>