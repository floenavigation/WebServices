<?php
    class User {

            private $db;
            private $connection;

            function __construct(){
                $this->db = new DB_Connection();
                $this->connection = $this->db->get_connection();
                mysqli_set_charset($this->connection, 'utf8');
            }

            public function does_user_exist($username, $password){
                $query = "SELECT * from users where username = '$username' and password = '$password' ";

                $result = mysqli_query($this->connection, $query);
                if(mysqli_num_rows($result) > 0){
                    $json['success'] = ' Welcome '.$username;
                    echo json_encode($json);
                    mysqli_close($this->connection);
                } else{
                    $query = " INSERT into users (username, password) values ('$username' , '$password')";
                    $is_inserted = mysqli_query($this->connection, $query);
                    if($is_inserted == 1){
                        $json['success'] = ' Account created, welcome '.$username;
                    } else{
                        $json['error'] = ' Wrong Password ';
                    }
                    
                    echo json_encode($json);
                    mysqli_close($this->connection);
                }
            }

            public function delete_user_data($username){
                $query = "SELECT * from users where username = '$username' ";
                $result = mysqli_query($this->connection, $query);
                if(mysqli_num_rows($result) > 0){
                    $query = "UPDATE users set is_delete = true where username = '$username'  ";
                    $result = mysqli_query($this->connection, $query);
                    if($result){
                        $json['success'] = ' User '.$username.' Deleted';

                        echo json_encode($json);

                        mysqli_close($this->connection);
                    } else{
                        $json['error'] = ' Cannot delete User ';
                        echo json_encode($json);
                        mysqli_close($this->connection);
                    }
                } else{
                    $json['error'] = ' User does not exist ';
                    echo json_encode($json);
                    mysqli_close($this->connection);
                }

            }

            public function send_user_data(){
                $query = "DELETE from users where is_delete = true";
                $result = mysqli_query($this->connection, $query);

                $sql = "SELECT username, password from users";
                $result = mysqli_query($this->connection, $sql);
                $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
                $xml.="<Users>";
                if(mysqli_num_rows($result) > 0){
                    while ($user_row = mysqli_fetch_assoc($result)){
                        $xml.="<USERS>";
                        foreach($user_row as $column => $value){
                            if($column != 'is_delete'){
                                $tabcolumn = strtoupper($column);
                                $xml.="<$tabcolumn>".$value."</$tabcolumn>";
                            }
                        }
                        $xml.="</USERS>";
                    }
                $xml.="</Users>";
                echo $xml;
                }
        }
    }
?>