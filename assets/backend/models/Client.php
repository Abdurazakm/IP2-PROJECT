<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/Notification.php'; // Include the Notification model

class Client
{
    /**
     * Creates a new client record in the database.
     *
     * @param array $data An associative array containing client data.
     * Expected keys: 'full_name', 'age', 'passport_number', 'nationality',
     * 'medical_status', 'job_type', 'marital_status', 'registration_date',
     * 'flight_date', 'status'.
     * @return bool True on success, false if a client with the same passport number already exists or on failure.
     */
    public static function create($data)
    {
        $pdo = getPDO();

        // Check if a client with this passport number already exists
        $checkpassp = $pdo->prepare("SELECT id FROM clients WHERE passport_number = ?");
        $checkpassp->execute([$data['passport_number']]);

        if ($checkpassp->fetch()) {
            return false; // Client with this passport number already exists
        }

        $stmt = $pdo->prepare("INSERT INTO clients (
            full_name, age, passport_number, nationality, medical_status,
            job_type, marital_status, registration_date, flight_date, status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $success = $stmt->execute([
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

        // --- NEW: Add a registration success notification ---
        if ($success) {
            // Find the user_id associated with this passport_number
            // Find the user_id associated with this passport_number
            $userStmt = $pdo->prepare("SELECT id FROM users WHERE passport_no = ?");
            $userStmt->execute([$data['passport_number']]);
            $user = $userStmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $userId = $user['id'];
                // Define notification details
                $title = 'Registration Successful';
                $message = 'Your registration has been completed successfully.';
                $imageUrl = null; // Or provide a URL to an image if needed
                // This is where Notification::addNotification is called
                Notification::addNotification($userId, 'Registration Success', $title, $message, $imageUrl);
            } else {
                // THIS IS A CRITICAL POINT: Check your PHP error logs for this message!
                error_log("No user found for passport number " . $data['passport_number'] . " when trying to add registration notification.");
            }
        }

        return $success;
    }

    /**
     * Retrieves client data by passport number.
     *
     * @param string $passport_number The passport number of the client.
     * @return array|false An associative array of client data on success, or false if not found.
     */
    public static function getClientByPassport($passport_number)
    {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM clients WHERE passport_number = ?");
        $stmt->execute([$passport_number]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves a user by their username.
     * This method is typically in a User model, but keeping it here for context if needed.
     *
     * @param string $username The username to search for.
     * @return array|false An associative array of user data on success, or false if not found.
     */
    public static function getUserByUsername($username)
    {
        $pdo = getPDO();
        // Assuming 'users' table contains 'passport_no' linked to 'username'
        $stmt = $pdo->prepare("SELECT u.id, u.username, u.password, u.email, u.passport_no FROM users u WHERE u.username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Gets the total number of registered clients.
     *
     * @return int The total count of clients.
     */
    public static function getTotalClients()
    {
        $pdo = getPDO();
        $stmt = $pdo->query("SELECT COUNT(*) AS total_clients FROM clients");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_clients'] ?? 0;
    }

    /**
     * Gets a list of recently registered clients.
     *
     * @param int $limit The maximum number of recent clients to retrieve.
     * @return array An array of associative arrays, each representing a recent client.
     */
    public static function getRecentClients($limit = 5)
    {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT full_name, registration_date FROM clients ORDER BY registration_date DESC LIMIT ?");
        $stmt->bindParam(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Gets a list of clients with a 'Pending' status.
     *
     * @return array An array of associative arrays, each representing a client with pending status.
     */
    public static function getPendingStatusClients()
    {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT full_name, status FROM clients WHERE status = 'Pending' ORDER BY registration_date ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
