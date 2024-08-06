<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Event Management App</title>  
    <link rel="stylesheet" href="styles.css">  
    <style>  
        body {  
            font-family: Arial, sans-serif;  
            margin: 0;  
            padding: 0;  
            background-color: #f4f4f4;  
        }  

        header {  
            position: relative;  
            height: 400px; /* Adjust height as needed */  
            overflow: hidden;  
        }  

        .video-container {  
            position: absolute;  
            top: 0;  
            left: 0;  
            width: 100%;  
            height: 100%;  
            overflow: hidden;  
        }  

        video {  
            width: 100%;  
            height: 100%;  
            object-fit: cover;  
        }  

        .header-content {  
            position: absolute;  
            top: 50%;  
            left: 50%;  
            transform: translate(-50%, -50%);  
            color: white; /* Change text color for visibility */  
            text-align: center;  
            z-index: 1; /* Ensure text appears above the video */  
        }  

        .cta-button {  
            display: inline-block;  
            padding: 10px 20px;  
            margin-top: 15px;  
            background-color: #007bff;  
            color: white;  
            text-decoration: none;  
            border-radius: 5px;  
        }  

        /* Additional styles for sections below */  
        main {  
            padding: 20px;  
        }  

        .upcoming-events {  
            margin-top: 20px;  
        }  

        .event-list {  
            display: flex;  
            flex-wrap: wrap;  
            gap: 20px;  
        }  

        .event {  
            background-color: white;  
            border-radius: 8px;  
            overflow: hidden;  
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);  
            width: calc(33% - 20px); /* Adjust for 3 items per row */  
        }  

        .event-image {  
            width: 100%;  
            height: 200px;  
            object-fit: cover;  
        }  

        .event-details {  
            padding: 15px;  
        }  

        .event-title {  
            font-size: 1.5rem;  
            margin-bottom: 10px;  
        }  

        .event-date {  
            color: #555;  
        }  

        .how-it-works {  
            background-color: #eaeaea;  
            padding: 20px;  
            border-radius: 8px;  
        }  

        .steps {  
            display: flex;  
            flex-direction: column;  
            align-items: center;  
        }  

        .step {  
            margin: 20px 0;  
        }  

        footer {  
            text-align: center;  
            padding: 15px;  
            background-color: #007bff;  
            color: white;  
        }  

        .how-it-works {  
    background-color: #f9f9f9; /* Light background for contrast */  
    padding: 40px 20px;   
    text-align: center;  
    border-radius: 8px;   
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */  
}  

.steps {  
    display: flex;  
    justify-content: center;  
    gap: 30px; /* Spacing between steps */  
    flex-wrap: wrap; /* Allow wrapping for smaller screens */  
}  

.step {  
    background-color: #ffffff; /* White background for steps */  
    border: 1px solid #e0e0e0; /* Light border */  
    border-radius: 8px;   
    padding: 20px;  
    width: 250px; /* Fixed width for all steps */  
    transition: transform 0.3s; /* Animation for hover effect */  
}  

.step:hover {  
    transform: translateY(-5px); /* Lift effect on hover */  
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15); /* Shadow on hover */  
}  

.step-icon {  
    background-color: #007bff; /* Primary color for icons */  
    color: white; /* White text for contrast */  
    border-radius: 50%;   
    width: 40px;   
    height: 40px;   
    display: flex;  
    align-items: center;  
    justify-content: center;  
    font-size: 20px; /* Icon text size */  
    margin: 0 auto 15px; /* Centering the icon */  
}  

h2 {  
    margin-bottom: 20px; /* Spacing below the heading */  
    font-size: 2em; /* Larger heading */  
    color: #333; /* Darker text color */  
}
    </style>  
</head>  
<body>  
    <header>  
        <div class="video-container">  
            <video id="eventVideo" autoplay muted loop=1>  
                <source src="81095-574743676_medium.mp4" type="video/mp4" >  
                Your browser does not support the video tag.  
            </video>  
        </div>  
        <div class="header-content">  
            <h1>Welcome to Our Event Management App</h1>  
            <p>Plan your events with ease and enjoy memorable experiences.</p>  
            <a href="signup.php" class="cta-button">Get Started</a>  
        </div>  
    </header>  

    <main>  
        <section class="upcoming-events">  
            <h2>Upcoming Events</h2>  
            <div class="event-list">  
                <div class="event">  
                    <img src="gradient-7258997_1280.png" alt="Event 1" class="event-image">  
                    <div class="event-details">  
                        <h3 class="event-title">Event 1 Title</h3>  
                        <p class="event-date">Date: January 10, 2024</p>  
                        <p>Description of the event goes here.</p>  
                    </div>  
                </div>  
                <div class="event">  
                    <img src="web-1012467_1280.jpg" alt="Event 2" class="event-image">  
                    <div class="event-details">  
                        <h3 class="event-title">Event 2 Title</h3>  
                        <p class="event-date">Date: February 15, 2024</p>  
                        <p>Description of the event goes here.</p>  
                    </div>  
                </div>  
                <div class="event">  
                    <img src="orange-feather-7074559_1280.jpg" alt="Event 3" class="event-image">  
                    <div class="event-details">  
                        <h3 class="event-title">Event 3 Title</h3>  
                        <p class="event-date">Date: March 20, 2024</p>  
                        <p>Description of the event goes here.</p>  
                    </div>  
                </div>  
                <!-- Add more events as needed -->  
            </div>  
        </section>  

        <section class="how-it-works">  
    <h2>How It Works</h2>  
    <div class="steps">  
        <div class="step">  
            <div class="step-icon">1</div>  
            <h3>Step 1</h3>  
            <p>Sign up and create your profile.</p>  
        </div>  
        <div class="step">  
            <div class="step-icon">2</div>  
            <h3>Step 2</h3>  
            <p>Create and manage your events easily.</p>  
        </div>  
        <div class="step">  
            <div class="step-icon">3</div>  
            <h3>Step 3</h3>  
            <p>Invite friends and share experiences!</p>  
        </div>  
    </div>  
</section>
    </main>  

    <footer>  
        <p>&copy; 2024 Event Management App</p>  
    </footer>  

    <script>  
        const video = document.getElementById('eventVideo');  

        // Show controls on mouse over  
        video.addEventListener('mouseenter', () => {  
            video.setAttribute('controls', 'controls');  
        });  

        // Hide controls on mouse leave  
        video.addEventListener('mouseleave', () => {  
            video.removeAttribute('controls');  
        });  
    </script>  
</body>  
</html>