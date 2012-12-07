<?php include('header.php'); ?>

<form id="wikisearch" action="search.php" data-ajax="false" class="noEnterSubmit">
	<input id="searchfield" type="search" placeholder="Search Wikipedia" onsubmit="preventDefault();" />
</form>

<ul id="wikisearch_results" data-role="listview" style="display:none;">
</ul>

<div id="map_canvas" style="width:320px; height:285px;"></div> <!-- change width and height here -->

<div id="slider" class="swipe">
	<ul>
		<li style="display:block;"><div><p onclick="location.reload(true);">Welcome to Wikitour! Click a pin to start exploring, or pin new facts to your location by searching for relevant articles on Wikipedia.</p></div></li>
	</ul>
</div>

<nav>
    <span id='position'></span>
    <span id='navlinks'></span>
</nav>
<script type="text/javascript">
$(document).ready(function(){
	$('.noEnterSubmit').keypress(function(e){
	    if ( e.which == 13 ) return false;
	});
	
    //the following sets up the map, pins, etc.
	var addresses;
	var map;
	var last_marker;
	
	var location_timeout = setTimeout(function(){locationFail();}, 1000);
	
	function setupMap() {
		console.log("setupmap");
		if (navigator.geolocation)
	    {
			console.log('defined');
			navigator.geolocation.getCurrentPosition(locationSuccess, locationFail); //get the location 
	    } else{
			console.log('undefined');
			locationFail();
		}
	}	

	function locationSuccess(position) { //successful location set up
		clearTimeout(location_timeout);
		console.log('location success');
		load_map(position.coords.latitude,position.coords.longitude)
	}
	
	function locationFail() { //failed location look up
		clearTimeout(location_timeout);
		var lat = "37.426295";
		var long ="-122.171893";
		load_map(lat,long)
		console.log("couldn't find you");
	}
	
	function load_map(lat,long){
		var mapOptions = { //map options
			center: new google.maps.LatLng(lat, long),
			zoom: 16,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			streetViewControl: false,
			mapTypeControl: false,
			zoomControl: false
		};
		
		map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
		
		//locate yourself on map
			var latlong = new google.maps.LatLng(lat, long);
			var marker = new google.maps.Marker({
			    position: latlong, 
			    map: map, 
			    title:"",
				icon:"blue_dot_circle.png"
			});
		
		$.ajax({ //look up facts
		  type: "POST",
		  url: "nearby_facts.php",
		  data: { lat: lat, long: long }
		}).done(function( addresses_json ) {
			addresses = jQuery.parseJSON(addresses_json);
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
		var latlong = new google.maps.LatLng(lat, long);
		var marker = new google.maps.Marker({
		    position: latlong, 
		    map: map, 
		    title:"",
			address:address,
			// addresses:addresses
		});
		google.maps.event.addListener(marker, 'click', showFacts);
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
	//$("#navlinks").html("<a href='#' id='prev' onclick='slider.prev();return false;'>prev</a><a href='#' id='next' onclick='slider.next();return false;'>next</a>");
  
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
	//this is the code to setup the wikisearch, autocompletion, etc
	function get_results(searchterm){
		var results;
		$.ajax({ //look up facts
			  type: "GET",
			  url: "search.php",
			  data: { "searchterm": searchterm,}
			}).done(function( json_results ) {
				results = jQuery.parseJSON(json_results);
				results = results["query"]["search"];

				$("#wikisearch_results").html("");
				$("#wikisearch_results").css("display","block");
				for (key in results){
					result = results[key]["title"];
					$("#wikisearch_results").append("<li><a href='wikipedia.php?source="+result+"'>"+result+"</a></li>")
				}
				$("#wikisearch_results").listview('refresh');
				
			});
	}
	
	$('#searchfield').keyup(function() {
		if($('#searchfield').val() == ''){
			$("#wikisearch_results").css("display","none");
			return;
		}
		get_results($('#searchfield').val());
	});
	
	$('.ui-input-clear').on('click', function(e){ //the clear search button
	    $("#wikisearch_results").css("display","none");
	});
	
	setupMap();
	// map = new google.maps.Map(document.getElementById("map_canvas"));
	
	
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