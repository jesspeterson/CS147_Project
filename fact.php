<?php
	include("header.php");
	include("config.php");
	$id = $_GET["id"];
	$query = "SELECT * FROM wikitour WHERE id=$id";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$fact = $row[fact];
	$source = $row[source];
	$likes = $row[likes];
?>
<script>
	$.getJSON("http://en.wikipedia.org/w/api.php?action=parse&format=json&callback=?", 
		{
			page:"<?php echo $source; ?>", prop:"text"
		}, function(data) {
		var content = data.parse.text['*'];
		content = content.replace(/href=\"\/wiki\//g, "href=\"wikipedia.php?source=");
		$("#wikiText").html(content);
	});

</script>

<p id="factText"><?php echo $fact; ?></p>

<div id="wikiText">

</div>

<div data-role="footer" data-position="fixed" style="padding:3px;">
	<a href="index.php" data-role="button" data-rel="back" data-ajax="false" data-icon="arrow-l">Home</a>
	
	
	<button type="submit" id="like_button" data-icon="check" value="Like"></button>
	<!--//$("#like_image").attributes("src","like2.png");
	//<input type="button" img><id="like_image" src="like1.png"></input>-->
	
	
	<a href="wikipedia.php?source=<?php echo $source; ?>" data-role="button" data-icon="arrow-r" style="float:right;">Wiki Page</a>
</div>

<script>
	function handleClick(e) {
		var target = $(e.target).closest('a');
		if( target ) {
			e.preventDefault();
			window.location = target.attr('href');
		}
	}
	
	$('#like_button').click( function() {
		if ($('#like_button').attr("data-theme") != "b") {
			$('#like_button').buttonMarkup({theme: "b"});
			<?php
				$update1 = "UPDATE wikitour SET likes = likes + 1 WHERE id=$id";
				echo "console.log('increment up by one');";
				$result = mysql_query($update1);
				echo "console.log('$result');";

			?>
		} else {
			$('#like_button').buttonMarkup({theme: "a"});	
			<?php
				$update1 = "UPDATE wikitour SET likes = likes - 1 WHERE id=$id";
				echo "console.log('increment down to 1');";
				$result= mysql_query($update1);
				echo "console.log('$result');";
				
			?>
		}
	});

</script>

<?php include('footer.php'); ?>