<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$notifications = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Notifications</h1>
</header>

<main>
    <div class="container">
        <h2>Your Notifications</h2>
        <ul>
            <?php foreach ($notifications as $notification): ?>
                <li><?php echo htmlspecialchars($notification['message']); ?> - <?php echo $notification['created_at']; ?></li>
            <?php endforeach; ?>
        </ul>
        <p><a href="manage_events.php">Manage Your Events</a></p>
    </div>
</main>

<footer>
    <p>&copy; 2024 Event Management App</p>
</footer>
</body>
</html>