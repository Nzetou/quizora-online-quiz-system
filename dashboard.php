
<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$name = htmlspecialchars($_SESSION["full_name"]);
$role = htmlspecialchars($_SESSION["role"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quizora Dashboard</title>
</head>

<body>

    <h1>Welcome to Quizora, <?php echo $name; ?>!</h1>

    <p>You are logged in successfully.</p>

    <p>Your account role is: <?php echo $role; ?></p>

    <h2>Your Dashboard</h2>

    <p>Welcome to your online quiz and assessment platform.</p>

    <a href="logout.php">Logout</a>

</body>
</html>
