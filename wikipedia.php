<?php
	include("header.php");
	$source = $_REQUEST["source"];
?>

<script>
	$(window).click(handleClick);
	
	function handleClick(e) {
		var target = $(e.target).closest('a');
		if( target && target.attr('href')) {
			e.preventDefault();
			window.location = target.attr('href');
		}
	}
	
	$.getJSON("http://en.wikipedia.org/w/api.php?action=parse&format=json&callback=?", 
		{
			page:"<?php echo $source; ?>", prop:"text"
		}, function(data) {
		var content = data.parse.text['*'];
		content = content.replace(/href=\"\/wiki\//g, "href=\"wikipedia.php?source=");
		$("#wikiPage").html(content);
	});

</script>

<div id="wikiPage">

</div>

<div data-role="footer" data-position="fixed" style="padding:3px;">
	<a href="index.php" data-role="button" data-rel="back" data-ajax="false" data-icon="arrow-l">Back</a>
	<a href="index.php" data-role="button" data-icon="home">Home</a>
	<a href="add.php?source=<?php echo $source; ?>" data-role="button" data-icon="plus" style="float:right;" data-transition="pop">Add Fact</a>
</div>

<?php include('footer.php'); ?>