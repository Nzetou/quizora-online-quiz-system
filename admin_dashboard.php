
<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION["role"] !== "admin") {
    header("Location: dashboard.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quizora - Admin Dashboard</title>
</head>

<body>

    <h1>Welcome to Quizora Admin Dashboard</h1>

    <p>Hello, <?php echo htmlspecialchars($_SESSION["full_name"]); ?>!</p>

    <p>You are logged in as an administrator.</p>

    <h2>Quiz Management</h2>

    <p>Here you will manage quizzes and questions.</p>

    <a href="logout.php">Logout</a>

</body>
</html>
