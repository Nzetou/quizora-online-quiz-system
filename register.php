<?php
require_once "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($full_name) || empty($email) || empty($password)) {
        $message = "Please fill in all fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";

    } elseif (strlen($password) < 8) {
        $message = "Password must contain at least 8 characters.";

    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO users (full_name, email, password)
                    VALUES (?, ?, ?)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $full_name,
                $email,
                $hashed_password
            ]);

            $message = "Registration successful! You can now log in.";

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $message = "This email is already registered.";
            } else {
                $message = "Registration failed. Please try again.";
                error_log($e->getMessage());
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quizora - Register</title>
</head>

<body>

    <h1>Create Your Quizora Account</h1>

    <p><?php echo htmlspecialchars($message); ?></p>

    <form method="POST" action="">

        <label>Full Name:</label><br>
        <input type="text" name="full_name" required>
        <br><br>

        <label>Email Address:</label><br>
        <input type="email" name="email" required>
        <br><br>

        <label>Password:</label><br>
        <input type="password" name="password" minlength="8" required>
        <br><br>

        <button type="submit">Register</button>

    </form>

</body>
</html
