<?php
require_once '../models/Client.php';
require_once '../validations/validate_client.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateClient($_POST);

    if (empty($errors)) {
        Client::create($_POST);
        echo "Client registered successfully.";
    } else {
        foreach ($errors as $e) echo $e . "<br>";
    }
}
