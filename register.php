<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'db.php';

    $username = $_POST['username'];
    // Hash the password securely
    $password = password_hash($_POST['password'], PASSWORD_ARGON2ID);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);
        echo "Registration successful! You can now log in.";
    } catch (PDOException $e) {
        // Check for duplicate entry
        if ($e->getCode() == 23000) {
            echo "Error: This username is already taken.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form action="register.php" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>