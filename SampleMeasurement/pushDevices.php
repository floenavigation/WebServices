<?php

    require_once 'connection.php';
    require_once 'SampleMeasurement.php';

    header("Content-Type: text/xml");

    $sample = new SampleMeasurement();

    $sample -> send_device_data();

?>