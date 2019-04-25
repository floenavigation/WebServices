<?php

    require_once 'connection.php';
    require_once 'SampleMeasurement.php';
    date_default_timezone_set('UTC');

    header('Content-Type: application/json');

    $sample = new SampleMeasurement();
    
    if(isset($_POST['DEVICE_ID'], $_POST['DEVICE_NAME'], $_POST['DEVICE_SHORT_NAME'], $_POST['OPERATION'], $_POST['DEVICE_TYPE'],
        $_POST['LATITUDE'], $_POST['LONGITUDE'], $_POST['X_POSITION'], $_POST['Y_POSITION'],
        $_POST['UPDATE_TIME'], $_POST['LABEL_ID'], $_POST['COMMENT'], $_POST['LABEL']))
     {
        $deviceId =  $_POST['DEVICE_ID'];
        $deviceName =  $_POST['DEVICE_NAME'];
        $deviceShortName =  $_POST['DEVICE_SHORT_NAME'];
        $operation =  $_POST['OPERATION'];
        $deviceType =  $_POST['DEVICE_TYPE'];
        $latitude =  $_POST['LATITUDE'];
        $longitude =  $_POST['LONGITUDE'];
        $xPos = $_POST['X_POSITION'];
        $yPos = $_POST['Y_POSITION'];
        $tabUpdateTime = $_POST['UPDATE_TIME'];
        $labelId = $_POST['LABEL_ID'];
        $comment = $_POST['COMMENT'];
        $label = $_POST['LABEL']; 

        if(!empty($labelId) && !empty($tabUpdateTime)){
            //$updateTime = new DateTime($tabUpdateTime);
            $sampleArray = [
                "deviceId" => $deviceId,
                "deviceName" => $deviceName,
                "deviceShortName" => $deviceShortName,
                "operation" => $operation,
                "deviceType" => $deviceType,
                "latitude" => $latitude,
                "longitude" => $longitude,
                "xPosition" => $xPos,
                "yPosition" => $yPos,
                "update_time" => $tabUpdateTime,
                "labelId" => $labelId,
            	"comment" => $comment,
                "label" => $label,
            ]; 

            $sample -> does_sample_exist($sampleArray);
        } else{
            echo json_encode(" LabelID and UpdateTime cannot be Empty");
        }
    } else{
        echo json_encode(" Incomplete Sample Data ");
    }
?>