$(document).ready(function() {

    var mapOptions = {
        center: { lat: 37.7489, lng: -122.4355 },
        zoom: 12
    }

    var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
});
