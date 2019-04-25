<?php

    require_once 'connection.php';
    require_once 'Station.php';
    
    header('Content-Type: application/json');

    $aisstation = new Station();
    
    if(isset($_POST['MMSI'], $_POST['AIS_STATION_NAME'])){
        $mmsi = $_POST['MMSI'];
        $stationName = $_POST['AIS_STATION_NAME'];

        if(!empty($mmsi)){
            $aisstation -> does_station_exist($mmsi, $stationName);
        } else{
            echo json_encode(" mmsi & station are empty ");
        }
    } else{
        echo json_encode(" Incomplete data ");
    }
?>