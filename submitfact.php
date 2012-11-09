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

<p>Page: <?php echo $source; ?></p>
<p>Fact: <?php echo $fact; ?></p>
<p>Latitude: <?php echo $lat; ?></p>
<p>Longitude: <?php echo $lng; ?></p>
<p>Address: <?php echo $address; ?></p>

<?php
	$query = "INSERT INTO  `wikitour` (
		`fact` ,
		`source` ,
		`lat` ,
		`long`
		)
		VALUES (
		'$fact',  '$source', '$lat',  '$lng'
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