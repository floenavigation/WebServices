<?php

    require_once 'connection.php';
    require_once 'Users.php';
    
    header('Content-Type: application/json');

    $user = new User();
    
    if(isset($_POST['USERNAME'], $_POST['PASSWORD'])){
        $username = $_POST['USERNAME'];
        $password = $_POST['PASSWORD'];

        if(!empty($username) && !empty($password)){
            $user -> does_user_exist($username, $password);
        } else{
            echo json_encode(" You must fill both fields");
        }
    } else{
        echo json_encode(" please send both fields");
    }
?>