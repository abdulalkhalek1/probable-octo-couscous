<?php  
// Assuming you have a database connection in db.php  
include 'db.php';  
session_start();  

$user_id = $_SESSION['user_id']; // Make sure to have user authentication  
$stmt = $pdo->prepare("SELECT * FROM events WHERE user_id = ? ORDER BY event_date ASC");  
$stmt->execute([$user_id]);  
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);  

// Handle form submission for adding an event  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
    $title = $_POST['event_title'];  
    $description = $_POST['event_description'];  
    $event_date = $_POST['event_date'];  

    $stmt = $pdo->prepare("INSERT INTO events (title, description, event_date, user_id) VALUES (?, ?, ?, ?)");  
    if ($stmt->execute([$title, $description, $event_date, $user_id])) {  
        $message = "Event added successfully!";  
    } else {  
        $message = "Failed to add event.";  
    }  
}  
?>  

<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Dashboard - Manage Events</title>  
    <style>  
        body {  
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;  
            background-color: #f8f9fa;  
            margin: 0;  
            padding: 0;  
            display: flex;  
            min-height: 100vh;  
            overflow-x: hidden;  
        }  

        .sidebar {
            width: 250px;  
        background-color: #343a40;  
        color: #ffffff;  
        padding: 20px;  
        position: fixed;  
        height: 100%;  
        overflow-y: auto;  
        transition: width 0.3s;  
        }  

        .sidebar h2 {  
            color: #ffffff;  
        }  

        .sidebar a {  
            color: #ffffff;  
            text-decoration: none;  
            display: block;  
            padding: 10px;  
            transition: background 0.3s;  
        }  

        .sidebar a:hover {  
            background-color: #495057;  
        }  

        .content {  
            margin-left: 270px;  
            padding: 20px;  
            flex-grow: 1;  
        }  

        .calendar {  
            display: grid;  
            grid-template-columns: repeat(7, 1fr);  
            gap: 10px;  
        }  

        .calendar-date {  
            background-color: #ffffff;  
            border: 1px solid #ced4da;  
            padding: 10px;  
            height: 100px;  
            position: relative;  
            text-align: center;  
            border-radius: 4px;  
        }  

        .event-info {  
            background-color: #e9ecef;  
            margin: 5px 0;  
            padding: 5px;  
            border: 1px solid #adb5bd;  
            border-radius: 4px;  
            font-size: 12px;  
        }  

        .event-title {  
            font-weight: bold;  
        }  

        .event-actions {  
            display: flex;  
            justify-content: space-between;  
        }  

        .edit-button, .delete-button {  
            text-decoration: none;  
            color: #007bff;  
            font-size: 12px;  
            margin-left: 5px;  
        }  

        .edit-button:hover, .delete-button:hover {  
            text-decoration: underline;  
        }  

        body {  
        font-family: Arial, sans-serif;  
        margin: 0;  
        background-color: #f4f4f4;  
    }  

    .sidebar {  
        background: #343a40;  
        color: white;  
        padding: 20px;  
        height: 100vh;  
    }  

    .sidebar h2 {  
        margin: 0;  
        font-size: 24px;  
    }  

    .sidebar a {  
        color: white;  
        text-decoration: none;  
        display: block;  
        margin: 10px 0;  
        font-size: 18px;  
        transition: background 0.3s;  
    }  

    .sidebar a:hover {  
        background: #495057;  
        padding: 5px;  
        border-radius: 4px;  
    }  

    .content {  
        padding: 20px;  
        margin-left: 260px; /* Adjusted for sidebar width */  
    }  

    h1 {  
        font-size: 28px;  
        margin-bottom: 20px;  
    }  

    form {  
        background: white;  
        padding: 20px;  
        border-radius: 8px;  
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);  
        margin-bottom: 20px;  
    }  

    input[type="text"], input[type="date"], textarea {  
        width: 100%;  
        padding: 10px;  
        margin-bottom: 15px;  
        border: 1px solid #ccc;  
        border-radius: 4px;  
        box-sizing: border-box;  
        transition: border 0.3s;  
    }  

    input[type="text"]:focus, input[type="date"]:focus, textarea:focus {  
        border-color: #007bff;  
        outline: none;  
    }  

    textarea {  
        height: 80px;  
        resize: vertical;  
    }  

    button {  
        background-color: #007bff;  
        color: white;  
        padding: 10px 15px;  
        border: none;  
        border-radius: 4px;  
        cursor: pointer;  
        font-size: 16px;  
        transition: background 0.3s;  
    }  

    button:hover {  
        background-color: #0056b3;  
    }  

    .calendar {  
        display: grid;  
        grid-template-columns: repeat(7, 1fr);  
        gap: 10px;  
        margin-top: 20px;  
    }  

    .calendar-date {  
        background: white;  
        border: 1px solid #e0e0e0;  
        padding: 10px;  
        border-radius: 4px;  
        position: relative;  
        min-height: 100px; /* Ensures consistent height */  
    }  

    .event-info {  
        margin-top: 5px;  
        font-size: 12px;  
    }  

    .event-title {  
        font-weight: bold;  
    }  

    .event-actions {  
        margin-top: 5px;  
    }  

    .edit-button, .delete-button {  
        text-decoration: none;  
        color: #007bff;  
        font-size: 12px;  
        margin-left: 5px;  
    }  

    .edit-button:hover, .delete-button:hover {  
        text-decoration: underline;  
    }  
    </style>  
