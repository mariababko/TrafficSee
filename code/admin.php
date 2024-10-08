<!--
Name:Maria Babko
File Creation Date: 12/6/2023

Overview:
The admin page of Traffic See

Major Funcions:
For users with premium accounts.
Premium accounts get access to SQL queries that display 
info about user commuter data
-->


<?php 
error_reporting(-1);
ini_set('display_errors', 'On');
require_once('config.php'); ?>

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
                    console.log("hello");
                    sessionStorage.setItem('activeAdminTab', $(e.target).attr('href'));
                });
                var activeAdminTab = sessionStorage.getItem('activeAdminTab');
                console.log(activeAdminTab);
                if(activeAdminTab){
                    console.log("yes");
                    $('#adminTab a[href="' + activeAdminTab + '"]').tab('show');
                    console.log( $('#adminTab a[href="' + activeAdminTab + '"]').tab('show'));

                }
            });
        </script>

    </head>
    <body>
        
        <style>


            .tab-content {
                margin: 20px auto;
            }



            .search-container {
                margin: 20px auto;
                padding: 20px;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            }

        </style>

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
            <h1 class="display-3">Admin</h1>
            </div>

        <div class="container mt-4">
            <h3>For users with premium accounts</h3>
            <p>
                Premium accounts get access to user commuter data and can extrapolate from that. For any companies
                or organizers looking to see user traffic in certain areas.
            </p>



            <div class="search-container">
                <ul class="nav nav-tabs" role="tablist" id="adminTab">
                    <li class="nav-item" role="presentation">
                        <a href="#totdistance" class="nav-link active" data-toggle="tab" aria-selected="true" role="tab">Total Distance Traveled</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#county" class="nav-link" data-toggle="tab" aria-selected="false" role="tab">Commutes Per County</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#city" class="nav-link" data-toggle="tab" aria-selected="false" role="tab">Commutes Per City Lived In</a>
                    </li>


                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active show" id="totdistance" role="tabpanel">

                        <p>Find out the total distance traveled by users per city</p>

                        <form method="GET" action="admin.php" style="display: inline-block; padding-right: 30px;">
                            <input type="checkbox" value="totdistance" id="distance" name="totdistance">
                            <label for="distance">Calculate Total Distance</label>
                            <input type="submit" onchange='this.form.submit()'>

                            <?php
                            $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                            if ($_SERVER["REQUEST_METHOD"] == "GET")
                            {
                                if (isset($_GET['totdistance']) )
                                {
                            ?>
                            <p>&nbsp;</p>
                            <!-- Set up table headers -->
                            <table class="table table-hover">
                                <thead>
                                    <tr class="table-success">
                                        <th scope="col">City</th>
                                        <th scope="col">Number of Users</th>
                                        <th scope="col">Total Distance Traveled</th>
                                    </tr>
                                </thead>
                                <?php
                                    if ( mysqli_connect_errno() )
                                    {
                                        die( mysqli_connect_error() );
                                    }
                                    // Runs a SQL query to find out the total distance traveled by users per city
                                    $sql = " SELECT Z.City AS 'City', COUNT(U.Username) AS 'Number of Users', SUM((ABS(R.EndingZipcode - R.StartingZipcode))*35) AS 'Total Distance Traveled'
                                            FROM ROUTE R JOIN USER U ON R.Username = U.Username
                                            JOIN ZIPCODE Z ON Z.Zipcode = U.HomeAddress
                                            GROUP BY Z.City
                                            ORDER BY SUM((ABS(R.EndingZipcode - R.StartingZipcode))*35) DESC";
                                    //echo $sql;
                                    if ($result = mysqli_query($connection, $sql))
                                    {
                                        while($row = mysqli_fetch_assoc($result))
                                        {
                                ?>
                                <!-- Display the info in a table -->
                                <tr>
                                    <td><?php echo $row['City'] ?></td>
                                    <td><?php echo $row['Number of Users'] ?></td>
                                    <td><?php echo $row['Total Distance Traveled'] ?></td>
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


                    <div class="tab-pane fade" id="county" role="tabpanel">

                        <p>
                            See how far users are commuting in a specific county
                        </p>

                        <form method="GET" action="admin.php" style="display: inline-block; padding-right: 30px;">
                            <select name="county" onchange='this.form.submit()'>
                                <option selected>Select a county</option>
                                <?php
                                $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                                if ( mysqli_connect_errno() )
                                {
                                    die( mysqli_connect_error() );
                                }
                                //Select a project location from a drop down and store that result
                                // for the SQL query
                                $sql = "select DISTINCT County from CITY_LOOK_UP";
                                if ($result = mysqli_query($connection, $sql))
                                {
                                    // loop through the data
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo '<option value="'. $row['County'] .'">';
                                        echo $row['County'];
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
                                if (isset($_GET['county']) )
                                {
                            ?>
                            <p>&nbsp;</p>
                            <!-- Set up table headers -->
                            <table class="table table-hover">
                                <thead>
                                    <tr class="table-success">
                                        <th scope="col">User</th>
                                        <th scope="col">Distance</th>
                                    </tr>
                                </thead>
                                <?php
                                    if ( mysqli_connect_errno() )
                                    {
                                        die( mysqli_connect_error() );
                                    }
                                    // Runs a SQL query to find how far users are commuting in a specific county
                                    $sql = " SELECT U.Username, (ABS(R.EndingZipcode - R.StartingZipcode))*35 AS 'Distance'
                                            FROM ROUTE R JOIN USER U ON R.Username = U.Username
                                            JOIN ZIPCODE Z ON Z.Zipcode = U.HomeAddress
                                            JOIN CITY_LOOK_UP CLU ON Z.City = CLU.City
                                            WHERE CLU.County = '{$_GET['county']}';";

                                    if ($result = mysqli_query($connection, $sql))
                                    {
                                        while($row = mysqli_fetch_assoc($result))
                                        {
                                ?>
                                <!-- Display the info in a table -->
                                <tr>
                                    <td><?php echo $row['Username'] ?></td>
                                    <td><?php echo $row['Distance'] ?></td>

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
                    

                    <div class="tab-pane fade" id="city" role="tabpanel">

                        <p>
                            Find out what routes users are taking who live in a specific city
                        </p>

                        <form method="GET" action="admin.php" style="display: inline-block; padding-right: 30px;">
                            <select name="city" onchange='this.form.submit()'>
                                <option selected>Select a city</option>
                                <?php
                                $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                                if ( mysqli_connect_errno() )
                                {
                                    die( mysqli_connect_error() );
                                }
                                //Select a project location from a drop down and store that result
                                // for the SQL query
                                $sql = "select City from CITY_LOOK_UP";
                                if ($result = mysqli_query($connection, $sql))
                                {
                                    // loop through the data
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo '<option value="'. $row['City'] .'">';
                                        echo $row['City'];
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
                                if (isset($_GET['city']) )
                                {
                            ?>
                            <p>&nbsp;</p>
                            <!-- Set up table headers -->
                            <table class="table table-hover">
                                <thead>
                                    <tr class="table-success">
                                        <th scope="col">Username</th>
                                        <th scope="col">Starting Point</th>
                                        <th scope="col">Destination</th>
                                    </tr>
                                </thead>
                                <?php
                                    if ( mysqli_connect_errno() )
                                    {
                                        die( mysqli_connect_error() );
                                    }
                                    // Runs a SQL query to find what routes users are taking who live in a specific city
                                    $sql = " SELECT U.Username, R.StartingZipcode AS 'Starting Point', R.EndingZipcode AS 'Destination'
                                        FROM ROUTE R JOIN USER U ON R.Username = U.Username
                                        JOIN ZIPCODE Z ON Z.Zipcode = U.HomeAddress
                                        JOIN CITY_LOOK_UP CLU ON Z.City = CLU.City
                                        WHERE CLU.City = '{$_GET['city']}'";

                                    if ($result = mysqli_query($connection, $sql))
                                    {
                                        while($row = mysqli_fetch_assoc($result))
                                        {
                                ?>
                                <!-- Display the info in a table -->
                                <tr>
                                    <td><?php echo $row['Username'] ?></td>
                                    <td><?php echo $row['Starting Point'] ?></td>
                                    <td><?php echo $row['Destination'] ?></td>
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