<?php include('header.php'); ?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwiHi6BAeRu7z44MIb8VTAxeyVe7WLvjo&sensor=true">
</script>
<script type="text/javascript">
  function setupMap() {
	var lat;
	var longi;
	function locationSuccess(position) { //successful location set up
		lat = position.coords.latitude;
		longi = position.coords.longitude;
		
		var mapOptions = {
			center: new google.maps.LatLng(lat, longi),
			zoom: 16,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			streetViewControl: false,
			mapTypeControl: false,
			zoomControl: false
		};
		
		var map = new google.maps.Map(document.getElementById("map_canvas"),
			mapOptions);
	}
	
	function locationFail() { //failed location look up
		alert('Oops, could not find you.');
	}
		
		navigator.geolocation.getCurrentPosition(locationSuccess, locationFail); //get the location 
	}

	setupMap();
</script>
<div id="map_canvas" style="width:320px; height:320px;"></div> <!-- change width and height here -->

<?php include('footer.php'); ?>