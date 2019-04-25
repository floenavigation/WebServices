<?php

    require_once 'connection.php';
    require_once 'Station.php';

    header("Content-Type: text/xml");

    $aisstation = new Station();

    $aisstation -> send_aisstation_data();

?>