<?php

if($_SERVER ["REQUEST_METHOD"]=="POST"){
    require 'connection.php';
    createUser();
}

function createUser(){

    global $connect;

    
    $username = $_POST['USERNAME'];
    $password = $_POST['PASSWORD'];


    $query = " Insert into users( user_name, password) values ( '$username', '$password');";

    mysqli_query($connect, $query) or die (mysqli_error($connect));
    mysqli_close($connect);
}


?>