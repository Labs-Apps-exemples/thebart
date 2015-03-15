<?php

    // configuration
    require('../models/model.php');

    $station = query_etd($_GET['station_abbr']);

    // build associative array from simplexmlobject
    $departures = [];
    foreach ($station->etd as $etd)
    {
        $departure = [];
        foreach ($etd->estimate as $estimate)
        {
            $departure['destination'] = (string) $etd->destination;
            $departure['minutes'] = (string) $estimate->minutes;

            $departures[] = $departure;
        }
    }

    // sort array by each departure's minutes
    $minutes = [];
    foreach ($departures as $key => $row)
    {
        $minutes[$key] = $row['minutes'];
    }
    array_multisort($minutes, SORT_NUMERIC, $departures);

    // render schedule html
    extract(['departures' => $departures]);
    require('../views/schedule.php');

?>
