// San Francisco coordinates
var sfCoords = new google.maps.LatLng(37.7489, -122.4355);

// declare map variables
var map;
var marker;

$(document).ready(function() {

    var mapOptions = {
        center: sfCoords,
        zoom: 12
    }

    map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

    $.ajax({
        url: "model.php",
        success: function(route) {
            $.each(route.config, function(index, station){
                addMarker(station);
            });
            addPolyline(route);
        }
    });
});

/**
 * Adds a Marker to the map at the given station's location.
 */
function addMarker(station) {

    marker = new google.maps.Marker({
        position: new google.maps.LatLng(station.latitude, station.longitude),
        map: map,
        title: station.name
    });
}

/**
 * Adds a Polyline to the map.
 */
function addPolyline(route) {

    // build an array of coordinates
    var routeCoords = [];
    $.each(route.config, function(index, station){
        routeCoords.push(new google.maps.LatLng(station.latitude, station.longitude));
    });

    var route = new google.maps.Polyline({
        path: routeCoords,
        strokeColor: "red",
    });

    route.setMap(map);
}

/**
 * Adds an Info Window to the map.
 */
function addInfoWindow() {

    var content = "<h1>Test window title</h1>"+
        "<p>Test window content paragraph</p>"

    var infowindow = new google.maps.InfoWindow({
        content: content,
    });

    google.maps.event.addListener(marker, "click", function() {
        infowindow.open(map,marker);
    });
}
