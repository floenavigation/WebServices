<?php

    require_once 'connection.php';
    require_once 'Waypoint.php';

    header('Content-Type: application/json');  

    $waypoint = new Waypoint();
    

    if(isset($_POST['LABEL_ID'])){
        $labelId = $_POST['LABEL_ID'];
        
        

        if(!empty($labelId)){          
            $waypoint -> delete_waypoint_data($labelId);
        } else{
            echo json_encode(" You must fill LabelId");
        }
    } else{
        echo json_encode (" Please Provide labelId to be Deleted");
    }
?>