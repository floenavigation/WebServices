<?php

    require_once 'connection.php';
    require_once 'StaticStation.php';

    header("Content-Type: text/xml");

    $station = new StaticStation();

    $station -> send_station_data();

?>