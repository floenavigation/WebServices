<?php
    class ConfigurationParameter {

            private $db;
            private $connection;

            function __construct(){
                $this->db = new DB_Connection();
                $this->connection = $this->db->get_connection();
                mysqli_set_charset($this->connection, 'utf8');
            }

            public function does_parameter_exist($name, $value){
                $query = "SELECT * from configuration_parameters where parameter_name = '$name'";

                $result = mysqli_query($this->connection, $query);
                if(mysqli_num_rows($result) == 1){
                    $query = "UPDATE configuration_parameters SET 
                                    parameter_value = '$value'
                                    WHERE parameter_name = '$name'";

                    $result = mysqli_query($this->connection, $query);
                    if(!$result){
                        $json['error'] = 'Error Updating Parameter: '.$name; 
                    } else{
                        $json['success'] = ' Successfully updated Parameter: '.$name;
                    }
                        
                } else{
                    $query = " INSERT into configuration_parameters (parameter_name, parameter_value) values".
                                "('$name' , '$value')";
                    $is_inserted = mysqli_query($this->connection, $query);
                    if($is_inserted == 1){
                        $json['success'] = ' Parameter created : '.$name;
                    } else{
                        $json['error'] = ' Incorrect Parameter value ';
                    }
                    
                
                }

                echo json_encode($json);
                mysqli_close($this->connection);
            }

            public function send_parameter(){
                $sql = "SELECT * from configuration_parameters";
                $result = mysqli_query($this->connection, $sql);
                $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
                $xml.="<Configuration>";
                if(mysqli_num_rows($result) > 0){
                    while ($user_row = mysqli_fetch_assoc($result)){
                        $xml.="<CONFIGURATION_PARAMETERS>";
                        foreach($user_row as $column => $value){
                            $tabcolumn = strtoupper($column);
                            $xml.="<$tabcolumn>".$value."</$tabcolumn>";
                        }
                        $xml.="</CONFIGURATION_PARAMETERS>";
                    }
                $xml.="</Configuration>";
                echo $xml;
                }
        }
    }
?>