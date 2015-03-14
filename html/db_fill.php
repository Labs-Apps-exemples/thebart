<?php

    /**
     * Executes SQL statement, possibly with parameters, returning
     * an array of all rows in result set or false on (non-fatal) error.
     */
    function query(/* $sql [, ... ] */)
    {
        // database infos for MAMP
        $dsn = 'mysql:dbname=bart;host=localhost';
        $username = 'root';
        $password = 'root';

        // SQL statement
        $sql = func_get_arg(0);

        // parameters, if any
        $parameters = array_slice(func_get_args(), 1);

        // try to connect to database
        static $handle;
        if (!isset($handle))
        {
            try
            {
                // connect to database
                $handle = new PDO($dsn, $username, $password);

                // ensure that PDO::prepare returns false when passed invalid SQL
                $handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            }
            catch (Exception $e)
            {
                // trigger (big, orange) error
                trigger_error($e->getMessage(), E_USER_ERROR);
                exit;
            }
        }

        // prepare SQL statement
        $statement = $handle->prepare($sql);
        if ($statement === false)
        {
            // trigger (big, orange) error
            trigger_error($handle->errorInfo()[2], E_USER_ERROR);
            exit;
        }

        // execute SQL statement
        $results = $statement->execute($parameters);

        // return result set's rows, if any
        if ($results !== false)
        {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

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
