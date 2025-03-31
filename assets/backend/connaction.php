<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "registration";

// Connect to database
$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "secuss";

// Check if form is submitted
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $raw_password = $_POST['password'];

    // Hash the password for security
    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

    // Handle profile image upload
    $target_dir = "uploads/"; // Directory to store profile pictures
    $target_file = $target_dir . basename($_FILES["profile"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Allowed file types
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    
    if (!in_array($imageFileType, $allowed_types)) {
        die("Error: Only JPG, JPEG, PNG, and GIF files are allowed.");
    }

    // Move uploaded file to the target directory
    if (move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file)) {
        echo "Profile picture uploaded successfully.<br>";

        // Insert data into database
        $sql = "INSERT INTO users (username, email, password, role, profile) 
                VALUES ('$username', '$email', '$hashed_password', '$role', '$target_file')";

        if (mysqli_query($conn, $sql)) {
            echo "Registration successful!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error uploading profile picture.";
    }
}

// Close connection
mysqli_close($conn);
?>


