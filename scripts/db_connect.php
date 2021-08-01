<?php
use DevCoder\DotEnv;

(new DotEnv(__DIR__ . '../.env'))->load();

echo 
// mysql:host=localhost;dbname=test;

$db_servername = getenv('DATABASE_HOST');
$db_username = getenv('DATABASE_USER');
$db_password = getenv('DATABASE_PASSWORD');
$db_port = getenv('DATABASE_PORT');
$db_name = getenv('DATABASE_PASSWORD');

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>