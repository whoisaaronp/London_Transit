/**
 * Created by pan on 6/9/2014.
 */
jQuery(document).ready(function ($) {
	var markers = [];

	var _url = '/media/stations/21_stations.json';
	$.get(_url, function (data) {
		markers = data;
		initialize(markers);
	});
});

//Take Number 7 of Route 21 as example

function initialize(markers) {
	var _paths = [];
	var _map = new google.maps.Map(document.getElementById("map_canvas"),
		{
			center : new google.maps.LatLng(42.9929761, -81.2514245, 14),
			zoom   : 13
		});
	for (var i = 0; i < markers.length; i++) {
		if (markers[i].Coords) {
			var mapMarkers = new google.maps.Marker(
				{
					position : new google.maps.LatLng(markers[i].Coords[0], markers[i].Coords[1]),
					map      : _map,
					title    : markers[i].Announcement
				}
			);

			var _path = [markers[i].Coords[0], markers[i].Coords[1]];
			if (!containsArray(_path, _paths)) {
				_paths.push(_path);
			}



		}

	}
	_paths = converToPath(_paths);
	console.log(_paths);
	var lineSymbol = {
		path        : google.maps.SymbolPath.CIRCLE,
		scale       : 8,
		strokeColor : '#393'
	};

	line = new google.maps.Polyline({
		path  : _paths,
		icons : [
			{
				icon   : lineSymbol,
				offset : '100%'
			}
		],
		map   : _map
	});
	animateCircle();
}

function converToPath(_paths) {
	var _newPaths = [];
	for (var i = 0; i < _paths.length; i++) {
		_newPaths.push(new google.maps.LatLng(_paths[i][0], _paths[i][1]));
	}
	return _newPaths;
}

function animateCircle() {
	var count = 0;
	window.setInterval(function () {
		count = (count + 1) % 200;

		var icons = line.get('icons');
		icons[0].offset = (count / 2) + '%';
		line.set('icons', icons);
	}, 200);
}

function containsArray(array, list) {
	var i;
	for (i = 0; i < list.length; i++) {
		if (arraysEqual(list[i], array)) {
			return true;
		}
	}

	return false;
}

function arraysEqual(a, b) {
	if (a === b) return true;
	if (a == null || b == null) return false;
	if (a.length != b.length) return false;

	// If you don't care about the order of the elements inside
	// the array, you should sort both arrays here.

	for (var i = 0; i < a.length; ++i) {
		if (a[i] !== b[i]) return false;
	}
	return true;
}
