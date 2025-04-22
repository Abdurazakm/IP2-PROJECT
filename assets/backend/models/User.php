<?php
require_once __DIR__ . '/../config/database.php';

class User {
    public static function create($username, $email, $password) {
        $pdo = getPDO(); // Get the PDO instance
        // Check if email already exists
        $checkStmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $checkStmt->execute([$email]);

        if ($checkStmt->fetch()) {
            // Email exists
            return false;
        }
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([
            $username,
            $email,
            password_hash($password, PASSWORD_DEFAULT)
        ]);
    }
}
?>
