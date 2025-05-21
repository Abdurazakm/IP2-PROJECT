<?php
// Start session
session_start();

// Include database connection
require_once '../../config/database.php'; // Adjust the path as per your project structure

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($username) || empty($password)) {
        echo "Username and password are required.";
        exit;
    }

    // Prepare SQL query to fetch user
    $pdo = getPDO();
    // $sql = "SELECT username, password FROM users WHERE username = :username";
    $stmt = $pdo->prepare("SELECT username, password FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['username'] = $user['username'];

            // Redirect to dashboard or home page
            header("Location: /dashboard.php");
            exit;
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }

    unset($stmt);
} else {
    echo "Invalid request method.";
}
