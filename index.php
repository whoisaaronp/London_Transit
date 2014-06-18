<?php

/**
 * Created by PhpStorm.
 * User: pan
 * Date: 6/9/2014
 * Time: 4:41 PM
 */
class Load_Station_Data {
	private $_stations;
	private $_path = 'media/stations/';
	private $_url = null;

	private function get_station() {
		try {
			$this->_stations = json_decode(file_get_contents($this->_url));
		} catch (Exception $e) {
			echo 'Caught exception: ', $e->getMessage(), "\n";
		}
	}

	private function set_station() {
		try {
			file_put_contents($this->_url, json_encode($this->_stations));
		} catch (Exception $e) {
			echo 'Caught exception: ', $e->getMessage(), "\n";
		}
	}

	private function lookup($str) {
		$str_filter = array(
			' '    => '+',
			'&'    => 'at',
			'of'   => 'at',
			'Stop' => '',
			'WB'   => '',
			'EB'   => '',
			'Leg'  => ''
		);
		$str        = strtr(urlencode(trim($str)), $str_filter);

		$target_url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $str . "+London+ON+CA&sensor=false";

		$result = json_decode(file_get_contents($target_url));
		if ('OK' === $result->status && $result->results > 0) {
			$lat = $result->results[0]->geometry->location->lat;
			$lng = $result->results[0]->geometry->location->lng;
			if (!in_array('political', $result->results[0]->types)) {
				$coordinate = array($lat, $lng);
			} else {
				$coordinate = null;
			}
		} else {
			$coordinate = null;
		}

		return $coordinate;
	}

	public function load($number) {
		$this->_url = $this->_path . $number . '_stations.json';
		$this->get_station();
		$station_cache = $this->_stations;
		foreach ($this->_stations as $station) {

			if (!isset($station->Coords) || null == $station->Coords) {
				echo 'go' . PHP_EOL;
				$coords          = (null != $this->lookup($station->Announcement)) ? $this->lookup($station->Announcement) : $this->lookup($station->Name);
				$station->Coords = $coords;
			}

			if (isset($station->Name)) {
				$station->Name = trim($station->Name);
			}

			if (isset($station->Announcement)) {
				$station->Announcement = trim($station->Announcement);
			}
		}
		if ($station_cache !== $this->_stations) {
			$this->set_station();
		}
	}
}


$station = new Load_Station_Data();
$station->load('17');

?>
<!DOCTYPE html>
<html ng-app>
<head lang="en">
<meta charset="UTF-8">
<title>London Transit</title>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=visualization"></script>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.0-beta.13/angular.min.js"></script>

<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>


<script type="text/javascript" src="scripts/scripts.js"></script>
<style>
	#map_canvas {
		width: 100%;
		height: 700px;
		margin: 0 auto;
	}
</style>
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<div id="map_canvas"></div>
	</div>
	<div class="row" ng-controller="switchBus">
		<form role="form">
			<div class="form-group">
				<label for="busNumber">Bus Number:{{busNumber}}</label>
				<select id="busNumber" ng-model="busNumber" ng-change="busChange()" class="form-control input-lg">
					<option ng-repeat="bus in busInfo | filter:bus.number">{{bus.number}}</option>
				</select>
			</div>
		</form>
	</div>
</div>

</body>
</html>
