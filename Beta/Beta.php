<?php
    class Beta {

            private $db;
            private $connection;

            function __construct(){
                $this->db = new DB_Connection();
                $this->connection = $this->db->get_connection();
                mysqli_set_charset($this->connection, 'utf8');
            }

            public function does_beta_exist($betaValue, $update_time){
                $query = "SELECT * from beta";

                $result = mysqli_query($this->connection, $query);
                if(mysqli_num_rows($result) == 1){
                    $serverStation = mysqli_fetch_assoc($result);
                    $serverupdateTime = $serverStation['update_time'];
                    if((intval($serverupdateTime) - intval($update_time)) > 0)
                    {
                        $json['success'] = 'Server data for beta '.$betaValue.' is more recent. Will not update';
                    } else{
                            $query = "UPDATE beta SET 
                                            beta = '$betaValue', 
                                            update_time = '$update_time'";

                            $result = mysqli_query($this->connection, $query);
                            if(!$result){
                                $json['error'] = 'Error Updating beta: '.$betaValue; 
                            } else{
                                $json['success'] = ' Successfully updated beta: '.$betaValue;
                            }
                        }
                } else{
                    $query = " INSERT into beta (beta, update_time) values ('$betaValue' , '$update_time')";
                    $is_inserted = mysqli_query($this->connection, $query);
                    if($is_inserted == 1){
                        $json['success'] = ' beta created : '.$betaValue;
                    } else{
                        $json['error'] = ' Incorrect beta value ';
                    }
                    
                
                }

                echo json_encode($json);
                mysqli_close($this->connection);
            }

            /*
            public function delete_aisstation_data($mmsi){
                $query = "SELECT * from ais_station_list where mmsi = '$mmsi' ";
                $result = mysqli_query($this->connection, $query);
                if(mysqli_num_rows($result) > 0){
                    $query = "Delete from ais_station_list where mmsi = '$mmsi' ";
                    $result = mysqli_query($this->connection, $query);
                    if($result){
                        $json['success'] = ' Station '.$mmsi.' Deleted';
                    } else{
                        $json['error'] = ' Cannot delete AIS Station ';
                    }
                } else{
                    $json['error'] = ' Station does not exist ';
                }

                echo json_encode($json);
                mysqli_close($this->connection);

            }*/

            public function send_beta(){
                $sql = "SELECT * from beta";
                $result = mysqli_query($this->connection, $sql);
                $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
                $xml.="<Beta>";
                if(mysqli_num_rows($result) > 0){
                    while ($user_row = mysqli_fetch_assoc($result)){
                        $xml.="<BETA_TABLE>";
                        foreach($user_row as $column => $value){
                            $tabcolumn = strtoupper($column);
                            $xml.="<$tabcolumn>".$value."</$tabcolumn>";
                        }
                        $xml.="</BETA_TABLE>";
                    }
                $xml.="</Beta>";
                echo $xml;
                }
        }
    }
?>