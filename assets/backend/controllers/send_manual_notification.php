<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/IP2-PROJECT/assets/backend/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/IP2-PROJECT/assets/backend/models/User.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/IP2-PROJECT/assets/backend/models/Notification.php';

// Collect form data
$fullname = $_POST['fullname'] ?? '';
$passportId = $_POST['passportid'] ?? '';
$message = $_POST['message'] ?? '';
$date = $_POST['submitdate'] ?? '';
$time = $_POST['submittime'] ?? '';
$datetime = "$date $time";

// Get user by passport ID
$user = User::getUserByPassport($passportId); // Make sure this function exists in User.php

if (!$user || !isset($user['id'])) {
    echo "User not found.";
    exit;
}

$userId = $user['id'];
$title = "Manual Notification";
$image = "../../assets/images/manual_message.jpg"; // Use a default or dynamic image

// Save the notification
Notification::addNotification($userId, $title, $title, $message, $image, $datetime);

// ✅ Redirect without newline
header("Location: http://localhost/IP2-PROJECT/assets/pages/admin/admin-dashboard.html?success=true");
exit;
