<?php

    // configuration
    require('../models/model.php');

    $routes = query("SELECT number, name FROM routes");

    // renders index
    extract(['routes' => $routes]);
    require('../views/index.php');

?>
