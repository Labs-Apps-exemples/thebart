<?php

    /**
     * model.php
     */

    // global constants
    define('DB_NAME', 'bart');
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'root');

    // BART's API public key
    define('KEY', 'MW9S-E7SL-26DU-VV8V');

    /**
     * Executes SQL statement, possibly with parameters, returning
     * an array of all rows in result set or false on (non-fatal) error.
     */
    function query(/* $sql [, ... ] */)
    {
        // database infos for MAMP
        $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_SERVER;

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
                $handle = new PDO($dsn, DB_USERNAME, DB_PASSWORD);

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

    /**
     * Queries route informations from cache (MySQL database).
     */
    function query_route($route_number)
    {
        $query = query("SELECT * FROM routes WHERE number = ?", $route_number);

        foreach ($query[0] as $key => $value)
        {
            if ($key === 'config')
            {
                // split stations configuration
                $config = explode(',', $value);

                foreach ($config as $station_abbr)
                {
                    // query current station
                    $query = query("SELECT * FROM stations WHERE abbr = ?", $station_abbr);

                    $station = [];
                    foreach($query[0] as $key => $value)
                    {
                        $station[$key] = $value;
                    }

                    $route['config'][] = $station;
                }
            }
            else
            {
                $route[$key] = $value;
            }
        }

        return $route;
    }

    /**
     * Queries real-time estimate time departure from BART API.
     */
    function query_etd($station_abbr) {

        // load BART API etd xml
        $xml = simplexml_load_file("http://api.bart.gov/api/etd.aspx?cmd=etd&orig=$station_abbr&key=" . KEY);

        $station = $xml->station;

        return $station;
    }

?>
