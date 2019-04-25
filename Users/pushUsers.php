<?php

    require_once 'connection.php';
    require_once 'Users.php';

    header("Content-Type: text/xml");

    $user = new User();

    $user -> send_user_data();

?>