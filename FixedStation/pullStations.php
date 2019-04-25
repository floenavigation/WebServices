<?php

    require_once 'connection.php';
    require_once 'FixedStation.php';
    date_default_timezone_set('UTC');

    header('Content-Type: application/json');

    $station = new FixedStation();
    
    if(isset($_POST['AIS_STATION_NAME'], $_POST['LATITUDE'], $_POST['LONGITUDE'],
     $_POST['RECEIVED_LATITUDE'], $_POST['RECEIVED_LONGITUDE'], $_POST['ALPHA'], 
     $_POST['DISTANCE'], $_POST['X_POSITION'], $_POST['Y_POSITION'], $_POST['STATION_TYPE'], 
     $_POST['UPDATE_TIME'], $_POST['SPEED_OVER_GROUND'], $_POST['COURSE_OVER_GROUND'], 
     $_POST['LAST_RECEIVED_PACKET_TYPE'], $_POST['IS_POSITION_PREDICTED'], 
     $_POST['PREDICTION_ACCURACY'], $_POST['IS_LOCATION_RECEIVED'], $_POST['MMSI']))
     {
        $mmsi = $_POST['MMSI'];
        $station_name = $_POST['AIS_STATION_NAME'];
        $latitude =  $_POST['LATITUDE'];
        $longitude =  $_POST['LONGITUDE'];
        $rcvdLat = $_POST['RECEIVED_LATITUDE'];
        $rcvdLon = $_POST['RECEIVED_LONGITUDE'];
        $alpha =  $_POST['ALPHA']; 
        $distance = $_POST['DISTANCE'];
        $xPos = $_POST['X_POSITION'];
        $yPos = $_POST['Y_POSITION'];
        $stationType = $_POST['STATION_TYPE']; 
        $tabUpdateTime = $_POST['UPDATE_TIME'];
        $sog = $_POST['SPEED_OVER_GROUND'];
        $cog = $_POST['COURSE_OVER_GROUND']; 
        $packetType = $_POST['LAST_RECEIVED_PACKET_TYPE'];
        $isPredicted = $_POST['IS_POSITION_PREDICTED']; 
        $predictionAccuracy = $_POST['PREDICTION_ACCURACY'];
        $isLocationReceived = $_POST['IS_LOCATION_RECEIVED']; 

        if(!empty($mmsi) && !empty($tabUpdateTime)){
            //$updateTime = new DateTime($tabUpdateTime);
            $stationArray = [
                "ais_station_name" => $station_name,
                "latitude" => $latitude,
                "longitude" => $longitude,
                "rcvdLatitude" => $rcvdLat,
                "rcvdLongitude" => $rcvdLon,
                "alpha" => $alpha,
                "distance" => $distance,
                "xPosition" => $xPos,
                "yPosition" => $yPos,
                "station_type" => $stationType,
                "update_time" => $tabUpdateTime,
                "sog" => $sog,
                "cog" => $cog,
                "packetType" => $packetType,
                "isPredicted" => $isPredicted,
                "predictionAccuracy" => $predictionAccuracy,
                "isLocationReceived" => $isLocationReceived,
                "mmsi" => $mmsi,
            ]; 

            $station -> does_station_exist($stationArray);
        } else{
            echo json_encode(" MMSI and UpdateTime cannot be Empty");
        }
    } else{
        echo json_encode(" Incomplete Fixed Station Data ");
    }
?>