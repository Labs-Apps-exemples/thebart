<?php

    /**
     * route.php
     *
     * Computer Science E-75
     * Project 2
     *
     * Nelson Reitz
     * http://github.com/nelsonreitz/project2
     *
     * Outputs JSON infos about a specified route.
     */

    // configuration
    require('../models/model.php');

    if (isset($_GET['route_number']))
    {
        // set MIME type
        header('Content-type: application/json');

        $route = query_route($_GET['route_number']);

        // output JSON
        print(json_encode($route));
    }
    else
    {
        print('Please specify a route');
    }

?>
