<?php
	include('header.php');
	include('config.php');
	$sourcepage = $_POST["sourcepage"];
	$facttext = $_POST["facttext"];
	// $lat = (double) $_POST["latitude"];
	$lat = "37.426295";
	// $lng = (double) $_POST["longitude"];
	$lng = "-122.171893";
	$address = $_POST["address"];
	$source = str_replace(" ", "_", $sourcepage);
	$fact = str_replace("\\", "", $facttext);
	$fact = str_ireplace($sourcepage, "<strong>".$sourcepage."</strong>", $fact);
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
		echo "<p class='success'>Thanks! Your fact has been added.</p>";
	}
	else {
		echo "<p class='failure'>Something went wrong. Sorry!</p>";
	}
?>

<div class="navbutton">
<a href="index.php"><button>Home</button></a>
</div>

<?php include('footer.php'); ?>