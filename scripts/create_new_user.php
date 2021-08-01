<?php

// SANITISE INPUTS
$username = strip_tags(htmlspecialchars($_POST['username']));
$email = strip_tags(htmlspecialchars($_POST['email']));
$password = strip_tags(htmlspecialchars($_POST['password']));

// PW HASHING BCRYPT
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// SQL QUERY
$query = 
"
INSERT INTO users 
VALUES ('".$_POST['username']."',".$_POST['email'].",'".$hashed_password."',);
";

// CLEANING UP
unset($hashed_password);
unset($password);