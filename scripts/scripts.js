/**
 * Created by pan on 6/9/2014.
 */

//Take Number 7 of Route 17 as example

function initialize() {
	var mapOptions = {
		center : new google.maps.LatLng(42.9929761, -81.2514245, 14),
		zoom   : 13
	};
	var map = new google.maps.Map(document.getElementById("map_canvas"),
		mapOptions);
}

google.maps.event.addDomListener(window, 'load', initialize);

