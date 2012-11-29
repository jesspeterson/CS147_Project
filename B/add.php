<?php
	include('config.php');
	$version = $_COOKIE["wikitour_version"];
	$start = $_COOKIE["wikitour_time"];
	date_default_timezone_set('America/Los_Angeles');
	$end = date("Y-m-d H:i:sP");
	$sql = "insert into ab_test(version,start_time,end_time) values('$version','$start','$end')";
	$result = mysql_query($sql);
?>
<?php 
	include('header.php');
	$source = $_GET["source"];
?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwiHi6BAeRu7z44MIb8VTAxeyVe7WLvjo&sensor=true"></script>
<script>
window.optimizely = window.optimizely || [];
window.optimizely.push(['trackEvent', 'added_fact']);
</script>

<p id="factguide">The quality of the facts you enter is what makes WikiTour great. Make sure your fact is a positive and interesting contribution to the WikiTour community.</p>
<form id="addfact" name="addfact" action="submitfact.php" method="post" data-ajax="false">
	<input type="hidden" name="sourcepage" value="<?php echo str_replace("_", " ", $source); ?>" />
	<textarea name="facttext" maxlength="120" placeholder="Enter your fact&mdash;why will visitors here want to learn about <?php echo $source; ?>?"></textarea>
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
    	document.forms["addfact"].submit();
    }

	$('#facttext').keyup(function() {
		console.log(1);
		console.log($('#facttext').value().length);
	});
</script>

<?php include('footer.php'); ?>
