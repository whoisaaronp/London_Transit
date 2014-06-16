<?php
/**
 * Created by PhpStorm.
 * User: pan
 * Date: 6/9/2014
 * Time: 4:41 PM
 */

/*#$stations        = json_decode(file_get_contents('media/stations.json'));
$stations_coords = json_decode(file_get_contents('media/stations_coords.json'));

function lookup($str) {
	$str = str_replace(' ', '+', urlencode(trim($str)));

	$target_url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $str . "+London+ON&sensor=false";

	$result = json_decode(file_get_contents($target_url));
	if ('OK' === $result->status && $result->results > 0) {
		$lat        = $result->results[0]->geometry->location->lat;
		$lng        = $result->results[0]->geometry->location->lng;
		$coordinate = array($lat, $lng);
	} else {
		$coordinate = 'null';
	}

	return $coordinate;
}

foreach ($stations_coords as $station) {

	if ('null' == $station->coord) {
		echo 'go';
		$station->coord = lookup($station->Name);
	}
}

echo file_put_contents('media/stations_coords.json', json_encode($stations_coords));*/


?>
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<title>London Transit</title>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=visualization"></script>
<script type="text/javascript" src="scripts/scripts.js"></script>
<style>
	#map_canvas {
		width: 100%;
		height: 600px;
		margin: 0 auto;
	}
</style>
</head>
<body onload="initialize()">
<div id="map_canvas"></div>
</body>
</html>
