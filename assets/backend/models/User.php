<?php
require_once __DIR__ . '/../config/database.php';

class User {
    public static function create($FullName,$Passport_no,$username, $email, $password) {
        $pdo = getPDO(); // Get the PDO instance
        // Check if email already exists
        $checkStmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $checkStmt->execute([$email]);

        if ($checkStmt->fetch()) {
            // Email exists
            return false;
        }
        $stmt = $pdo->prepare("INSERT INTO users (fullname,passport_no,username, email, password) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $FullName,
            $Passport_no,
            $username,
            $email,
            password_hash($password, PASSWORD_DEFAULT)
        ]);
    }
}
?>
