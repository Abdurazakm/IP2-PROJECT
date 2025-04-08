<?php
function dbConnect(){$server = "localhost";
$username = "root";
$password = "";
$database_name = "labexercise";

// $database_name = "A_Agency_Client_Info_Sys";

// Connect to MySQL  --I CHOOSE PDO incase we use other databases other than mysql, and its better!!.

try{
    $dsn = "mysqli:host = $server; dbname = $database_name; charset = UTF8";
    $connection = new PDO($dsn, $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode
    return $connection;
}catch(PDOException $e){
    echo("SORRY  Cannot connect to the database !! <br>".$e->getMessage());
}}

?>
