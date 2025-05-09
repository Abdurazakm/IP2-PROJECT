<?php
require_once __DIR__ . '/../config/database.php';

$pdoconn = getPDO();

// --- Pagination setup ---
$result_per_page = 15;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$start = ($page - 1) * $result_per_page;

// --- Handle Search ---
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$rows = [];

if (!empty($searchTerm)) {
    // Search query with LIKE
    $searchParam = '%' . $searchTerm . '%';

    // Count total matching results
    $countQuery = "SELECT COUNT(id) AS total FROM clients 
                   WHERE full_name LIKE :search OR passport_number LIKE :search";
    $stmt = $pdoconn->prepare($countQuery);
    $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
    $stmt->execute();
    $total_result = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Fetch current page of results
    $query = "SELECT * FROM clients 
              WHERE full_name LIKE :search OR passport_number LIKE :search 
              LIMIT :start, :limit";
    $stmt = $pdoconn->prepare($query);
    $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
    $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $result_per_page, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else {
    // No search: normal pagination
    $countQuery = "SELECT COUNT(id) AS total FROM clients";
    $stmt = $pdoconn->prepare($countQuery);
    $stmt->execute();
    $total_result = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    $query = "SELECT * FROM clients LIMIT :start, :limit";
    $stmt = $pdoconn->prepare($query);
    $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $result_per_page, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Final total pages
$total_pages = ceil($total_result / $result_per_page);

