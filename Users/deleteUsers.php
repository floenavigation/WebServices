<?php

    require_once 'connection.php';
    require_once 'Users.php';

    header('Content-Type: application/json');  

    $user = new User();
    

    if(isset($_POST['username'])){
        $username = $_POST['username'];
        
        

        if(!empty($username)){          
            $user -> delete_user_data($username);
        } else{
            echo json_encode(" You must fill UserName");
        }
    }
?>