<?php
$servername = "localhost";
$username = "root";
$password = "";
$database_name = "A_Agency_Client_Info_Sys";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo"successfull connected";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
