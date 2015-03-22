<?php

    /**
     * db_fill.php
     *
     * Computer Science E-75
     * Project 2
     *
     * Nelson Reitz
     * http://github.com/nelsonreitz/project2
     *
     * Fills a MySQL database with routes and station informations
     * from BART API.
     */

    // configuration
    require('../models/model.php');

    // load stations xml
    $xml = simplexml_load_file('http://api.bart.gov/api/stn.aspx?cmd=stns&key=' . KEY);
    if ($xml === false)
    {
        trigger_error('Could not connect to BART API', E_USER_ERROR);
    }

    $stations = $xml->stations->station;

    // insert stations
    foreach ($stations as $station)
    {
        query("INSERT INTO stations (abbr, name, latitude, longitude) VALUES (?, ?, ?, ?)",
            $station->abbr, $station->name, $station->gtfs_latitude, $station->gtfs_longitude);
    }

    // load routes
    $xml = simplexml_load_file('http://api.bart.gov/api/route.aspx?cmd=routes&key=' . KEY);
    if ($xml === false)
    {
        trigger_error('Could not connect to BART API', E_USER_ERROR);
    }

    $routes = $xml->routes->route;

    foreach ($routes as $route)
    {

        // load routeinfo xml
        $routeinfo = simplexml_load_file('http://api.bart.gov/api/route.aspx?' .
            'cmd=routeinfo&route=' . $route->number . '&key=' . KEY);
        if ($routeinfo === false)
        {
            trigger_error('Could not connect to BART API', E_USER_ERROR);
        }

        // find route's configuration
        $stations = $routeinfo->routes->route->config->station;

        // build array
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
