<?php

    class SampleMeasurement {

            private $db;
            private $connection;

            function __construct(){
                $this->db = new DB_Connection();
                $this->connection = $this->db->get_connection();
                mysqli_set_charset($this->connection, 'utf8');
            }

            public function does_sample_exist($array){
                $deviceId = $array["deviceId"];
                $deviceName = $array["deviceName"];
                $deviceShortName = $array["deviceShortName"];
                $operation = $array["operation"];
                $deviceType = $array["deviceType"];
                $latitude = $array["latitude"];
                $longitude = $array["longitude"];
                $xPosition = $array["xPosition"];
                $yPosition = $array["yPosition"];
                $update_time = $array["update_time"];
                $labelId = $array["labelId"];
                $comment = $array["comment"];
                $label = $array["label"];

                //$db_update_seconds = $update_time / 1000;
                //$db_update_time = date("Y-m-d H:i:s", $db_update_seconds);
                $query = " SELECT * from sample_measurement where label_id = '$labelId' ";

                $result = mysqli_query($this->connection, $query);
                if(mysqli_num_rows($result) > 0){
                
                    $query = "UPDATE sample_measurement SET 
                                device_id = '$deviceId',
                                device_name = '$deviceName',
                                device_short_name = '$deviceShortName',
                                operation = '$operation',
                                device_type = '$deviceType',
                                latitude = '$latitude', 
                                longitude = '$longitude', 
                                x_position = '$xPosition', 
                                y_position = '$yPosition', 
                                update_time = '$update_time',
								comment = '$comment',
                                label = '$label', 
								sent_to_DShip = 'false'
                                WHERE label_id = '$labelId'";

                    $result = mysqli_query($this->connection, $query);
                    if(!$result){
                        $json['error'] = 'Error Updating Sample: '.$labelId; 
                    } else{
                        $json['success'] = ' Successfully updated Sample: '.$labelId;
                    }
                
                } else{
                    $query = " INSERT into sample_measurement (device_id, device_name, device_short_name, operation, device_type, latitude, ".
                                    "longitude, x_position, y_position, update_time, label_id, comment, label, sent_to_DShip) VALUES ( '$deviceId', ".
                                    "'$deviceName', '$deviceShortName', '$operation', '$deviceType', '$latitude', '$longitude', ". 
                                    "'$xPosition', '$yPosition', '$update_time', '$labelId', '$comment', '$label', false)"; 
                    
                    $is_inserted = mysqli_query($this->connection, $query);
                    if($is_inserted == 1){
                        $json['success'] = ' Sample created: '.$labelId;
                    } else{
                        $json['error'] = ' Incorrect Sample Data ';
                        
                    }
                }
                echo json_encode($json);
                mysqli_close($this->connection);
            }

            // public function delete_sample_data($labelId){
            //     $query = "SELECT * from waypoints where label_id = '$labelId' ";
            //     $result = mysqli_query($this->connection, $query);
            //     if(mysqli_num_rows($result) > 0){
            //         $query = "Delete from waypoints where label_id = '$labelId' ";
            //         $result = mysqli_query($this->connection, $query);
            //         if($result){
            //             $json['success'] = ' Waypoint '.$labelId.' Deleted';

            //             echo json_encode($json);

            //             mysqli_close($this->connection);
            //         } else{
            //             $json['error'] = ' Cannot delete Waypoint ';
            //             echo json_encode($json);
            //             mysqli_close($this->connection);
            //         }
            //     } else{
            //         $json['error'] = ' Waypoint does not exist ';
            //         echo json_encode($json);
            //         mysqli_close($this->connection);
            //     }

            // }

            public function send_sample_data_to_server(){
            	$sent_to_DShip = false;
                $sql = "SELECT label FROM sample_measurement WHERE sent_to_DShip = false";
                //echo $sql;
                $result = mysqli_query($this->connection, $sql);
                $csv = "";
                if(mysqli_num_rows($result) > 0){
                    while ($user_row = mysqli_fetch_assoc($result)){
                        foreach($user_row as $column => $value){
                            $csv.=$value."\r\n";
                        } 
                    }
                $myfile = fopen("samples.csv", "w") or die("Unable to open file!");
                fwrite($myfile, $csv);
                fclose($myfile);
                
                echo $csv;
                $query = "UPDATE sample_measurement SET
                            	sent_to_DShip = true
                            	WHERE sent_to_DShip = false";
                $update = mysqli_query($this->connection, $query);
//                 if(!$update){
//                     $json['error'] = 'Error Updating Sample';
//                 } else{
//                     $json['success'] = ' Successfully updated Sample ';
//                 }
//                 echo json_encode($json);
                mysqli_close($this->connection);
               }
        }

        public function send_device_data(){
                $sql = "SELECT * from device_list";
                $result = mysqli_query($this->connection, $sql);
                $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
                $xml.="<Devices>";
                if(mysqli_num_rows($result) > 0){
                    while ($user_row = mysqli_fetch_assoc($result)){
                        $xml.="<DEVICE_LIST>";
                        foreach($user_row as $column => $value){
                            $tabcolumn = strtoupper($column);
                            $xml.="<$tabcolumn>".$value."</$tabcolumn>";
                        }
                        $xml.="</DEVICE_LIST>";
                    }
                $xml.="</Devices>";
                echo $xml;
                mysqli_close($this->connection);
                }
        }

        public function does_device_exist($array){
                $deviceId = $array["deviceId"];
                $deviceName = $array["deviceName"];
                $deviceShortName = $array["deviceShortName"];
                $deviceType = $array["deviceType"];

                $query = " SELECT * from device_list where device_id = '$deviceId' ";

                $result = mysqli_query($this->connection, $query);
                if(mysqli_num_rows($result) > 0){
                    $query = "UPDATE device_list SET 
                                device_name = '$deviceName',
                                device_short_name = '$deviceShortName',
                                device_type = '$deviceType',
                                WHERE device_id = '$deviceId'";

                    $result = mysqli_query($this->connection, $query);
                    if(!$result){
                        $json['error'] = 'Error Updating Device: '.$deviceId; 
                    } else{
                        $json['success'] = ' Successfully updated Device: '.$deviceId;
                    }
                    
                } else{
                    $query = " INSERT into device_list (device_id, device_name, device_short_name, device_type) VALUES ".
                                    "( '$deviceId', '$deviceName', '$deviceShortName', '$deviceType')";
                    
                    $is_inserted = mysqli_query($this->connection, $query);
                    if($is_inserted == 1){
                        $json['success'] = ' Device created: '.$deviceId;
                    } else{
                        $json['error'] = ' Incorrect Device Data ';
                        
                    }
                }
                echo json_encode($json);
                mysqli_close($this->connection);
            }

    }
?>