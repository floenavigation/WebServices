<?php

    require_once 'connection.php';
    require_once 'BaseStation.php';

    header("Content-Type: text/xml");

    $basestation = new BaseStation();

    $basestation -> send_basestation_data();

?>