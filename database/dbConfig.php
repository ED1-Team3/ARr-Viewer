<?php
//Database Configuration
$dbHost = "local host";
$dbUsername = "root";
$dbPassword = "Arrviewer3!";
$dbName = "ArrViewer";

//Create Database Connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

//Check Connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>