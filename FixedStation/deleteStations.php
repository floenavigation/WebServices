<?php

    require_once 'connection.php';
    require_once 'FixedStation.php';

    header('Content-Type: application/json');  

    $station = new FixedStation();
    

    if(isset($_POST['MMSI'])){
        $mmsi = $_POST['MMSI'];
        
        

        if(!empty($mmsi)){          
            $station -> delete_station_data($mmsi);
        } else{
            echo json_encode(" You must fill MMSI");
        }
    } else{
        echo json_encode (" Please Provide MMSI to be Deleted");
    }
?>