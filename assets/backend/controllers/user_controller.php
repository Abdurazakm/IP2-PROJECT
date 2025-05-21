<?php
session_start();       // Start the session
session_unset();       // Clear any existing session variables
session_destroy();     // Destroy the current session
session_start();       // Start a brand-new session again



require_once '../models/User.php';
require_once '../validations/validate_user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateUser($_POST);

    if (empty($errors)) {
        $success = User::create($_POST['fullname'], $_POST['passport_no'], $_POST['username'], $_POST['email'], $_POST['password']);
        if ($success) {
            require_once '../models/Notification.php';

            $user = User::getUserByUsername($_POST['username']);
            if ($user && isset($user['id'])) {
                Notification::addNotification(
                    $user['id'],
                    'Registration Success',
                    'Welcome!',
                    'You have successfully registered to EASY CALL.',
                    null
                );
            }

            echo "<script>
                alert('User registered successfully.');
                window.location.href = '/IP2-PROJECT/pages/user/user_login.php';
            </script>";
        } else {
            echo "<script>
                alert('Something went wrong while saving the user.');
                
            </script>";
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}
