<?php 
	include('header.php');
	$source = $_GET["source"];
?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwiHi6BAeRu7z44MIb8VTAxeyVe7WLvjo&sensor=true"></script>

<p id="factguide">The quality of the facts you enter is what makes WikiTour great. Make sure your fact is a positive and interesting contribution to the WikiTour community.</p>
<form id="addfact" name="addfact" action="submitfact.php" method="post" data-ajax="false">
	<input type="hidden" name="sourcepage" value="<?php echo str_replace("_", " ", $source); ?>" />
	<span id="character_limit" style="float:right;">140</span>
	<textarea name="facttext" id="facttext" maxlength="140" placeholder="Enter your fact&mdash;why will visitors here want to learn about <?php echo $source; ?>?"></textarea>
	<input type="hidden" name="latitude" value="">
	<input type="hidden" name="longitude" value="">
	<input type="hidden" name="address" value="">
	<input type="button" value="Pin fact to my location" onclick="setLoc();"/>
</form>
<div class="navbutton">
	<a href="index.html" data-role="button" data-rel="back">Cancel</a>
</div>
<script>

	var lat = 0.0;
	var lng = 0.0;
	var address = "";
	function getLocation()
	{
		if (navigator.geolocation)
		{
		navigator.geolocation.getCurrentPosition(storePosition);
		}
		else{x.innerHTML="Geolocation is not supported by this browser.";}
	}
	function storePosition(position)
	{
		lat = position.coords.latitude.toFixed(7);
		lng = position.coords.longitude.toFixed(7);	
		
		$.getJSON("revgeocode.php?latlng="+lat+","+lng, function(data) {
		address = data.results[0].formatted_address;
	});			
	}
	getLocation();


	function setLoc(){
    	document.addfact.latitude.value = lat;
    	document.addfact.longitude.value = lng;
    	document.addfact.address.value = address;
    	setTimeout(function(){document.forms["addfact"].submit();}, 1000);
    }

	$('#facttext').keydown(function() {
		$("#character_limit").html(140 - $('#facttext').val().length);
	});
</script>

<?php include('footer.php'); ?>
