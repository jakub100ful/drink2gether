<?php

require_once 'DotEnv.php';

(new App\DotEnv('../.env'))->load();

$db_servername = getenv('DATABASE_HOST');
$db_username = getenv('DATABASE_USER');
$db_password = getenv('DATABASE_PASSWORD');
$db_port = getenv('DATABASE_PORT');
$db_name = getenv('DATABASE_PASSWORD');

// Create connection
$conn = new mysqli($db_servername, $db_username, $db_password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>