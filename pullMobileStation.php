<?php

    require_once 'connection.php';
    require_once 'MobileStation.php';
    
    header('Content-Type: application/json');

    $mobileStation = new MobileStation();
    
    if(isset($_POST['MMSI'], $_POST['AIS_STATION_NAME'])){
        $mmsi = $_POST['MMSI'];
        $stationName = $_POST['AIS_STATION_NAME'];

        if(!empty($mmsi)){
            $mobileStation -> does_station_exist($mmsi, $stationName);
        } else{
            echo json_encode(" mmsi, isOrigin and station are empty ");
        }
    } else{
        echo json_encode(" Incomplete data ");
    }
?>