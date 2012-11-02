<?php include('header.php'); ?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwiHi6BAeRu7z44MIb8VTAxeyVe7WLvjo&sensor=true">
</script>
<script type="text/javascript">
  var addresses;
  var map;
	function setupMap() {
		navigator.geolocation.getCurrentPosition(locationSuccess, locationFail); //get the location 
	}
	function locationSuccess(position) { //successful location set up
		var lat = "37.4307151";
		var long ="-122.1733189";
	
		// var lat = position.coords.latitude; //my location
		// var long = position.coords.longitude;

		var mapOptions = { //map options
			center: new google.maps.LatLng(lat, long),
			zoom: 16,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			streetViewControl: false,
			mapTypeControl: false,
			zoomControl: false
		};
		
		map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
			
		$.ajax({ //look up facts
		  type: "POST",
		  url: "nearby_facts.php",
		  data: { lat: lat, long: long }
		}).done(function( addresses_json ) {
			addresses = jQuery.parseJSON(addresses_json);
			console.log(addresses);
			for (var key in addresses) {
				var address = addresses[key];
				for(var sub_key in address){ //this loop is designed to just grab the first address and then break
					place_marker(address[sub_key]["lat"],address[sub_key]["long"],address[sub_key]["address"]);
					break;					
				}
			}
		});
	}
	
	function place_marker(lat,long,address){
		// console.log("placing");
		var latlong = new google.maps.LatLng(lat, long);
		var marker = new google.maps.Marker({
		    position: latlong, 
		    map: map, 
		    title:"",
			address:address,
			// addresses:addresses
		});
		// console.log(address);
		google.maps.event.addListener(marker, 'click', showFacts);
	}

	function locationFail() { //failed location look up
		alert('Oops, could not find you.');
	}
	
	function showFacts(e){
		// console.log(addresses);
		$("#slider ul").html(""); //clear out previous
		address = addresses[this.address];
		// console.log(address);
		var i = 0;
		for(key in address){
			fact = address[key];
			// console.log("fact:");
			// 			console.log(fact);
			// 			console.log("length"+address.length);
			// if(i==address.keys(a).length){
				$("#slider ul").append("<li style='display:block;'><div><a href='fact.php?id="+this.id+"'><p>"+fact['fact']+"</p></a></div></li>")
				// console.log(012);
			// }else {
				// $("#slider ul").append("<li style='display:none;'><div><a href='fact.php?id="+this.id+"'><p>"+fact['fact']+"</p></a></div></li>")
				// console.log(013);
			// }
			i++;
		}
	}
	
	setupMap();
</script>


<form id="wikiSearch" action="search.php">
	<input id="searchBar" type="search" placeholder="Search Wikipedia" />
</form>

<div id="map_canvas" style="width:320px; height:220px;"></div> <!-- change width and height here -->

<!-- <form id="pinList" action="fact.php">
	<select onchange="submit()">
		<optgroup label="At this location:">
			<option value="0">Hoover Tower - tallest building on Stanford campus</option>
			<option value="1">Condoleeza Rice - has office in Hoover Tower</option>
			<option value="2">Hoover Institution - public policy think-tank based here</option>
			<option value="3">Herbert Hoover - namesake of Hoover tower</option>
		</optgroup>
	</select>
</form> -->

<div id="slider" class="swipe">
	<ul>
		<li style="display:block;"><div><a href="fact.php?id=666"><p>Completed in 1941, <strong>Hoover Tower</strong> is the tallest building on the Stanford campus at 285 feet.</p></a></div></li>
		<li style="display:none;"><div><a href="fact.php?id=667">Former Secretary of State <strong>Condoleeza Rice</strong> has an office on the tenth floor of Hoover Tower.</a></div></li>
		<li style="display:none;"><div><a href="fact.php?id=668">The <strong>Hoover Institution</strong>, a conservative public policy think tank, is housed partly in Hoover Tower.</a></div></li>
		<li style="display:none;"><div><a href="fact.php?id=669">Dissident Russian writer <strong>Aleksandr Solzhenitsyn</strong> lived on the 11th floor of Hoover Tower while exiled.</a></div></li>
	</ul>
</div>

<nav>
    <span id='position'><em class='on'>&bull;</em><em>&bull;</em><em>&bull;</em><em>&bull;</em></span>
</nav>

<script src='swipe.js'></script>
<script>
	var slider, bullets;
	$(document).ready(function(){
	 	slider = new Swipe(document.getElementById('slider'), {
      	callback: function(e, pos) {
        
        var i = bullets.length;
        while (i--) {
          bullets[i].className = ' ';
        }
        bullets[pos].className = 'on';

      }
    }),
    bullets = document.getElementById('position').getElementsByTagName('em');
	});
</script>
<?php include('footer.php'); ?>