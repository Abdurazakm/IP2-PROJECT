<?php
require_once '../models/User.php';
require_once '../validations/validate_user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateUser($_POST);

    if (empty($errors)) {
        $success = User::create($_POST['fullname'],$_POST['passport_no'],$_POST['username'], $_POST['email'], $_POST['password']);
        if ($success) {
            echo "User registered successfully.";
        } else {
            echo "Something went wrong.";
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}
