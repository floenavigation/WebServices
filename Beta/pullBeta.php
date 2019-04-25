<?php

    require_once 'connection.php';
    require_once 'Beta.php';
    date_default_timezone_set('UTC');
    
    header('Content-Type: application/json');

    $beta = new Beta();
    
    if(isset($_POST['BETA'], $_POST['UPDATE_TIME'])){
        $betaValue = $_POST['BETA'];
        $tabUpdateTime = $_POST['UPDATE_TIME'];

        if(!empty($betaValue)){
            $beta -> does_beta_exist($betaValue, $tabUpdateTime);
        } else{
            echo json_encode(" beta and update time are empty ");
        }
    } else{
        echo json_encode(" Incomplete data ");
    }
?>