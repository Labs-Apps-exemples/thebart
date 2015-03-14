<?php

    /**
     * model.php
     */

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

    function query_route()
    {
        $query = query("SELECT * FROM routes WHERE number = ?", 1);

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

?>
