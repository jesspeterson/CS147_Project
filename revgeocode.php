<?php
$latlng = $_REQUEST['latlng'];
$url="http://maps.googleapis.com/maps/api/geocode/json?latlng=".$latlng."&sensor=true";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_USERAGENT, 'MyBot/1.0 (http://www.stanford.edu)');

$result = curl_exec($ch);

if (!$result) {
  exit('cURL Error: '.curl_error($ch));
}
//print 123;
//print $latlng;
//print $url;
print (substr($result,0,-1));
?>
