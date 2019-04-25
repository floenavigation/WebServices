<?php

    require_once 'connection.php';
    require_once 'BaseStation.php';
    
    header('Content-Type: application/json');

    $basestation = new BaseStation();
    
    if(isset($_POST['MMSI'], $_POST['AIS_STATION_NAME'], $_POST['IS_ORIGIN'])){
        $mmsi = $_POST['MMSI'];
        $stationName = $_POST['AIS_STATION_NAME'];
        $isOrigin = $_POST['IS_ORIGIN'];

        if(!empty($mmsi)){
            $basestation -> does_basestation_exist($mmsi, $stationName, $isOrigin);
        } else{
            echo json_encode(" mmsi, isOrigin and station are empty ");
        }
    } else{
        echo json_encode(" Incomplete data ");
    }
?>