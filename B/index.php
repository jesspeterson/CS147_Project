<?php
	setcookie('wikitour_version','b');
	date_default_timezone_set('America/Los_Angeles');
	setcookie('wikitour_time',date("Y-m-d H:i:sP"));
?>
<?php include('header.php'); ?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwiHi6BAeRu7z44MIb8VTAxeyVe7WLvjo&sensor=true">
</script>

<div id="map_canvas" style="width:320px; height:285px;"></div> <!-- change width and height here -->

<div id="slider" class="swipe">
	<ul>
		<li style="display:block;"><div><p onclick="location.reload(true);">Welcome to Wikitour! Click a pin to start exploring.</p></div></li>
	</ul>
</div>

<nav>
    <span id='position'></span>
    <span id='navlinks'></span>
</nav>

<div id="wikibutton"><a data-role="button" data-ajax="false" href="wikipedia.php?source=Main_Page">Add Facts from Wikipedia</a></div>

<script type="text/javascript">
$(document).ready(function(){

	
  //the following sets up the map, pins, etc.
  var addresses;
  var map;
  var last_marker;
	function setupMap() {
		navigator.geolocation.getCurrentPosition(locationSuccess, locationFail); //get the location 
	}
	function locationSuccess(position) { //successful location set up
		// var lat = "37.4307151";
		// 	var long ="-122.1733189";
	
		var lat = position.coords.latitude; //my location
		var long = position.coords.longitude;

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
			// console.log(addresses);
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
	
	function getPropertyCount(obj) {
	    var count = 0,
	        key;

	    for (key in obj) {
	        if (obj.hasOwnProperty(key)) {
	            count++;
	        }
	    }

	    return count;
	}
	
	function showFacts(e){
		if(typeof last_marker != 'undefined'){
			last_marker.setIcon("red-dot.png"); //we set the last one back to red
		}
		last_marker = this; // save the current marker
		this.setIcon("blue-dot.png"); //and then set it to blue, for now
		
		// console.log(addresses);
		$("#slider ul").html(""); //clear out previous
		address = addresses[this.address];
		// console.log(address);
		var i = 0;
		for(key in address){
			fact = address[key];
			if(i==0){
				$("#slider ul").append("<li style='display:block;'><div><a data-transition='slide' href='fact.php?id="+fact["id"]+"'><p>"+fact['fact']+" <span class='more'>more</span></p></a></div></li>")
			}else {
				$("#slider ul").append("<li style='display:none;'><div><a data-transition='slide' href='fact.php?id="+fact["id"]+"'><p>"+fact['fact']+" <span class='more'>more</span></p></a></div></li>")
			}
			i++;
		}
		$("#position").html("");
		$("#position").append("<em class='on'>&bull;</em>");
   	while($("#position").children().size() < $("#slider ul").children().size()){
		$("#position").append("<em>&bull;</em>");
	}
	$("#navlinks").html("<a href='#' id='prev' onclick='slider.prev();return false;'>prev</a><a href='#' id='next' onclick='slider.next();return false;'>next</a>");
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
	}
	
	setupMap();
	

});
</script>
<script src='swipe.js'></script>
<script>
	var slider, bullets;
	$(document).ready(function(){
	 	slider = new Swipe(document.getElementById('slider'), {
      	callback: function(e, pos) {
		
        // var i = bullets.length;
        //       while (i--) {
        //         bullets[i].className = ' ';
        //       }
        //       bullets[pos].className = 'on';

      }
    }),
    bullets = document.getElementById('position').getElementsByTagName('em');
	});
</script>
<?php include('footer.php'); ?>