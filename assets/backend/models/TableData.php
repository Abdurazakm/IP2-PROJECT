<?php
require_once __DIR__. '\..\config\database.php';

$pdoconn = getPDO();

$pdoconn->exec("INSERT INTO clients ( full_name, age, passport_number, nationality, medical_status, job_type, marital_status, registration_date, flight_date, status) VALUES ('Abebe','25','EP1234225','ETHIOPIAN','VALID','HOUSE MAID','SINGLE','5-9-2025','5-9-2025', 'PASSED')");


// Get total number of clients and calculate the number of pages
$stmt = $pdoconn->prepare("SELECT COUNT(id) AS total FROM clients");
$stmt->execute();
$total_result = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    $result_per_page = 15;
    $total_pages = ceil($total_result / $result_per_page);

$page = (int) isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = (int) max(1, min($page, $total_pages));

$start = ($page - 1) * $result_per_page;

// Safely inject $start and $result_per_page
$query = "SELECT * FROM clients LIMIT $start, $result_per_page";
$stmt = $pdoconn->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


//display it on the clients.php
//with the next prev and numbers button
