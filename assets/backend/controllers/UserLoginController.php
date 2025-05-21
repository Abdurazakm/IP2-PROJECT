<?php
session_start();
require_once '../config/database.php';
require_once '../models/User.php';
require_once '../models/Client.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "<script>alert('Username and password are required.'); window.history.back();</script>";
        exit;
    }

    $user = User::getUserByUsername($username);

    if (!$user) {
        echo "<script>alert('User not found.'); window.history.back();</script>";
        exit;
    }

    if (isset($user['password']) && password_verify($password, $user['password'])) {
        // ✅ Session login
        $_SESSION['username'] = $user['username'];

        // ✅ Optional: add more user info to session if needed
        $_SESSION['user_id'] = $user['id']; // Only if `id` column exists

        // ✅ Cookie login (expires in 7 days)
        setcookie("user_token", hash('sha256', $user['id']), time() + (86400 * 7), "/");
        setcookie("user_username", $username, time() + (86400 * 7), "/");

        // ✅ Fetch related client data
        if (isset($user['passport_no'])) {
            $passport_number = $user['passport_no'];
            $client = Client::getClientByPassport($passport_number);

            if ($client) {
                $_SESSION['client_data'] = $client;
            } else {
                error_log("Client data not found for passport number: " . $passport_number);
            }
        } else {
            error_log("Passport number missing for user: " . $username);
        }

        // ✅ Redirect
        echo "<script>
            alert('Login successful!');
            window.location.href = '/IP2-PROJECT/pages/user/reports.php';
        </script>";
        exit;
    } else {
        echo "<script>alert('Invalid username or password.'); window.history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid request method.'); window.history.back();</script>";
    exit;
}
?>
