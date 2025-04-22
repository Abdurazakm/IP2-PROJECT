<?php
function validateClient($data)
{
    $errors = [];

    if (empty($data['full_name'])) $errors[] = "Full name is required.";
    if (empty($data['passport_number'])) $errors[] = "Passport number is required.";
    if (!is_numeric($data['age'])) $errors[] = "Age must be a number.";
    if (empty($data['registration_date'])) $errors[] = "Registration date is required.";
    if (empty($data['flight_date'])) $errors[] = "Flight date is required.";
    if (empty($data['status'])) $errors[] = "Status is required.";

    return $errors;
}
