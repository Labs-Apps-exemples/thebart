<?php

    // configuration
    require('../models/model.php');

    $station = query_etd($_GET['station_abbr']);

    // render schedule html
    extract(['station' => $station]);
    require('../views/schedule.php');

?>
