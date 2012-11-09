<?php
	include("header.php");
	$source = $_REQUEST["source"];
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

<div id="wikiText">

</div>

<div data-role="footer" style="padding:3px;">
	<a href="index.php" data-role="button" data-rel="back" data-icon="arrow-l">Back</a>
</div>

<?php include('footer.php'); ?>