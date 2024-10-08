<!--
Name: Ayemyat Oo, Maria Babko
File Creation Date: 11/30/2023

Overview:
The about page of Traffic See

Major Funcions:
Shows information about the project
-->

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Traffic See</title>
        <!-- add a reference to the external stylesheet -->
        <link rel="stylesheet" href="https://bootswatch.com/4/journal/bootstrap.min.css">
    </head>
    <body>
        <!-- START -- Add HTML code for the top menu section (navigation bar) -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"><img src="TrafficSee.png" alt="traffic see logo" width="65" height="65"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03"
                        aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarColor03">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="routes.php">Plan A Route</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="events.php">Events</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="incidents.php">Incidents</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="about.php">About</a>
                        </li>
                    </ul>
                </div>
                
                <a class="btn btn-info btn-lg" href="admin.php" role="button">Admin</a>

            </div>
        </nav>
        <!-- END -- Add HTML code for the top menu section (navigation bar) -->

        <!-- Displays a welcome message and welcomes the users to the home page. -->
        <div class="jumbotron">
            <h1 class="display-3">About</h1>

        </div>
        <div class="container mt-4">
            <img src="TrafficSee.png" alt="Traffic See logo" width=200px style="display: block; margin: auto;">

            <h2>About Traffic See</h2>
            <p>
                Traffic See is a platform dedicated to providing real-time information about traffic incidents
                and events to help commuters plan their routes efficiently. Our goal is to enhance the commuting
                experience by delivering timely and accurate updates on road conditions, construction, accidents,
                and other incidents that may affect travel.
            </p>

            <h3>Our Mission</h3>
            <p>
                Our mission is to empower commuters with the information they need to make informed decisions
                about their daily travels and information about the events. By offering a comprehensive view of traffic incidents, we aim to reduce
                commute times, minimize disruptions, and contribute to a smoother and safer transportation experience.
            </p>

            <h3>Contact Us</h3>
            <p>
                Have questions or suggestions? Feel free to reach out to us at <a href="mailto:info@trafficsee.com">info@trafficsee.com</a>.
            </p>
        </div>

        <!-- Footer Section -->
        <footer class="mt-5 p-3 text-center bg-dark text-white">
            <p>&copy; 2023 Traffic See. All rights reserved.</p>
        </footer>

        <!-- Bootstrap JavaScript dependencies -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>