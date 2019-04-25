<?php
    class Station {

            private $db;
            private $connection;

            function __construct(){
                $this->db = new DB_Connection();
                $this->connection = $this->db->get_connection();
                mysqli_set_charset($this->connection, 'utf8');
            }

            public function does_station_exist($mmsi, $stationName){
                $query = "SELECT * from ais_station_list where mmsi = '$mmsi' ";

                $result = mysqli_query($this->connection, $query);
                if(mysqli_num_rows($result) > 0){
                    $json['success'] = ' Station available in db '.$mmsi;
                    
                    $query = "UPDATE ais_station_list SET 
                                    ais_station_name = '$stationName', 
                                    WHERE mmsi = '$mmsi'";

                    $result = mysqli_query($this->connection, $query);
                    if(!$result){
                        $json['error'] = 'Error Updating Station: '.$mmsi; 
                    } else{
                        $json['success'] = ' Successfully updated Station: '.$mmsi;
                    }
                } else{
                    $query = " INSERT into ais_station_list (mmsi, ais_station_name) values ('$mmsi' , '$stationName')";
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

            public function delete_aisstation_data($mmsi){
                $query = "SELECT * from ais_station_list where mmsi = '$mmsi' ";
                $result = mysqli_query($this->connection, $query);
                if(mysqli_num_rows($result) > 0){
                    $query = "UPDATE ais_station_list set is_delete = true where mmsi = '$mmsi' ";
                    $result = mysqli_query($this->connection, $query);
                    if($result){
                        $json['success'] = ' Station '.$mmsi.' will be Deleted';
                    } else{
                        $json['error'] = ' Cannot delete AIS Station ';
                    }
                } else{
                    $json['error'] = ' Station does not exist ';
                }

                echo json_encode($json);
                mysqli_close($this->connection);

            }

            public function send_aisstation_data(){
                $query = "DELETE from ais_station_list where is_delete = true";
                $result = mysqli_query($this->connection, $query);

                $sql = "SELECT * from ais_station_list";
                $result = mysqli_query($this->connection, $sql);
                $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
                $xml.="<StationList>";
                if(mysqli_num_rows($result) > 0){
                    while ($user_row = mysqli_fetch_assoc($result)){
                        $xml.="<AIS_STATION_LIST>";
                        foreach($user_row as $column => $value){
                            if($column != 'is_delete'){
                                $tabcolumn = strtoupper($column);
                                $xml.="<$tabcolumn>".$value."</$tabcolumn>";
                            }
                        }
                        $xml.="</AIS_STATION_LIST>";
                    }
                $xml.="</StationList>";
                echo $xml;
                }
        }
    }
?>