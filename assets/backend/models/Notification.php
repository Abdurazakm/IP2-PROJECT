<?php
require_once __DIR__ . '/../config/database.php';

class Notification
{
    /**
     * Adds a new notification to the database.
     *
     * @param int $userId The ID of the user to whom the notification belongs.
     * @param string $type The type of notification (e.g., 'Flight Reminder', 'Registration Success').
     * @param string $title The title of the notification.
     * @param string $message The full message content of the notification.
     * @param string|null $imageUrl Optional URL for an image associated with the notification.
     * @return bool True on success, false on failure.
     */
public static function addNotification($userId, $title, $type, $message, $imageUrl, $createdAt = null) {
    global $conn;
    $sql = "INSERT INTO notifications (user_id, title, type, message, image_url, created_at) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $pdo = getPDO();
    $stmt = $pdo->prepare($sql);
    $createdAt = $createdAt ?: date('Y-m-d H:i:s'); // current time if not provided
    return $stmt->execute([$userId, $title, $type, $message, $imageUrl, $createdAt]);
}


    /**
     * Retrieves all notifications for a specific user.
     *
     * @param int $userId The ID of the user.
     * @param bool $unreadOnly If true, only retrieve unread notifications.
     * @return array An array of associative arrays, each representing a notification.
     */
    public static function getNotificationsByUserId($userId, $unreadOnly = false)
    {
        $pdo = getPDO();
        $sql = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
        if ($unreadOnly) {
            $sql .= " AND read_status = FALSE";
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Marks a specific notification as read.
     *
     * @param int $notificationId The ID of the notification to mark as read.
     * @return bool True on success, false on failure.
     */
    public static function markAsRead($notificationId)
    {
        $pdo = getPDO();
        $stmt = $pdo->prepare("UPDATE notifications SET read_status = TRUE WHERE id = ?");
        return $stmt->execute([$notificationId]);
    }
}
