<!--
Name: Ayemyat Oo, Maria Babko
File Creation Date: 11/30/2023

Overview:
The inicidents page of Traffic See

Major Funcions:
Sort and display different incidents based on zipcode and type.
Also is able to display all incidents happening.

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
        <!-- add a reference to the external stylesheet -->
        <link rel="stylesheet" href="https://bootswatch.com/4/journal/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Tab tracker java script -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

        <!-- Keeps track of which tab user is on -->
        <script>
            $(document).ready(function(){
                $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                    sessionStorage.setItem('activeIncidentsTab', $(e.target).attr('href'));
                });
                var activeIncidentsTab = sessionStorage.getItem('activeIncidentsTab');

                if(activeIncidentsTab){

                    $('#incidentsTab a[href="' + activeIncidentsTab + '"]').tab('show');


                }
            });


        </script>
    </head>

    <body>
        <!-- START -- Add HTML code for the top menu section (navigation bar) -->
        <style>
            .body {
                background-color: #f8f9fa;
            }



            .tab-content {
                margin: 20px auto;
            }

            .search-container {
                margin: 20px auto;
                padding: 20px;
                padding-bottom: 100px;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

        </style>

        <nav class="navbar navbar-expand-lg navbar-dark bg-primary" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"><img src="TrafficSee.png" alt="traffic see logo" width="65" height="65"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
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
                        <li class="nav-item active">
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
            <h1 class="display-3">Incidents</h1>
            <p class="lead">Find information about incidents happening near you that could impact your commute<p>
            <hr class="my-4">

            <h3> Find information about Incidents:</h3>

            <div class="search-container">
                <ul class="nav nav-tabs" role="tablist" id="incidentsTab">
                    <li class="nav-item" role="presentation">
                        <a href="#allincidents" class="nav-link active" data-toggle="tab" aria-selected="true" role="tab">All Incidents</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#zipcode" class="nav-link" data-toggle="tab" aria-selected="false" role="tab">By Zipcode</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#type" class="nav-link" data-toggle="tab" aria-selected="false" role="tab">By Type</a>
                    </li>

                </ul>

                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active show" id="allincidents" role="tabpanel">

                        <form method="GET" action="incidents.php" style="display: inline-block; padding-right: 30px;">
                            <input type="checkbox" value="allincidents" id="allincidents" name="allincidents">
                            <label for="allincidents">List all incidents</label>
                            <input type="submit" onchange='this.form.submit()'>

                            <?php
                            $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                            if ($_SERVER["REQUEST_METHOD"] == "GET")
                            {
                                if (isset($_GET['allincidents']) )
                                {
                            ?>
                            <p>&nbsp;</p>
                            <!-- Set up table headers -->
                            <table class="table table-hover">
                                <thead>
                                    <tr class="table-success">
                                        <th scope="col">Incident Type</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">City</th>
                                        <th scope="col">County</th>
                                        <th scope="col">Time Delay</th>


                                    </tr>
                                </thead>
                                <?php
                                    if ( mysqli_connect_errno() )
                                    {
                                        die( mysqli_connect_error() );
                                    }
                                    // Runs a SQL query to display all incidents and info about them
                                    $sql = " SELECT IncType, IncidentLocation, CLU.City, County, TimeDelay
                                            FROM INCIDENT I JOIN ZIPCODE Z ON I.IncidentLocation = Z.Zipcode
                                            JOIN CITY_LOOK_UP CLU ON Z.City = CLU.City";
                                    //echo $sql;
                                    if ($result = mysqli_query($connection, $sql))
                                    {
                                        while($row = mysqli_fetch_assoc($result))
                                        {
                                ?>
                                <!-- Display the info in a table -->
                                <tr>
                                    <td><?php echo $row['IncType'] ?></td>
                                    <td><?php echo $row['IncidentLocation'] ?></td>
                                    <td><?php echo $row['City'] ?></td>
                                    <td><?php echo $row['County'] ?></td>
                                    <td><?php echo $row['TimeDelay'] ?></td>
                                </tr>
                                <?php
                                        }
                                        // release the memory used by the result set
                                        mysqli_free_result($result);
                                    }
                                } // end if (isset)
                            } // end if ($_SERVER)
                                ?>
                            </table>

                        </form>

                    </div>

                    <div class="tab-pane fade" id="zipcode" role="tabpanel">

                        <form method="GET" action="incidents.php" style="display: inline-block; padding-right: 30px;">
                            <select name="zipcode" onchange='this.form.submit()'>
                                <option selected>Select a zipcode</option>
                                <?php
                                $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                                if ( mysqli_connect_errno() )
                                {
                                    die( mysqli_connect_error() );
                                }
                                //Select a project location from a drop down and store that result
                                // for the SQL query
                                $sql = "select DISTINCT IncidentLocation from INCIDENT";
                                if ($result = mysqli_query($connection, $sql))
                                {
                                    // loop through the data
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo '<option value="'. $row['IncidentLocation'] .'">';
                                        echo $row['IncidentLocation'];
                                        echo "</option>";
                                    }
                                    // release the memory used by the result set
                                    mysqli_free_result($result);
                                }
                                ?>
                            </select>
                            <?php
                            if ($_SERVER["REQUEST_METHOD"] == "GET")
                            {
                                if (isset($_GET['zipcode']) )
                                {
                            ?>
                            <p>&nbsp;</p>
                            <!-- Set up table headers -->
                            <table class="table table-hover">
                                <thead>
                                    <tr class="table-success">
                                        <th scope="col">Incident Type</th>
                                        <th scope="col">Time Delay</th>
                                    </tr>
                                </thead>
                                <?php
                                    if ( mysqli_connect_errno() )
                                    {
                                        die( mysqli_connect_error() );
                                    }
                                    // Runs a SQL query to find information on incidents based on zipcode
                                    $sql = " SELECT IncType, TimeDelay
                                      FROM INCIDENT I
                                      WHERE I.IncidentLocation = {$_GET['zipcode']}";

                                    if ($result = mysqli_query($connection, $sql))
                                    {
                                        while($row = mysqli_fetch_assoc($result))
                                        {
                                ?>
                                <!-- Display the info in a table -->
                                <tr>
                                    <td><?php echo $row['IncType'] ?></td>
                                    <td><?php echo $row['TimeDelay'] ?></td>
                                </tr>
                                <?php
                                        }
                                        // release the memory used by the result set
                                        mysqli_free_result($result);
                                    }
                                } // end if (isset)
                            } // end if ($_SERVER)
                                ?>
                            </table>
                        </form>


                    </div>
                    <div class="tab-pane fade" id="type" role="tabpanel">
                        <form method="GET" action="incidents.php" style="display: inline-block">
                            <select name="type" onchange='this.form.submit()'>
                                <option selected>Select an incident type</option>
                                <?php
                                $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                                if ( mysqli_connect_errno() )
                                {
                                    die( mysqli_connect_error() );
                                }
                                //Select a project location from a drop down and store that result
                                // for the SQL query
                                $sql = "select DISTINCT IncType from INCIDENT";
                                if ($result = mysqli_query($connection, $sql))
                                {
                                    // loop through the data
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo '<option value="'. $row['IncType'] .'">';
                                        echo $row['IncType'];
                                        echo "</option>";
                                    }
                                    // release the memory used by the result set
                                    mysqli_free_result($result);
                                }
                                ?>
                            </select>
                            <?php
                            if ($_SERVER["REQUEST_METHOD"] == "GET")
                            {
                                if (isset($_GET['type']) )
                                {
                            ?>
                            <p>&nbsp;</p>
                            <!-- Set up table headers -->
                            <table class="table table-hover">
                                <thead>
                                    <tr class="table-success">
                                        <th scope="col">Incident Type</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">City</th>
                                        <th scope="col">County</th>
                                    </tr>
                                </thead>
                                <?php
                                    if ( mysqli_connect_errno() )
                                    {
                                        die( mysqli_connect_error() );
                                    }
                                    // Runs a SQL query to find information on incidents based on incident type
                                    $sql = " SELECT IncType, IncidentLocation, Z.City AS ZCity, County
                                      FROM (INCIDENT I JOIN ZIPCODE Z ON I.IncidentLocation = Z.Zipcode JOIN CITY_LOOK_UP C ON Z.City = C.City)
                                      WHERE I.IncType = '{$_GET['type']}'";

                                    if ($result = mysqli_query($connection, $sql))
                                    {
                                        while($row = mysqli_fetch_assoc($result))
                                        {
                                ?>
                                <!-- Display the info in a table -->
                                <tr>
                                    <td><?php echo $row['IncType'] ?></td>
                                    <td><?php echo $row['IncidentLocation'] ?></td>
                                    <td><?php echo $row['ZCity'] ?></td>
                                    <td><?php echo $row['County'] ?></td>
                                </tr>
                                <?php
                                        }
                                        // release the memory used by the result set
                                        mysqli_free_result($result);
                                    }
                                } // end if (isset)
                            } // end if ($_SERVER)
                                ?>
                            </table>
                        </form>
                    </div>

                </div>
            </div>
        </div>


        <!-- Footer Section -->
        <footer class="mt-5 p-3 text-center bg-dark text-white">
            <p>&copy; 2023 Traffic See. All rights reserved.</p>
        </footer>
    </body>
</html>