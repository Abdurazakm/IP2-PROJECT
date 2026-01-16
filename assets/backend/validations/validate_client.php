<?php
function validateClient($data)
{
    $errors = [];
    if (empty($data['fname']) || empty($data['mname']) || empty($data['lname'])) {
        $errors[] = "First, Middle, and Last names are required.";
    }

    if (!isset($data['age']) || !is_numeric($data['age'])) {
        $errors[] = "Valid age is required.";
    }

    if (empty($data['contact'])) $errors[] = "Contact number is required.";
    if (empty($data['passport_number'])) $errors[] = "Passport number is required.";
    if (empty($data['nationality'])) $errors[] = "Nationality is required.";
    if (empty($data['employee_type'])) $errors[] = "Employee type is required.";
    if (empty($data['mstatus'])) $errors[] = "Marital status is required.";

    return $errors;
}
