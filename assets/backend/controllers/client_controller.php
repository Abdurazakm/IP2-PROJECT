<?php
require_once '../models/Client.php';
require_once '../validations/validate_client.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateClient($_POST);

    if (empty($errors)) {
        // Combine names into full name
        $fullName = $_POST['fname'] . ' ' . $_POST['mname'] . ' ' . $_POST['lname'];

        // Prepare full data for DB
        $clientData = [
            'full_name' => $fullName,
            'age' => $_POST['age'],
            'passport_number' => $_POST['passport_number'],
            'nationality' => $_POST['nationality'],
            'medical_status' => 'Pending', // fetched later from API
            'job_type' => $_POST['employee_type'],
            'marital_status' => $_POST['mstatus'],
            'registration_date' => date('Y-m-d'), // today
            'flight_date' => null, // fetched later
            'status' => 'Registered' // default status
        ];


        $success = Client::create($clientData);

        if ($success) {
            echo "<script>
                alert('Client registered successfully.');
                window.location.href = '/IP2-PROJECT/pages/admin/register.html';
            </script>";
        } else {
            echo "<script>
                alert('Something went wrong while saving the client.');
                window.location.href = '/IP2-PROJECT/pages/admin/register.html';
            </script>";
        }
    } else {
        foreach ($errors as $e) echo $e . "<br>";
    }
}
