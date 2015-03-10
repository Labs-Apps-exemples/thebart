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

    addMarker();
    addPolyline();
    addInfoWindow();
});

/**
 * Adds a Marker to the map.
 */
function addMarker() {

    marker = new google.maps.Marker({
        position: sfCoords,
        map: map,
        title: "San Francisco"
    });
}

/**
 * Adds a Polyline to the map.
 */
function addPolyline() {

    // Random Coordinates for polyline test
    var testCoords = [
        sfCoords,
        new google.maps.LatLng(37.7902, -122.4704),
        new google.maps.LatLng(37.7934, -122.4041)
    ];

    var testRoute = new google.maps.Polyline({
        path: testCoords,
        strokeColor: "red",
    });

    testRoute.setMap(map);
}

/**
 * Adds an Info Window to the map.
 */
function addInfoWindow() {

    var testContent = "<h1>Test window title</h1>"+
        "<p>Test window content paragraph</p>"

    var infowindow = new google.maps.InfoWindow({
        content: testContent,
    });

    google.maps.event.addListener(marker, "click", function() {
        infowindow.open(map,marker);
    });
}
