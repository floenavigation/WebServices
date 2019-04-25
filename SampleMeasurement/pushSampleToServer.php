<?php

    require_once 'connection.php';
    require_once 'SampleMeasurement.php';


    $sample = new SampleMeasurement();

    $sample -> send_sample_data_to_server();

?>