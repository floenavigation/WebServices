<?php

    require_once 'connection.php';
    require_once 'ConfigurationParameter.php';

    header('Content-Type: application/json');

    $config = new ConfigurationParameter();
    
    if(isset($_POST['PARAMETER_NAME'], $_POST['PARAMETER_VALUE'])){
        $name = $_POST['PARAMETER_NAME'];
        $value = $_POST['PARAMETER_VALUE'];

        if(!empty($name) && !empty($value)){
            $config -> does_parameter_exist($name, $value);
        } else{
            echo json_encode(" Parameter Name and Value are empty ");
        }
    } else{
        echo json_encode(" Incomplete data ");
    }
?>