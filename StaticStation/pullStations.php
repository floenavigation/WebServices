<?php

    require_once 'connection.php';
    require_once 'StaticStation.php';

    header('Content-Type: application/json');

    $station = new StaticStation();
    
    if(isset($_POST['STATION_NAME'], $_POST['STATION_TYPE'], $_POST['X_POSITION'], $_POST['Y_POSITION'],
     $_POST['ALPHA'], $_POST['DISTANCE']))
     {
        $stationName =  $_POST['STATION_NAME'];
        $stationType =  $_POST['STATION_TYPE'];
        $xPos = $_POST['X_POSITION'];
        $yPos = $_POST['Y_POSITION'];
        $alpha = $_POST['ALPHA'];
        $distance = $_POST['DISTANCE'];

        if(!empty($stationName)){
            //$updateTime = new DateTime($tabUpdateTime);
            $stationArray = [
                "stationName" => $stationName,
                "stationType" => $stationType,
                "xPosition" => $xPos,
                "yPosition" => $yPos,
                "alpha" => $alpha,
                "distance" => $distance,
            ]; 

            $station -> does_station_exist($stationArray);
        } else{
            echo json_encode(" LabelID and UpdateTime cannot be Empty");
        }
    } else{
        echo json_encode(" Incomplete Station Data ");
    }
?>