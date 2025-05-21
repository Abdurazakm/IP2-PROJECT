<?php
session_start();
require_once '../config/database.php';
require_once '../models/Notification.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notification_id'])) {
    $notificationId = (int)$_POST['notification_id'];

    if (Notification::markAsRead($notificationId)) {
        // Redirect back to the notifications page
        header("Location: ../../pages/user/notifications.php");
        exit;
    } else {
        echo "<script>alert('Failed to mark notification as read.'); window.history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
    exit;
}
?>
