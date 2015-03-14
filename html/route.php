<?php

    // configuration
    require('../models/model.php');

    // set MIME type
    header('Content-type: application/json');

    $route = query_route();

    // output JSON
    print(json_encode($route));

?>
