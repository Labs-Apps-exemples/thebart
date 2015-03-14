<?php

    // configuration
    require('../models/model.php');

    // set MIME type
    header('Content-type: application/json');

    $route = query_route($_GET['route_number']);

    // output JSON
    print(json_encode($route));

?>
