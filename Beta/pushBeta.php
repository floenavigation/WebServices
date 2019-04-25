<?php

    require_once 'connection.php';
    require_once 'Beta.php';

    header("Content-Type: text/xml");

    $beta = new Beta();

    $beta -> send_beta();

?>