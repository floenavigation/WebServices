<?php

    require_once 'connection.php';
    require_once 'Station.php';

    header('Content-Type: application/json');  

    $aisstation = new Station();
    

    if(isset($_POST['MMSI'])){
        $mmsi = $_POST['MMSI'];

        if(!empty($mmsi)){          
            $aisstation -> delete_aisstation_data($mmsi);
        } else{
            echo json_encode(" You must fill MMSI ");
        }
    } else{
        echo json_encode (" Please Provide MMSI to be Deleted");
    }

?>