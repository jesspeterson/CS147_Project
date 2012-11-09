<?php 
	include("header.php"); 
	$page = $_GET["page"];	
?>

<div id="wikiframe">
	<iframe seamless="seamless" src="http://en.m.wikipedia.org/wiki/<?php echo $page; ?>"></iframe>
</div>

<div data-role="footer" data-position="fixed" style="padding:3px;">
	<a href="index.php" data-role="button" data-rel="back" data-icon="arrow-l">Back</a>
</div>

<?php include("footer.php"); ?>
