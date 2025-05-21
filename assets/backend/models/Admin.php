<?php
function getAdminByUsername($username) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :username LIMIT 1");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
