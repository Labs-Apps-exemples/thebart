<?php

    // configuration
    require('../models/model.php');

    // load stations xml
    $xml = simplexml_load_file('http://api.bart.gov/api/stn.aspx?cmd=stns&key=' . KEY);

    $stations = $xml->stations->station;

    // insert every stations
    foreach ($stations as $station)
    {
        query("INSERT INTO stations (abbr, name, latitude, longitude) VALUES (?, ?, ?, ?)",
            $station->abbr, $station->name, $station->gtfs_latitude, $station->gtfs_longitude);
    }

    // load routes
    $xml = simplexml_load_file('http://api.bart.gov/api/route.aspx?cmd=routes&key=' . KEY);

    $routes = $xml->routes->route;

    foreach ($routes as $route)
    {

        // load routeinfo xml
        $routeinfo = simplexml_load_file('http://api.bart.gov/api/route.aspx?cmd=routeinfo&route=' . $route->number .
            '&key=' . KEY);

        // find route's configuration
        $stations = $routeinfo->routes->route->config->station;

        // prepare array
        $config = [];
        foreach ($stations as $station)
        {
            $config[] = $station;
        }

        // insert route
        query("INSERT INTO routes (number, name, color, config) VALUES (?, ?, ?, ?)",
            $route->number, $route->name, $route->color, implode(',', $config));
    }

?>
