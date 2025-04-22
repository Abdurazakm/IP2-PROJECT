<?php
include 'connection.php'; // Include the connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password before storing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into database
    $sql = "INSERT INTO users (username, pword) VALUES ('$username', '$hashed_password')";
    if(mysqli_query($connection, $sql)) {
        echo "Registration successful!";
        // header("Location: ../../pages/user/user_login.html"); // Redirect after signup
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

// Close connection
mysqli_close($connection);
?>
