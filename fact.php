<?php
	include("header.php");
	include("config.php");
	$id = $_GET["id"];
	$query = "SELECT * FROM wikitour WHERE id=$id";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$fact = $row[fact];
	$source = $row[source];
?>
<script>
	$.getJSON("http://en.wikipedia.org/w/api.php?action=parse&format=json&callback=?", 
		{
			page:"<?php echo $source; ?>", prop:"text"
		}, function(data) {
		var content = data.parse.text['*'];
		$("#wikiText").html(content);
	});
</script>

<p id="factText"><?php echo $fact; ?></p>

<div id="wikiText">

</div>

<div data-role="footer" style="padding:3px;">
	<a href="index.php" data-role="button" data-rel="back" data-icon="arrow-l">Back</a>
	<a href="wikiview.php" data-role="button" data-icon="arrow-r" style="float:right;">Read More</a>
</div>

<?php include('footer.php'); ?>