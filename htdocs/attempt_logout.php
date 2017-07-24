<?php

//setting up mysql details
$sql_server = 'localhost';
$sql_user = 'root';
$sql_pwd = 'password';
$sql_db = 'test';

//connecting to sql database
$connection = new mysqli($sql_server, $sql_user, $sql_pwd, $sql_db);

//start session
session_start();

//remove all session variables
session_unset();

//destroy the session
session_destroy();

//redirect back to login.html
header('location: login.html');

?>
