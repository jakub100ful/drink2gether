<?php

require_once 'DotEnv.php';

// LOAD ENV VARIABLES
(new App\DotEnv('../.env'))->load();

// Database wrapper class that handles queries on method calls
class Database{
private $connection; //Connection attribute to be used by methods

    //Connects to the database on creation.
    function __construct(){

        // LOGIN CREDENTIALS
        $servername = getenv('DATABASE_HOST');
        $username = getenv('DATABASE_USER');
        $password = getenv('DATABASE_PASSWORD');
        $dbname = getenv('DATABASE_NAME');
        $port = getenv('DATABASE_PORT');

        $conn = new mysqli();
        $conn->init();

        //testing for connection

        if(!$conn){
            echo "Connection failed";
        }else{
            $conn->ssl_set(NULL,NULL,NULL,'/public_html/sys_tests', NULL);
            $conn->real_connect($servername, $username, $password, $dbname, $port, NULL, MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT);

            if($conn->connection_errorno){
                echo "Connection failed";
            }else{
                //Connection success
                $this->connection = $conn;
            }
        }
    }

    // REGISTER USER
    public function registerUser($username,$email,$password){
        $sql = "INSERT INTO users (user_name, user_email, user_password) VALUES ('".$username."','".$email."','".$password."');";
        var_dump($sql);

        mysqli_query($this->connection,$sql);
        if(mysqli_error($this->connection) != NULL) {
            echo mysqli_error($this->connection);
        }
        return 1;

    }

    public function loginUser($username,$password){
        //Get the user by username
        $sql = "SELECT * FROM users WHERE (user_name = '$username') ";

        $result = mysqli_query($this->connection,$sql);

        if(mysqli_error($this->connection) != NULL) {
            echo mysqli_error($this->connection);
        }

        $userRow = mysqli_fetch_assoc($result);

        // PASSWORD VERIFICATION

        if (password_verify($password, $userRow['user_password'])) {
            return true;
        } else {
            return false;
        }
    }
}
?>
