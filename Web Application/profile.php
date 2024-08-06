<?php  
session_start();  
include 'db.php';  

// Check if the user is logged in and the user_id is set in the session  
if (!isset($_SESSION['user_id'])) {  
    die("You must be logged in to update your profile.");  
}  

// Fetch user_id from the session  
$user_id = $_SESSION['user_id'];  

// Initialize variables  
$username = '';  
$email = '';  
$success = '';  
$error = '';  

// Fetch current user data  
$stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = ?");  
$stmt->execute([$user_id]);  
$user = $stmt->fetch();  

if ($user) {  
    $username = $user['username'];  
    $email = $user['email'];  
} else {  
    die("User not found.");  
}  

// Handle form submission  
if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    $username = $_POST['username'];  
    $email = $_POST['email'];  

    // Validate input  
    if (empty($username) || empty($email)) {  
        $error = "Username and email cannot be empty.";  
    } else {  
        // Prepare and execute the update statement  
        try {  
            $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");  
            $stmt->execute([$username, $email, $user_id]);  

            // Add notification  
            $message = "Profile updated successfully.";  
            $stmt = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");  
            $stmt->execute([$user_id, $message]);  

            $success = "Profile updated!";  
            // Re-fetch user data to reflect changes  
            $stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = ?");  
            $stmt->execute([$user_id]);  
            $user = $stmt->fetch();  
            $username = $user['username'];  
            $email = $user['email'];  

        } catch (PDOException $e) {  
            error_log("Database update failed: " . $e->getMessage());  
            $error = "An error occurred while updating your profile.";  
        }  
    }  
}  
?>  


<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>User Profile</title>  
    <style>  
        body {  
            font-family: 'Arial', sans-serif;  
            background-color: #f4f4f4;  
            color: #333;  
            margin: 0;  
            padding: 0;  
        }  

        header {  
            background-color: #6c5ce7;  
            color: white;  
            padding: 20px 0;  
            text-align: center;  
        }  

        .container {  
            max-width: 600px;  
            margin: 50px auto;  
            padding: 20px;  
            background: white;  
            border-radius: 8px;  
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);  
        }  

        h1 {  
            margin: 0 0 20px;  
        }  

        .profile-form {  
            display: flex;  
            flex-direction: column;  
        }  

        .form-group {  
            margin-bottom: 15px;  
        }  

        label {  
            margin-bottom: 5px;  
            font-weight: bold;  
        }  

        input {  
            padding: 10px;  
            border: 1px solid #ccc;  
            border-radius: 4px;  
            font-size: 16px;  
        }  

        input:focus {  
            border-color: #6c5ce7;  
            outline: none;  
        }  

        .btn-update {  
            padding: 10px;  
            background-color: #6c5ce7;  
            color: white;  
            border: none;  
            border-radius: 4px;  
            cursor: pointer;  
            transition: background 0.3s;  
        }  

        .btn-update:hover {  
            background-color: #5a47d1;  
        }  

        .success {  
            margin-top: 15px;  
            color: green;  
            text-align: center;  
        }  

        .link-manage-events {  
            display: block;  
            margin-top: 20px;  
            text-align: center;  
            color: #6c5ce7;  
            text-decoration: none;  
        }  

        .link-manage-events:hover {  
            text-decoration: underline;  
        }  
    </style>  
</head>  
<body>  
<header>  
    <h1>User Profile</h1>  
</header>  

<main>  
    <div class="container">  
        <form method="POST" action="profile.php" class="profile-form">  
            <div class="form-group">  
                <label for="username">Username:</label>  
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>  
            </div>  
            <div class="form-group">  
                <label for="email">Email:</label>  
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>  
            </div>  
            <button type="submit" class="btn-update">Update Profile</button>  
            <?php if ($success): ?>  
                <div class="success"><?php echo $success; ?></div>  
            <?php endif; ?>  
        </form>  
        <p><a href="manage_events.php" class="link-manage-events">Manage Your Events</a></p>  
    </div>  
</main>  

<footer>  
    <p>&copy; 2024 Event Management App</p>  
</footer>  
</body>  
</html>