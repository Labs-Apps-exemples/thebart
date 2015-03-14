// San Francisco coordinates
var sfCoords = new google.maps.LatLng(37.7489, -122.4355);

// declare map variables
var map;
var infowindow;

$(document).ready(function() {

    var mapOptions = {
        center: sfCoords,
        zoom: 12
    }

    // create new map
    map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

    $("#route_form").submit(function() {

        // redraw map (should just remove all overlay)
        map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

        var routeNumber = $("#route_select").val();

        // query route infos via ajax
        $.ajax({
            url: "route.php",
            data: {
                route_number: routeNumber
            },
            success: function(route) {

                $.each(route.config, function(index, station){
                    addMarker(station);
                });
                addPolyline(route);
            }
        });

        return false;
    });
});

/**
 * Adds a Marker and corresponding infowindow to the map at the given station's location.
 */
function addMarker(station) {

    // create new marker at station location
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(station.latitude, station.longitude),
        map: map,
        title: station.name
    });

    // prepare content for infowindow
    var content = "<h1>" + station.name + "</h1>" + "<p>" + station.abbr + "</p>";

    // create new infowindow on click on marker
    google.maps.event.addListener(marker, "click", function() {

        // close opened infowindows
        if (infowindow) {
            infowindow.close();
        }

        // create new infowindow
        infowindow = new google.maps.InfoWindow({
            content: content,
        });

        infowindow.open(map, marker);
    });
}

/**
 * Adds a Polyline to the map.
 */
function addPolyline(route) {

    // build an array of route config coordinates
    var routeCoords = [];
    $.each(route.config, function(index, station){
        routeCoords.push(new google.maps.LatLng(station.latitude, station.longitude));
    });

    // create new polyline
    var route = new google.maps.Polyline({
        path: routeCoords,
        strokeColor: "red",
    });

    route.setMap(map);
}
