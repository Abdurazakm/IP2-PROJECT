<?php
require_once '../models/User.php';
require_once '../validations/validate_user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateUser($_POST);

    if (empty($errors)) {
        User::create($_POST['username'], $_POST['email'], $_POST['password']);
        echo "User registered successfully.";
    } else {
        foreach ($errors as $e) echo $e . "<br>";
    }
}
