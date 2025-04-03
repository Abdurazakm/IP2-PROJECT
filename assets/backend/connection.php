<?php
$server = "localhost";
$username = "root";
$password = "";
$database_name = "A_Agency_Client_Info_Sys";

// Connect to MySQL
$connection = mysqli_connect($server, $username, $password, $database_name);
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
