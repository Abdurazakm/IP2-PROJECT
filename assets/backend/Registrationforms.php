<?php
echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
</head>
<body>
    <form action="connection.php" method="post" enctype="multipart/form-data">
        <label>Username:</label>
        <input type="text" name="username" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Role:</label>
        <select name="role" required>
            <option value="admin">Admin</option>
            <option value="guest">Guest</option>
            <option value="user">User</option>
        </select><br>

        <label>Profile Picture:</label>
        <input type="file" name="profile" accept="image/*" required><br>

        <button type="submit" name="submit">Submit</button>
    </form>
</body>
</html>';
?>
