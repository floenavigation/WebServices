<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){
    include 'connection.php';
    showUser();
}

function showUser(){
    global $connect;

    $query = " SELECT * FROM floenavigationsyncserver.users; ";
    $result = mysqli_query($connect,$query);
    $num_of_rows = mysqli_num_rows($result);
    
    $temp_array = array();

    if($num_of_rows > 0){
        while ($row = mysqli_fetch_assoc($result)){
            $temp_array[] = $row;
        }
    }

    header('Content-Type: application/json');
    echo json_encode(array("users"=>$temp_array));
    mysqli_close($connect);
}

?>