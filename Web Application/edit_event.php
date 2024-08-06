<?php  
session_start();  
include 'db.php';  

if (!isset($_SESSION['user_id'])) {  
    header("Location: login.php");  
    exit;  
}  

if (!isset($_GET['id'])) {  
    header("Location: manage_events.php");  
    exit;  
}  

$event_id = $_GET['id'];  
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ? AND user_id = ?");  
$stmt->execute([$event_id, $_SESSION['user_id']]);  
$event = $stmt->fetch();  

if (!$event) {  
    header("Location: manage_events.php");  
    exit;  
}  

$message = "";  

// Handle the form submission  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
    $title = trim($_POST['event_title']);  
    $description = trim($_POST['event_description']);  
    $event_date = $_POST['event_date'];  

    // Validate input fields  
    if (empty($title) || empty($description) || empty($event_date)) {  
        $message = "All fields are required.";  
    } else {  
        // Update the event  
        $stmt = $pdo->prepare("UPDATE events SET title = ?, description = ?, event_date = ? WHERE id = ?");  
        $stmt->execute([$title, $description, $event_date, $event_id]);  

        // Add notification  
        $message = "Event '$title' updated successfully.";  
        $stmt = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");  
        $stmt->execute([$_SESSION['user_id'], $message]);  

        header("Location: manage_events.php");  
        exit;  
    }  
}  
?>  

<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Edit Event</title>  
    <link rel="stylesheet" href="style.css">  
</head>  
<body>  
<header>  
    <h1>Edit Event</h1>  
</header>  

<main>  
    <div class="container">  
        <?php if ($message): ?>  
            <div class="alert"><?php echo htmlspecialchars($message); ?></div>  
        <?php endif; ?>  
        <form method="POST" action="edit_event.php?id=<?php echo $event['id']; ?>">  
            <label for="event_title">Event Title:</label>  
            <input type="text" name="event_title" id="event_title" value="<?php echo htmlspecialchars($event['title']); ?>" required>  

            <label for="event_description">Event Description:</label>  
            <textarea name="event_description" id="event_description" required><?php echo htmlspecialchars($event['description']); ?></textarea>  
            
            <label for="event_date">Event Date and Time:</label>  
            <input type="datetime-local" name="event_date" id="event_date" value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($event['event_date']))); ?>" required>  

            <button type="submit">Update Event</button>  
        </form>  
    </div>  
</main>  

<footer>  
    <p>&copy; 2024 Event Management App</p>  
</footer>  
</body>  
</html>