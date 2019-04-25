<?php

    require_once 'config.php';

    class DB_Connection {

        private $connect;

        function __construct(){
            $this->connect = $connect = mysqli_connect(hostname, user, password, databaseName) or die("error connecting to database");
        }

        public function get_connection(){
            return $this->connect;
        }
    }


?>