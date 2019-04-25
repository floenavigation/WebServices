<?php

    class Waypoint {

            private $db;
            private $connection;

            function __construct(){
                $this->db = new DB_Connection();
                $this->connection = $this->db->get_connection();
                mysqli_set_charset($this->connection, 'utf8');
            }

            public function does_waypoint_exist($array){
                $latitude = $array["latitude"];
                $longitude = $array["longitude"];
                $xPosition = $array["xPosition"];
                $yPosition = $array["yPosition"];
                $update_time = $array["update_time"];
                $labelId = $array["labelId"];
                $label = $array["label"];

                //$db_update_seconds = $update_time / 1000;
                //$db_update_time = date("Y-m-d H:i:s", $db_update_seconds);
                $query = " SELECT * from waypoints where label_id = '$labelId'";

                $result = mysqli_query($this->connection, $query);
                if(mysqli_num_rows($result) > 0){
                    $query = "UPDATE waypoints SET 
                                latitude = '$latitude', 
                                longitude = '$longitude', 
                                x_position = '$xPosition', 
                                y_position = '$yPosition', 
                                update_time = '$update_time',
                                label = '$label' 
                                WHERE label_id = '$labelId'";
                    
                    $result = mysqli_query($this->connection, $query);
                    if(!$result){
                        $json['error'] = 'Error Updating Waypoint: '.$labelId; 
                    } else{
                        $json['success'] = ' Successfully updated Waypoint: '.$labelId;
                    }
                    
                } else{
                    $query = " INSERT into waypoints (latitude, longitude, x_position, y_position, update_time, ".
                                    "label_id, label) VALUES ( '$latitude', '$longitude', '$xPosition', '$yPosition', '$update_time', ".
                                    "'$labelId', '$label')"; 

                    
                    $is_inserted = mysqli_query($this->connection, $query);
                    if($is_inserted == 1){
                        $json['success'] = ' Waypoint created: '.$labelId;
                    } else{
                        $json['error'] = ' Incorrect Waypoint Data ';
                        
                    }
                }
                echo json_encode($json);
                mysqli_close($this->connection);
            }

            public function delete_waypoint_data($labelId){
                $query = "SELECT * from waypoints where label_id = '$labelId' ";
                $result = mysqli_query($this->connection, $query);
                if(mysqli_num_rows($result) > 0){
                    $query = "UPDATE waypoints set is_delete = true where label_id = '$labelId'  ";
                    $result = mysqli_query($this->connection, $query);
                    if($result){
                        $json['success'] = ' Waypoint '.$labelId.' Deleted';

                        echo json_encode($json);

                        mysqli_close($this->connection);
                    } else{
                        $json['error'] = ' Cannot delete Waypoint ';
                        echo json_encode($json);
                        mysqli_close($this->connection);
                    }
                } else{
                    $json['error'] = ' Waypoint does not exist ';
                    echo json_encode($json);
                    mysqli_close($this->connection);
                }

            }

            public function send_waypoint_data(){
                $query = "DELETE from waypoints where is_delete = true";
                $result = mysqli_query($this->connection, $query);

                $sql = "SELECT * from waypoints";
                $result = mysqli_query($this->connection, $sql);
                $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
                $xml.="<Waypoints>";
                if(mysqli_num_rows($result) > 0){
                    while ($user_row = mysqli_fetch_assoc($result)){
                        $xml.="<WAYPOINTS>";
                        foreach($user_row as $column => $value){
                            if($column != 'is_delete'){
                                $tabcolumn = strtoupper($column);
                                $xml.="<$tabcolumn>".$value."</$tabcolumn>";
                            }
                        }
                        $xml.="</WAYPOINTS>";
                    }
                $xml.="</Waypoints>";
                echo $xml;
                }
        }
    }
?>