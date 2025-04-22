<?php
require_once __DIR__ . '/../config/database.php';

class Client {
    public static function create($data) {
        $pdo = getPDO();
        $stmt = $pdo->prepare("INSERT INTO clients (
            full_name, age, passport_number, nationality, medical_status,
            job_type, marital_status, registration_date, flight_date, status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        return $stmt->execute([
            $data['full_name'],
            $data['age'],
            $data['passport_number'],
            $data['nationality'],
            $data['medical_status'],
            $data['job_type'],
            $data['marital_status'],
            $data['registration_date'],
            $data['flight_date'],
            $data['status']
        ]);
    }
}
