<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: user_login.php"); // Redirect to login page if not logged in
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/IP2-PROJECT/assets/backend/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/IP2-PROJECT/assets/backend/models/User.php'; // Needed to get user ID
require_once $_SERVER['DOCUMENT_ROOT'] . '/IP2-PROJECT/assets/backend/models/Notification.php'; // New Notification model

// Get the current user's ID
$username = $_SESSION['username'];
$user = User::getUserByUsername($username); // Assuming getUserByUsername is in User.php and returns user_id

$userId = null;
if ($user && isset($user['id'])) {
    $userId = $user['id'];
} else {
    // Handle case where user ID cannot be found (e.g., user session is corrupted)
    echo "<script>alert('User ID not found. Please log in again.'); window.location.href = 'user_login.php';</script>";
    exit;
}

// Fetch notifications for the logged-in user
$notifications = Notification::getNotificationsByUserId($userId);

// You can add default notifications here if you want them to always appear
// For example, if you want the "Flight Reminder", "Medical CheckUp", "Biometric CheckUp"
// to be standard notifications that are added for new users or based on certain criteria.
// For now, we'll assume these are also added dynamically or managed by an admin.
// If you want to hardcode them as a fallback, you can do so, but it's less dynamic.

// Example of adding initial notifications for a user (you might do this on user creation)
// This is just for demonstration if you want to ensure some notifications exist.

// if (empty($notifications)) {
//     Notification::addNotification(
//         $userId,
//         'Flight Reminder',
//         'Flight Reminder',
//         'Your flight takes off at 11:00 PM on Tuesday Jan. 21, 2025. Be at the office at 4:30 PM on Jan. 20, 2025.',
//         '../../assets/images/best_plane.jpg'
//     );
//     Notification::addNotification(
//         $userId,
//         'Medical CheckUp',
//         'Medical CheckUp',
//         'You will have a medical examination at Sante Medical Center (Addis Ababa) on Saturday, Jan. 04, 2025. Be at the office on Saturday morning.',
//         '../../assets/images/medical_examination.jpg'
//     );
//     Notification::addNotification(
//         $userId,
//         'Biometric CheckUp',
//         'Biometric CheckUp',
//         'You will have a Biometric CheckUp at Sante Medical Center (Addis Ababa) on Wednesday, Dec. 25, 2024. Be at the office on Wednesday morning.',
//         '../../assets/images/Biometric_checkup.png'
//     );
//     // Re-fetch notifications after adding defaults
//     $notifications = Notification::getNotificationsByUserId($userId);
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="icon" href="../../assets/images/favicon (1).ico">
    <link rel="stylesheet" href="../../assets/css/notif.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        xintegrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../../assets/javascript/javascript.js"></script>
</head>

<body id="notification">
    <nav>
        <div class="logo">
            <a href="../../index.html">EASY CALL</a>
        </div>

        <div class="small-screen">
            <input type="checkbox" name="" id="check-box">
            <div class="links">
                <a href="../../index.html" style="--i:1">Home</a>
                <a href="reports.php" style="--i:2">My Status</a> <a href="notifications.php" style="--i:4">Notifications</a> </div>
        </div>
    </nav>

    <main>
        <div class="notificationarticles">
            <h1>Notifications</h1>
            <?php if (!empty($notifications)): ?>
                <?php foreach ($notifications as $notification): ?>
                    <article class="<?php echo $notification['read_status'] ? 'read' : 'unread'; ?>">
                        <h2><?php echo htmlspecialchars($notification['title']); ?></h2>
                        <hr>
                        <?php if (!empty($notification['image_url'])): ?>
                            <img class="notifimages" src="<?php echo htmlspecialchars($notification['image_url']); ?>" alt="Notification Image">
                        <?php endif; ?>
                        <p><?php echo nl2br(htmlspecialchars($notification['message'])); ?></p>
                        <p class="timecalc">Received: <?php echo date('F j, Y, g:i a', strtotime($notification['created_at'])); ?></p>
                        <?php if (!$notification['read_status']): ?>
                            <form action="../../assets/backend/controllers/mark_notification_read.php" method="post" style="text-align: right; margin-top: 10px;">

                                <input type="hidden" name="notification_id" value="<?php echo $notification['id']; ?>">
                                <button type="submit" style="background-color: #4CAF50; color: white; padding: 8px 12px; border: none; border-radius: 5px; cursor: pointer;">Mark as Read</button>
                            </form>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No notifications found.</p>
            <?php endif; ?>
        </div>
    </main>
    <footer>
        <p class="copyright">&copy; 2024 All Rights Reserved.</p>
    </footer>
</body>

</html>
