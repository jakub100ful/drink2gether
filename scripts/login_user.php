<?php
session_start();
require_once 'Database.php';

$connection = new Database();

// SANITISE INPUTS
$username = strip_tags(htmlspecialchars($_POST['username']));
$password = strip_tags(htmlspecialchars($_POST['password']));

// PW HASHING BCRYPT
// $hashed_password = password_hash($password, PASSWORD_BCRYPT);
// var_dump($hashed_password);

// SQL QUERY
$user_logged_in = $connection->loginUser($username, $password);

if($user_logged_in){
    $_SESSION['user'] = $username;
    header("Location: ../index.php");
    die();
}

// CLEANING UP
unset($hashed_password);
unset($password);