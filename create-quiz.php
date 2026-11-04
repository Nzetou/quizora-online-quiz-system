
<?php
session_start();

require_once "config/database.php";

// Protect the page
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION["role"] !== "admin") {
    header("Location: dashboard.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $duration = (int) $_POST["duration"];

    if (empty($title) || empty($description) || $duration <= 0) {

        $message = "Please fill in all fields correctly.";

    } else {

        $sql = "INSERT INTO quizzes
                (title, description, duration_minutes, created_by)
                VALUES (?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $title,
            $description,
            $duration,
            $_SESSION["user_id"]
        ]);

        $message = "Quiz created successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quizora - Create Quiz</title>
</head>

<body>

    <h1>Create a New Quiz</h1>

    <p><?php echo htmlspecialchars($message); ?></p>

    <form method="POST">

        <label>Quiz Title:</label><br>
        <input type="text" name="title" required>
        <br><br>

        <label>Description:</label><br>
        <textarea name="description" required></textarea>
        <br><br>

        <label>Duration (minutes):</label><br>
        <input type="number" name="duration" min="1" required>
        <br><br>

        <button type="submit">Create Quiz</button>

    </form>

    <p><a href="admin_dashboard.php">Back to Admin Dashboard</a></p>

</body>
</html>
