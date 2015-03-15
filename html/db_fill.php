<?php

    // configuration
    require('../models/model.php');

    // load stations xml
    $xml = simplexml_load_file('http://api.bart.gov/api/stn.aspx?cmd=stns&key=MW9S-E7SL-26DU-VV8V');

    $stations = $xml->stations->station;

    // insert every stations
    foreach ($stations as $station)
    {
        query("INSERT INTO stations (abbr, name, latitude, longitude) VALUES (?, ?, ?, ?)",
            $station->abbr, $station->name, $station->gtfs_latitude, $station->gtfs_longitude);
    }

    // load routes
    $xml = simplexml_load_file('http://api.bart.gov/api/route.aspx?cmd=routes&key=MW9S-E7SL-26DU-VV8V');

    $routes = $xml->routes->route;

    foreach ($routes as $route)
    {

        // load routeinfo xml
        $routeinfo = simplexml_load_file('http://api.bart.gov/api/route.aspx?cmd=routeinfo&route=' . $route->number .
            '&key=MW9S-E7SL-26DU-VV8V');

        // find route's configuration
        $stations = $routeinfo->routes->route->config->station;

        // prepare array
        $config = [];
        foreach ($stations as $station)
        {
            $config[] = $station;
        }

        // insert route
        query("INSERT INTO routes (number, name, config) VALUES (?, ?, ?)",
            $route->number, $route->name, implode(',', $config));
    }

?>