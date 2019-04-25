<?php

    require_once 'connection.php';
    require_once 'StaticStation.php';

    header('Content-Type: application/json');  

    $station = new StaticStation();
    

    if(isset($_POST['STATION_NAME'])){
        $name = $_POST['STATION_NAME'];
        
        

        if(!empty($name)){          
            $station -> delete_station_data($name);
        } else{
            echo json_encode(" You must fill StationName");
        }
    } else{
        echo json_encode (" Please Provide Station Name to be Deleted");
    }
?>