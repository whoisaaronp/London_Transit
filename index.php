<?php
/**
 * Created by PhpStorm.
 * User: pan
 * Date: 6/9/2014
 * Time: 4:41 PM
 */


/*$stations = json_decode(file_get_contents('media/stations/21_stations.json'));
$coords   = json_decode(file_get_contents('media/coords/21_coords.json'));
function lookup($str) {
	$str_filter = array(
		' ' => '+',
		'&' => 'at'
	);
	$str        = strtr(urlencode(trim($str)), $str_filter);

	$target_url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $str . "+London+ON&sensor=false";

	$result = json_decode(file_get_contents($target_url));
	if ('OK' === $result->status && $result->results > 0) {
		$lat        = $result->results[0]->geometry->location->lat;
		$lng        = $result->results[0]->geometry->location->lng;
		$coordinate = array($lat, $lng);
	} else {
		$coordinate = null;
	}

	return $coordinate;
}


foreach ($stations as $station) {

	if (!isset($station->Coords) || 1 != $station->Coords) {
		echo 'go' . PHP_EOL;
		$coords          = lookup($station->Name) ? lookup($station->Name) : lookup($station->Announcement);
		$station->Coords = $coords;
	}

	if (isset($station->Name)) {
		$station->Name = trim($station->Name);
	}

	if (isset($station->Announcement)) {
		$station->Announcement = trim($station->Announcement);
	}
}

echo file_put_contents('media/stations/21_stations.json', json_encode($stations));*/

?>
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<title>London Transit</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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
<body>
<div id="map_canvas"></div>
</body>
</html>
