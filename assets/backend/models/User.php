<?php
require_once __DIR__ . '/../config/database.php';

class User {
    public static function create($username, $email, $password) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([
            $username,
            $email,
            password_hash($password, PASSWORD_DEFAULT)
        ]);
    }
}
