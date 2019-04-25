<?php

    require_once 'connection.php';
    require_once 'FixedStation.php';

    header("Content-Type: text/xml");

    $station = new FixedStation();

    $station -> send_station_data();

?>