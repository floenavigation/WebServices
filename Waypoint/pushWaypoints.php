<?php

    require_once 'connection.php';
    require_once 'Waypoint.php';

    header("Content-Type: text/xml");

    $waypoint = new Waypoint();

    $waypoint -> send_waypoint_data();

?>