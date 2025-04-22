<?php
function validateUser($data) {
    $errors = [];

    if (empty($data['username'])) $errors[] = "Username is required.";
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email.";
    if (strlen($data['password']) < 6) $errors[] = "Password must be at least 6 characters.";

    return $errors;
}
