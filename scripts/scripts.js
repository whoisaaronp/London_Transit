/**
 * Created by pan on 6/9/2014.
 */
(function(){
    var app = angular.module('app', [])
    .controller('LoadMap',function($scope, $http) {

        var interval = null;
        $scope.markers = [];
        $scope.busNumber = 17;
        $scope.busInfo = [{
            'number': 17,
            'paths': [318, 275, 276, 1632, 1342, 1353, 500, 498, 493, 494, 729, 731, 732, 784]
        }, {
            'number': 21,
            'paths': [1470, 1501, 1466, 1463, 1495, 1464, 344, 1155, 1157, 2241, 1016, 232, 230, 231, 1663, 1245, 1244, 393, 392, 1620, 1016]
        }];

        $scope.drawMap = function() {
            var busObj = getByAttr($scope.busInfo, 'number', $scope.busNumber);
            var _pathsID = busObj.paths;
            $http.get('/media/stations/' + $scope.busNumber + '_stations.json')
            .success(function(data) {
                $scope.markers = data;
                initialize($scope.markers, _pathsID);
            });
        };
       
        $scope.busChange = function() {
            $scope.busNumber = parseInt(this.busNumber);
            $scope.drawMap();
        };


        function initialize(markers, _pathsID) {
            var _paths = [],
                _markers = [];
            if (typeof(interval) != 'undefined' && interval) {
                window.clearInterval(interval);
            }
            //var _pathsID = ;

            var _map = new google.maps.Map(document.getElementById("map_canvas"), {
                center: new google.maps.LatLng(42.9929761, -81.2514245, 14),
                zoom: 13
            });
            for (var i = 0; i < markers.length; i++) {
                if (markers[i].Coords) {
                    var mapMarkers = new google.maps.Marker({
                        position: new google.maps.LatLng(markers[i].Coords[0], markers[i].Coords[1]),
                        map: _map,
                        title: markers[i].ID + ' ' + markers[i].Announcement
                    });
                    var _path = {
                        "lat": markers[i].Coords[0],
                        "lng": markers[i].Coords[1]
                    };

                    //if (!containsObj(_path, _paths)) {
                    var index = _pathsID.indexOf(markers[i].ID);
                    if (index > -1) {
                        _paths[index] = _path;

                        _markers.push(mapMarkers);
                    }
                }
            }
            console.log("Path:" + _paths);
            _paths = converToPath(_paths);

            console.log("Markders:" + _markers);
            var lineSymbol = {
                path: google.maps.SymbolPath.CIRCLE,
                scale: 8,
                strokeColor: '#393'
            };

            line = new google.maps.Polyline({
                path: _paths,
                icons: [{
                    icon: lineSymbol,
                    offset: '100%'
                }],
                map: _map
            });
            animateCircle();
        }

        function getByAttr(arr, attr, value) {
            for (var d = 0, len = arr.length; d < len; d += 1) {
                if (arr[d][attr] === value) {
                    return arr[d];
                }
            }
        }


        //Take Number 7 of Route 21 as example



        function converToPath(_paths) {
            var _newPaths = [];
            for (var i = 0; i < _paths.length; i++) {
                _newPaths.push(new google.maps.LatLng(_paths[i].lat, _paths[i].lng));
            }
            return _newPaths;
        }

        function animateCircle() {
            var count = 0;
            interval = window.setInterval(function() {
                count = (count + 1) % 200;

                var icons = line.get('icons');
                icons[0].offset = (count / 2) + '%';
                line.set('icons', icons);
            }, 200);
        }

        function containsObj(obj, list) {
            var i;
            for (i = 0; i < list.length; i++) {
                if (JSON.stringify(list[i]) === JSON.stringify(obj)) {
                    return true;
                }
            }

            return false;
        }

        function arraysEqual(a, b) {
            if (a === b) return true;
            if (a === null || b === null) return false;
            if (a.length != b.length) return false;

            // If you don't care about the order of the elements inside
            // the array, you should sort both arrays here.

            for (var i = 0; i < a.length; ++i) {
                if (a[i] !== b[i]) return false;
            }
            return true;
        }
    });


})();