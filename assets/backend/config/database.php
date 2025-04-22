<?php
function getPDO() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database_name = "A_Agency_Client_Info_Sys";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database_name", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>
