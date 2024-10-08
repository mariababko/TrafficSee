<!--
Name: Maria Babko
File Creation Date: 11/30/2023

Overview:
The home page of Traffic See

Major Funcions:
Displays a welcome message and welcomes the users to the home page.
Users can click to learn more on all the features we offer.
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
                            <a class="nav-link active" href="index.php">Home
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

                        <li class="nav-item">
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
            <h1 class="display-3">Welcome to Traffic See!</h1>
            <p class="lead">We're exctited to have you. <p>
            <hr class="my-4">

            <div class="card text-white bg-info mb-3" style="max-width: 30rem; display: inline-block; margin-left:60px; margin-right:30px;">
                <div class="card-header">
                    <img src="route.png" alt="route map" width=400px style="margin-right:20px;">
                </div>
                <div class="card-body">
                    <h4 class="card-title">Plan A Route</h4>
                    <p class="card-text">Want to see how long your commute is going to be?</p>
                    <a class="btn btn-primary btn-lg" href="routes.php" role="button">Learn more</a>
                </div>
            </div>

            <div class="card text-white bg-info mb-3" style="max-width: 30rem; display: inline-block; margin-left:60px; margin-right:30px;">
                <div class="card-header">
                    <img src="event.jpg" alt="concert event" width=400px style="margin-right:20px;">
                </div>
                <div class="card-body">
                    <h4 class="card-title">Find an Event Near You</h4>
                    <p class="card-text">Want to find a fun place to go out to?</p>
                    <a class="btn btn-primary btn-lg" href="events.php" role="button">Learn more</a>
                </div>
            </div>

            <div class="card text-white bg-info mb-3" style="max-width: 30rem; display: inline-block; margin-left:60px; margin-right:30px;">
                <div class="card-header">
                    <img src="crash.jpg" alt="car crash" width=400px style="margin-right:20px;">
                </div>
                <div class="card-body">
                    <h4 class="card-title">Incidents</h4>
                    <p class="card-text">Want to see information about incidents around you?</p>
                    <a class="btn btn-primary btn-lg" href="incidents.php" role="button">Learn more</a>
                </div>
            </div>

            <div class="card text-white bg-info mb-3" style="max-width: 30rem; display: inline-block; margin-left:60px;">
                <div class="card-header">
                    <img src="typing.jpeg" alt="person typing on computer" width=400px style="margin-right:20px;">
                </div>
                <div class="card-body">
                    <h4 class="card-title">About</h4>
                    <p class="card-text">Want to find out information on this project?</p>
                    <a class="btn btn-primary btn-lg" href="about.php" role="button">Learn more</a>
                </div>
            </div>


        </div>
        
        <!-- Footer Section -->
        <footer class="mt-5 p-3 text-center bg-dark text-white">
            <p>&copy; 2023 Traffic See. All rights reserved.</p>
        </footer>
    </body>
</html>