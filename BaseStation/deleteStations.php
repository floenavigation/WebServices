<?php

    require_once 'connection.php';
    require_once 'BaseStation.php';

    header('Content-Type: application/json');  

    $basestation = new BaseStation();
    

    if(isset($_POST['MMSI'])){
        $mmsi = $_POST['MMSI'];

        if(!empty($mmsi)){          
            $basestation -> delete_basestation_data($mmsi);
        } else{
            echo json_encode(" You must fill MMSI ");
        }
    } else{
        echo json_encode (" Please Provide MMSI to be Deleted");
    }

?>