<?php
function validateUser($data) {
    $errors = [];

    if (empty($data['fullname'])) $errors[] = "Full Name Can not be empty";
    if (empty($data['username'])) $errors[] = "Username is required.";
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email.";
    if (strlen($data['password']) < 6) $errors[] = "Password must be at least 6 characters.";
    if ($data['password'] !== $data['confirm_password']) $errors[] = "Passwords do not match.";

    return $errors;
}