</head>  
<body>  
    <div class="sidebar">  
        <h2>Dashboard</h2>  
        <a href="index.php">Home</a>  
        <a href="manage_events.php">Manage Events</a>  
        <a href="logout.php">Logout</a>  
    </div>  
    <div class="content">  
        <h1>Event Calendar</h1>  
        <form method="POST">  
            <input type="text" name="event_title" placeholder="Event Title" required>  
            <textarea name="event_description" placeholder="Event Description"></textarea>  
            <input type="date" name="event_date" required>  
            <button type="submit">Add Event</button>  
        </form>  
        <div class="calendar" id="calendar"></div>  
        <script>  
            function generateCalendar(events) {  
                const calendarElement = document.getElementById('calendar');  
                const today = new Date();  
                const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);  
                const daysInMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0).getDate();  

                // Empty days before the first day of the month  
                for (let i = 0; i < firstDay.getDay(); i++) {  
                    const emptyCell = document.createElement('div');  
                    emptyCell.classList.add('calendar-date');  
                    calendarElement.appendChild(emptyCell);  
                }  

                // Days of the month  
                for (let i = 1; i <= daysInMonth; i++) {  
                    const dateElement = document.createElement('div');  
                    dateElement.classList.add('calendar-date');  
                    dateElement.textContent = i;  

                    // Add events to the calendar date  
                    const dateStr = `${today.getFullYear()}-${(today.getMonth() + 1).toString().padStart(2, '0')}-${i.toString().padStart(2, '0')}`;  
                    const eventsForDate = events.filter(event => event.event_date.startsWith(dateStr));  
                    if (eventsForDate.length > 0) {  
                        eventsForDate.forEach(event => {  
                            const eventInfo = document.createElement('div');  
                            eventInfo.classList.add('event-info');  

                            // Event title  
                            const eventTitle = document.createElement('span');  
                            eventTitle.classList.add('event-title');  
                            eventTitle.textContent = event.title;  

                            // Event actions  
                            const eventActions = document.createElement('div');  
                            eventActions.classList.add('event-actions');  

                            // Edit button  
                            const editButton = document.createElement('a');  
                            editButton.href = `edit_event.php?id=${event.id}`;  
                            editButton.textContent = 'Edit';  
                            editButton.classList.add('edit-button');  

                            // Delete button  
                            const deleteButton = document.createElement('a');  
                            deleteButton.href = `delete_event.php?id=${event.id}`;  
                            deleteButton.textContent = 'Delete';  
                            deleteButton.classList.add('delete-button');  

                            eventActions.appendChild(editButton);  
                            eventActions.appendChild(deleteButton);  
                            eventInfo.appendChild(eventTitle);  
                            eventInfo.appendChild(eventActions);  

                            dateElement.appendChild(eventInfo);  
                        });  
                    }  

                    calendarElement.appendChild(dateElement);  
                }  
            }  

            // Pass PHP events array to JavaScript  
            const events = <?php echo json_encode($events); ?>;  
            generateCalendar(events);  
        </script>  
    </div>  
</body>  
</html>