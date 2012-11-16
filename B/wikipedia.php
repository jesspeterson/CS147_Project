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
		content = content.replace(/href=\"\/wiki\//g, "data-ajax='false' href=\"wikipedia.php?source=");
		$("#wikiPage").html(content);
	});
	
	$(document).ready(function(){
		$('.noEnterSubmit').keypress(function(e){
	    	if ( e.which == 13 ) return false;
		});
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
						$("#wikisearch_results").append("<li><a data-ajax='false' href='wikipedia.php?source="+result+"'>"+result+"</a></li>")
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
		// $('#searchfield').blur(function() {
			// $("#wikisearch_results").css("display","none");
		// });
		
		// get_results("hoover");
	});

</script>

<form id="wikisearch" action="search.php" data-ajax="false" class="noEnterSubmit">
	<input id="searchfield" type="search" placeholder="Search Wikipedia" onsubmit="preventDefault();" />
</form>

<ul id="wikisearch_results" data-role="listview" style="display:none;">
</ul>

<div id="wikiPage">

</div>

<div data-role="footer" data-position="fixed" style="padding:3px;">
	<a href="index.php" data-ajax="false" data-role="button" data-rel="back" data-ajax="false" data-icon="arrow-l">Back</a>
	<a href="index.php" data-ajax="false" data-role="button" data-icon="home">Home</a>
	<a href="add.php?source=<?php echo $source; ?>" data-ajax="false" data-role="button" data-icon="plus" style="float:right;" data-transition="pop">Add Fact</a>
</div>

<?php include('footer.php'); ?>