<!--
Name: Greg Yi
File Creation Date: 11/30/2023

Overview:
The routes page of Traffic See

Major Funcions:
Calculates and displays commute time as well as incidents
and events happening for the user's route
-->

<?php
error_reporting(-1);
ini_set('display_errors', 'On');
require_once('config.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Traffic See</title>
        <link rel="stylesheet" href="https://bootswatch.com/4/journal/bootstrap.min.css">
    </head>
    <body>
        <style>
            .search-container {
                margin: 20px auto;
                padding: 20px;
                padding-bottom: 150px;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
        </style>

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
                            <a class="nav-link active" href="routes.php">Plan A Route</a>
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

        <div class="jumbotron">
            <h1 class="display-3">Plan A Route</h1>
            <p class="lead">Put in your starting and ending destination and we'll let you know how long it will take!<p>
            <hr class="my-4">

            <div class="search-container">
                <form method="GET" action="routes.php">
                    <p>Starting Zipcode:</p>
                    <select name="start_zipcode">
                        <option selected>Select a zipcode</option>
                        <?php
                        $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                        if (mysqli_connect_errno()) {
                            die(mysqli_connect_error());
                        }
                        $sql = "SELECT zipcode FROM ZIPCODE";
                        if ($result = mysqli_query($connection, $sql)) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $row['zipcode'] . '">';
                                echo $row['zipcode'];
                                echo "</option>";
                            }
                            mysqli_free_result($result);
                        }
                        ?>
                    </select>
                    <img src="doubleArrow.png" alt="double arrow" width=18%>
                    <p>Ending Zipcode: </p>
                    <select name="end_zipcode">
                        <option selected>Select a zipcode</option>
                        <?php
                        if ($result = mysqli_query($connection, $sql)) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $row['zipcode'] . '">';
                                echo $row['zipcode'];
                                echo "</option>";
                            }
                            mysqli_free_result($result);
                        }
                        ?>
                    </select>
                    <input type="submit" value="Calculate Route">
                </form>
            </div>
        </div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['start_zipcode']) && isset($_GET['end_zipcode'])) {
            $startZip = $_GET['start_zipcode'];
            $endZip = $_GET['end_zipcode'];
            $travelDistance = abs($endZip - $startZip) * 35;

            // Query for incidents
            $incidentSql = "SELECT * FROM INCIDENT WHERE IncidentLocation BETWEEN $startZip AND $endZip";
            $totalDelay = 0;
            if ($result = mysqli_query($connection, $incidentSql)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "Incident: " . $row['IncType'] . " at " . $row['IncidentLocation'] . " - Delay: " . $row['TimeDelay'] . " minutes<br>";
                    $totalDelay += $row['TimeDelay'];
                }
                mysqli_free_result($result);
            }

            // Query for events
            $eventSql = "SELECT * FROM EVENT WHERE EventLocation BETWEEN $startZip AND $endZip";
            if ($result = mysqli_query($connection, $eventSql)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "Event: " . $row['EventName'] . " at " . $row['EventLocation'] . "<br>";
                }
                mysqli_free_result($result);
            }

            $totalTravelTime = $travelDistance + $totalDelay;
            echo "Actual Travel Distance: " . $travelDistance . " minutes<br>";
            echo "Total Estimated Travel Time with Delays: " . $totalTravelTime . " minutes<br>";
        }
        ?>

        <footer class="mt-5 p-3 text-center bg-dark text-white">
            <p>&copy; 2023 Traffic See. All rights reserved.</p>
        </footer>
    </body>
</html>
