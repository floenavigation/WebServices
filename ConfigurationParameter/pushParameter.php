<?php

    require_once 'connection.php';
    require_once 'ConfigurationParameter.php';

    header("Content-Type: text/xml");

    $parameter = new ConfigurationParameter();

    $parameter -> send_parameter();

?>