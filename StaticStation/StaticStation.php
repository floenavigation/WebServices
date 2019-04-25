<?php

    class StaticStation {

            private $db;
            private $connection;

            function __construct(){
                $this->db = new DB_Connection();
                $this->connection = $this->db->get_connection();
                mysqli_set_charset($this->connection, 'utf8');
            }

            public function does_station_exist($array){
                $name = $array["stationName"];
                $type = $array["stationType"];
                $xPosition = $array["xPosition"];
                $yPosition = $array["yPosition"];
                $alpha = $array["alpha"];
                $distance = $array["distance"];

                $query = " SELECT * from station_list where station_name = '$name' ";

                $result = mysqli_query($this->connection, $query);
                if(mysqli_num_rows($result) > 0){
                    $query = "UPDATE station_list SET
                                station_type = '$type', 
                                x_position = '$xPosition', 
                                y_position = '$yPosition', 
                                alpha = '$alpha',
                                distance = '$distance' 
                                WHERE station_name = '$name'";

                    $result = mysqli_query($this->connection, $query);
                    if(!$result){
                        $json['error'] = 'Error Updating Station: '.$name; 
                    } else{
                        $json['success'] = ' Successfully updated Station: '.$name;
                    }
                    
                } else{
                    $query = " INSERT into station_list (station_name, station_type, x_position, y_position, ".
                                    "alpha, distance) VALUES ( '$name', '$type', '$xPosition', '$yPosition', ".
                                    "'$alpha', '$distance')"; 
                    
                    $is_inserted = mysqli_query($this->connection, $query);
                    if($is_inserted == 1){
                        $json['success'] = ' Station created: '.$name;
                    } else{
                        $json['error'] = ' Incorrect Station Data ';
                        
                    }
                }
                echo json_encode($json);
                mysqli_close($this->connection);
            }

            public function delete_station_data($name){
                $query = "SELECT * from station_list where station_name = '$name' ";
                $result = mysqli_query($this->connection, $query);
                if(mysqli_num_rows($result) > 0){
                     $query = "UPDATE station_list set is_delete = true where station_name = '$name'  ";
                    $result = mysqli_query($this->connection, $query);
                    if($result){
                        $json['success'] = ' Station '.$name.' Deleted';

                        echo json_encode($json);

                        mysqli_close($this->connection);
                    } else{
                        $json['error'] = ' Cannot delete Station ';
                        echo json_encode($json);
                        mysqli_close($this->connection);
                    }
                } else{
                    $json['error'] = ' Waypoint does not exist ';
                    echo json_encode($json);
                    mysqli_close($this->connection);
                }

            }

            public function send_station_data(){
                $query = "DELETE from station_list where is_delete = true";
                $result = mysqli_query($this->connection, $query);

                $sql = "SELECT * from station_list";
                $result = mysqli_query($this->connection, $sql);
                $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
                $xml.="<Stations>";
                if(mysqli_num_rows($result) > 0){
                    while ($user_row = mysqli_fetch_assoc($result)){
                        $xml.="<STATION_LIST>";
                        foreach($user_row as $column => $value){
                            if($column != 'is_delete'){
                                $tabcolumn = strtoupper($column);
                                $xml.="<$tabcolumn>".$value."</$tabcolumn>";
                            }
                        }
                        $xml.="</STATION_LIST>";
                    }
                $xml.="</Stations>";
                echo $xml;
                }
        }
    }
?>