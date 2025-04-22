<?php
include 'connection.php'; // Ensure this file contains a valid database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prevent SQL injection (use prepared statements)
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Verify the password
        if ($password == $row['pword']) { // Consider using password_hash() instead of plain text
            echo "Login successful! Redirecting...";
            exit();
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "User not found. Please sign up first.";
    }
}
?>
