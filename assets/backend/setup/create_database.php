<?php
$servername = "localhost";
$username = "root";
$password = "";
$database_name = "A_Agency_Client_Info_Sys"; // Define DB name here

try {
    //Connect to MySQL without selecting DB
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Create the database
    $sql = "CREATE DATABASE IF NOT EXISTS $database_name";
    $conn->exec($sql);
    echo "Database '$database_name' created successfully.<br>";

    //Select the DB
    $conn->exec("USE $database_name");

    // Create USERS table (remains the same as previous update)
    $createUsers = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        fullname VARCHAR(100) NOT NULL,
        passport_no VARCHAR(50) NOT NULL UNIQUE,
        username VARCHAR(100) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        reset_token VARCHAR(255) NULL,
        reset_token_expiry DATETIME NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->exec($createUsers);
    echo "Table 'users' created.<br>";

    // Create CLIENTS table (remains the same)
    $createClient = "CREATE TABLE IF NOT EXISTS clients (
        id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(100) NOT NULL,
        age INT,
        passport_number VARCHAR(50) NOT NULL UNIQUE,
        nationality VARCHAR(50),
        medical_status VARCHAR(50),
        job_type VARCHAR(100),
        marital_status VARCHAR(20),
        registration_date DATE,
        flight_date DATE,
        status VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->exec($createClient);
    echo "Table 'clients' created.<br>";

    // --- NEW: Create NOTIFICATIONS table ---
    $createNotifications = "CREATE TABLE IF NOT EXISTS notifications (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL, -- Link to the users table
        type VARCHAR(50) NOT NULL, -- e.g., 'Flight Reminder', 'Medical CheckUp', 'Registration Success'
        title VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        image_url VARCHAR(255) NULL, -- Optional image for the notification
        read_status BOOLEAN DEFAULT FALSE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";
    $conn->exec($createNotifications);
    echo "Table 'notifications' created.<br>";
} catch (PDOException $e) {
    echo "Error creating database or tables: " . $e->getMessage();
}
