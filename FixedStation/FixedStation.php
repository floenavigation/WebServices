<?php

    class FixedStation {

            private $db;
            private $connection;

            function __construct(){
                $this->db = new DB_Connection();
                $this->connection = $this->db->get_connection();
                mysqli_set_charset($this->connection, 'utf8');
            }

            public function does_station_exist($array){
                $station_name = $array["ais_station_name"];
                $latitude = $array["latitude"];
                $longitude = $array["longitude"];
                $rcvdLatitude = $array["rcvdLatitude"];
                $rcvdLongitude = $array["rcvdLongitude"];
                $alpha = $array["alpha"];
                $distance = $array["distance"];
                $xPosition = $array["xPosition"];
                $yPosition = $array["yPosition"];
                $station_type = $array["station_type"];
                $update_time = $array["update_time"];
                $sog = $array["sog"];
                $cog = $array["cog"];
                $packetType = $array["packetType"];
                $isPredicted = $array["isPredicted"];
                $predictionAccuracy = $array["predictionAccuracy"];
                $isLocationReceived = $array["isLocationReceived"];
                $mmsi = $array["mmsi"];

                //$db_update_seconds = $update_time / 1000;
                //$db_update_time = date("Y-m-d H:i:s", $db_update_seconds);
                $query = " SELECT * from ais_fixed_station where mmsi = '$mmsi' ";

                $result = mysqli_query($this->connection, $query);
                if(mysqli_num_rows($result) > 0){
                    $serverStation = mysqli_fetch_assoc($result);
                    $serverupdateTime = $serverStation['update_time'];
                    //$existingupdateTime = new DateTime($serverupdateTime);
                    if((intval($serverupdateTime) - intval($update_time)) > 0){
                        $json['success'] = 'Server data for station '.$mmsi.' is more recent. Will not update';
                    } else{
                        $query = "UPDATE ais_fixed_station SET 
                                    ais_station_name = '$station_name', 
                                    latitude = '$latitude', 
                                    longitude = '$longitude',
                                    received_latitude = '$rcvdLatitude',
                                    received_longitude = '$rcvdLongitude',
                                    alpha = '$alpha', 
                                    distance = '$distance', 
                                    x_position = '$xPosition', 
                                    y_position = '$yPosition', 
                                    station_type = '$station_type',
                                    update_time = '$update_time',
                                    speed_over_ground = '$sog', 
                                    course_over_ground = '$cog', 
                                    last_received_packet_type = '$packetType', 
                                    is_position_predicted = '$isPredicted',
                                    prediction_accuracy = '$predictionAccuracy', 
                                    is_location_received = '$isLocationReceived' 
                                    WHERE mmsi = '$mmsi'";

                        $result = mysqli_query($this->connection, $query);
                        if(!$result){
                            $json['error'] = 'Error Updating Station: '.$mmsi; 
                        } else{
                            $json['success'] = ' Successfully updated Station: '.$mmsi;
                        }
                    }
                } else{
                    $query = " INSERT into ais_fixed_station (ais_station_name, latitude, longitude, ".
                                    "received_latitude, received_longitude, alpha, distance, x_position, ".
                                    "y_position, station_type, update_time, speed_over_ground, course_over_ground, ".
                                    "last_received_packet_type, is_position_predicted, prediction_accuracy, is_location_received, ".
                                    "mmsi) VALUES ( '$station_name', '$latitude', '$longitude','$rcvdLatitude','$rcvdLongitude', ".
                                    "'$alpha', '$distance', '$xPosition', '$yPosition', '$station_type','$update_time','$sog', '$cog', ". 
                                    "'$packetType', '$isPredicted', '$predictionAccuracy', '$isLocationReceived', '$mmsi' )";
                    
                    $is_inserted = mysqli_query($this->connection, $query);
                    if($is_inserted == 1){
                        $json['success'] = ' Station created: '.$mmsi;
                    } else{
                        $json['error'] = ' Incorrect Station Data ';
                        
                    }
                }
                echo json_encode($json);
                mysqli_close($this->connection);
            }

            public function delete_station_data($mmsi){
                $query = "SELECT * from ais_fixed_station where mmsi = '$mmsi' ";
                $result = mysqli_query($this->connection, $query);
                if(mysqli_num_rows($result) > 0){
                    $query = "UPDATE ais_fixed_station set is_delete = true where mmsi = '$mmsi'  ";
                    $result = mysqli_query($this->connection, $query);
                    if($result){
                        $json['success'] = ' Station '.$mmsi.' will be deleted';

                        echo json_encode($json);

                        mysqli_close($this->connection);
                    } else{
                        $json['error'] = ' Cannot delete AIS Station ';
                        echo json_encode($json);
                        mysqli_close($this->connection);
                    }
                } else{
                    $json['error'] = ' Station does not exist ';
                    echo json_encode($json);
                    mysqli_close($this->connection);
                }

            }

            public function send_station_data(){
                $query = "DELETE from ais_fixed_station where is_delete = true";
                $result = mysqli_query($this->connection, $query);

                $sql = "SELECT * from ais_fixed_station";
                $result = mysqli_query($this->connection, $sql);
                $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
                $xml.="<FixedStations>";
                if(mysqli_num_rows($result) > 0){
                    while ($user_row = mysqli_fetch_assoc($result)){
                        $xml.="<AIS_FIXED_STATION_POSITION>";
                        foreach($user_row as $column => $value){
                            if($column != 'is_delete'){
                                $tabcolumn = strtoupper($column);
                                $xml.="<$tabcolumn>".$value."</$tabcolumn>";
                            }
                        }
                        $xml.="</AIS_FIXED_STATION_POSITION>";
                    }
                $xml.="</FixedStations>";
                echo $xml;
                }
        }
    }
?>