<?php
session_start();

require_once "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);

    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {

        session_regenerate_id(true);

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["full_name"] = $user["full_name"];
        $_SESSION["role"] = $user["role"];

        header("Location: dashboard.php");
        exit;

    } else {
        $message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quizora - Login</title>
</head>

<body>

    <h1>Welcome Back to Quizora</h1>

    <p><?php echo htmlspecialchars($message); ?></p>

    <form method="POST">

        <label>Email Address:</label><br>
        <input type="email" name="email" required>
        <br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required>
        <br><br>

        <button type="submit">Login</button>

    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>

</body>
</html>
