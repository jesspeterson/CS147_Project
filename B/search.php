<?php
$searchterm = urlencode($_REQUEST['searchterm']);
$url="http://en.wikipedia.org/w/api.php?action=query&list=search&srsearch=".$searchterm."&srprop=timestamp&format=json"; ///&limit=3

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_USERAGENT, 'MyBot/1.0 (http://www.stanford.edu)');

$result = curl_exec($ch);

if (!$result) {
  exit('cURL Error: '.curl_error($ch));
}

print (substr($result,0,-1));
?>

