<?php

    require_once 'connection.php';
    require_once 'Waypoint.php';
    date_default_timezone_set('UTC');

    header('Content-Type: application/json');

    $waypoint = new Waypoint();
    
    if(isset($_POST['LATITUDE'], $_POST['LONGITUDE'], $_POST['X_POSITION'], $_POST['Y_POSITION'],
     $_POST['UPDATE_TIME'], $_POST['LABEL_ID'], $_POST['LABEL']))
     {
        $latitude =  $_POST['LATITUDE'];
        $longitude =  $_POST['LONGITUDE'];
        $xPos = $_POST['X_POSITION'];
        $yPos = $_POST['Y_POSITION'];
        $tabUpdateTime = $_POST['UPDATE_TIME'];
        $labelId = $_POST['LABEL_ID'];
        $label = $_POST['LABEL']; 

        if(!empty($labelId) && !empty($tabUpdateTime)){
            //$updateTime = new DateTime($tabUpdateTime);
            $waypointArray = [
                "latitude" => $latitude,
                "longitude" => $longitude,
                "xPosition" => $xPos,
                "yPosition" => $yPos,
                "update_time" => $tabUpdateTime,
                "labelId" => $labelId,
                "label" => $label,
            ]; 

            $waypoint -> does_waypoint_exist($waypointArray);
        } else{
            echo json_encode(" LabelID and UpdateTime cannot be Empty");
        }
    } else{
        echo json_encode(" Incomplete Waypoint Data ");
    }
?>