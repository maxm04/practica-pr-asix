<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "10.10.10.172";
$username = "root";
$password = "Root_pass1";
$database = "PHP";
$port = "52000";

$mysqli = new mysqli($host, $username, $password, $database,$port);

if ($mysqli->connect_error) {
    die("Error de conexión (" . $mysqli->connect_errno . "): " . $mysqli->connect_error);
} 



