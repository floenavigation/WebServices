<?php
    class BaseStation {

            private $db;
            private $connection;

            function __construct(){
                $this->db = new DB_Connection();
                $this->connection = $this->db->get_connection();
                mysqli_set_charset($this->connection, 'utf8');
            }

            public function does_basestation_exist($mmsi, $stationName, $isOrigin){
                $query = "SELECT * from base_stations where mmsi = '$mmsi' ";

                $result = mysqli_query($this->connection, $query);
                if(mysqli_num_rows($result) > 0){
                    $json['success'] = ' Station available in db '.$mmsi;
                    
                    $query = "UPDATE base_stations SET 
                                    ais_station_name = '$stationName', 
                                    is_Origin = '$isOrigin', 
                                    WHERE mmsi = '$mmsi'";

                    $result = mysqli_query($this->connection, $query);
                    if(!$result){
                        $json['error'] = 'Error Updating Station: '.$mmsi; 
                    } else{
                        $json['success'] = ' Successfully updated Station: '.$mmsi;
                    }
                } else{
                    $query = " INSERT into base_stations (mmsi, ais_station_name, is_Origin) values ('$mmsi' , '$stationName', '$isOrigin')";
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
            
            public function delete_basestation_data($mmsi){
                $query = "SELECT * from base_stations where mmsi = '$mmsi' ";
                $result = mysqli_query($this->connection, $query);
                if(mysqli_num_rows($result) > 0){
                    $query = "UPDATE base_stations set is_delete = true where mmsi = '$mmsi' ";
                    $result = mysqli_query($this->connection, $query);
                    if($result){
                        $json['success'] = ' Station '.$mmsi.' will be Deleted';
                    } else{
                        $json['error'] = ' Cannot delete Base Station ';
                    }
                } else{
                    $json['error'] = ' Base Station does not exist ';
                }

                echo json_encode($json);
                mysqli_close($this->connection);

            }

            public function send_basestation_data(){
                $query = "DELETE from base_stations where is_delete = true";
                $result = mysqli_query($this->connection, $query);

                $sql = "SELECT * from base_stations";
                $result = mysqli_query($this->connection, $sql);
                $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
                $xml.="<BaseStation>";
                if(mysqli_num_rows($result) > 0){
                    while ($user_row = mysqli_fetch_assoc($result)){
                        $xml.="<BASE_STATIONS>";
                        foreach($user_row as $column => $value){
                             if($column != 'is_delete'){
                                $tabcolumn = strtoupper($column);
                                $xml.="<$tabcolumn>".$value."</$tabcolumn>";
                             }
                        }
                        $xml.="</BASE_STATIONS>";
                    }
                $xml.="</BaseStation>";
                echo $xml;
                }
        }
    }
?>