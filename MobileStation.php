<?php
    class MobileStation {

            private $db;
            private $connection;

            function __construct(){
                $this->db = new DB_Connection();
                $this->connection = $this->db->get_connection();
                mysqli_set_charset($this->connection, 'utf8');
            }

            public function does_station_exist($mmsi, $stationName){
                $query = "SELECT * from ais_mobile_station where mmsi = '$mmsi' ";

                $result = mysqli_query($this->connection, $query);
                if(mysqli_num_rows($result) > 0){
                    $json['success'] = ' Station available in db '.$mmsi;
                    
                    $query = "UPDATE base_stations SET 
                                    ais_station_name = '$stationName',  
                                    WHERE mmsi = '$mmsi'";

                    $result = mysqli_query($this->connection, $query);
                    if(!$result){
                        $json['error'] = 'Error Updating Station: '.$mmsi; 
                    } else{
                        $json['success'] = ' Successfully updated Station: '.$mmsi;
                    }
                } else{
                    $query = " INSERT into ais_mobile_station (mmsi, ais_station_name) values ('$mmsi' , '$stationName')";
                    $is_inserted = mysqli_query($this->connection, $query);
                    if($is_inserted == 1){
                        $json['success'] = ' Station added : '.$mmsi;
                    } else{
                        $json['error'] = ' Incorrect Station Data ';
                    }
                    
                
                }

                echo json_encode($json);
                mysqli_close($this->connection);
            }     
    }
?>