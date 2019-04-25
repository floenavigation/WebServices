<?php

    require_once 'connection.php';
    require_once 'SampleMeasurement.php';
    date_default_timezone_set('UTC');

    header('Content-Type: application/json');

    $sample = new SampleMeasurement();
    
    if(isset($_POST['DEVICE_ID'], $_POST['DEVICE_NAME'], $_POST['DEVICE_SHORT_NAME'], $_POST['DEVICE_TYPE']))
     {
        $deviceId =  $_POST['DEVICE_ID'];
        $deviceName =  $_POST['DEVICE_NAME'];
        $deviceShortName =  $_POST['DEVICE_SHORT_NAME'];
        $deviceType =  $_POST['DEVICE_TYPE'];

        if(!empty($deviceId)){
            //$updateTime = new DateTime($tabUpdateTime);
            $deviceArray = [
                "deviceId" => $deviceId,
                "deviceName" => $deviceName,
                "deviceShortName" => $deviceShortName,
                "deviceType" => $deviceType,
            ]; 

            $sample -> does_device_exist($deviceArray);
        } else{
            echo json_encode(" DeviceID cannot be Empty");
        }
    } else{
        echo json_encode(" Incomplete Device Data ");
    }
?>