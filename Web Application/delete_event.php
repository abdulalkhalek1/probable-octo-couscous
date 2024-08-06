<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ? AND user_id = ?");
    $stmt->execute([$event_id, $_SESSION['user_id']]);
    $event = $stmt->fetch();

    if ($event) {
        $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
        $stmt->execute([$event_id]);

        // Add notification
        $message = "Event '{$event['title']}' deleted.";
        $stmt = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
        $stmt->execute([$_SESSION['user_id'], $message]);
    }
}

header("Location: manage_events.php");
exit;
?>