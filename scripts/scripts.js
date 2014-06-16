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

	var _map = new google.maps.Map(document.getElementById("map_canvas"),
		{
			center : new google.maps.LatLng(42.9929761, -81.2514245, 14),
			zoom   : 13
		});
	for (var i = 0; i < markers.length; i++) {
		console.log(markers[i]);
		if (markers[i].Coords) {
			var mapMarkers = new google.maps.Marker(
				{
					position : new google.maps.LatLng(markers[i].Coords[0], markers[i].Coords[1]),
					map      : _map,
					title    : markers[i].Announcement
				}
			);
		}

	}

}



