<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the skimmers_candidates table
$sql = "SELECT year_level, position, score, name FROM skimmers_candidates";
$result = $conn->query($sql);

$yearLevels = array();         // Array to store year levels
$positions = array();          // Array to store positions
$scores = array();             // Array to store scores
$names = array();              // Array to store candidate names

// Process the query result
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $yearLevels[] = $row['year_level'];
        $positions[] = $row['position'];
        $scores[] = $row['score'];
        $names[] = $row['name'] . ' (' . $row['position'] . ')'; // Include position in the candidate's name
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=1440, maximum-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="globalcss.css" />
    <link rel="stylesheet" type="text/css" href="skimmers_homepage.css" />
    <link href="https://fonts.googleapis.com/css?family=Exo&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Exo+2&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container-center-horizontal">
    <div class="votingResults">
        <div class="header">
            <p id="uni">University of the Philippines Visayas</p>
            <a href="HomePage.html"><img src="ivIcon.png" id="iv"></a>
        </div>
        <div class="content">
            <div class="sidebar">
                <div class="user">
                    <h1>Current Scores</h1>
                </div>
                <button id="CD" onclick="Candidates()">Candidates</button>
                <button id="VW" onclick="ViewScores()">View Scores</button>
                <script>
                    function Candidates() {
                        location.replace("skimmers_homepage.php");
                    }
                    function ViewScores() {
                        location.replace("skimmers_voting_results.php");
                    }
                </script>
            </div>
            <div class="results">
                <div class="resultExit">
                    <a href="skimmers_homepage.php" id="return">Return to Elections</a>
                </div>
                <div class="scores">
                    <div class="yearLevels" id="yearLevelButtons">
                        <?php
                        // Generate a button per year level
                        $uniqueYearLevels = array_unique($yearLevels);
                        foreach ($uniqueYearLevels as $yearLevel) {
                            echo '<button class="yearLevelButton" onclick="displayGraph(\'' . $yearLevel . '\')">' . $yearLevel . '</button>';
                        }
                        ?>
                    </div>
                    <div class="resultGraph">
                        <h3 id="positionLabel"></h3>
                        <canvas id="scoreDisplay"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <p id="copy">Copyright © 2023. All Rights Reserved.</p>
        </div>
    </div>
</div>

<script>
        // Retrieve the canvas element and create a bar chart
        var ctx = document.getElementById("scoreDisplay").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($names); ?>,
                datasets: [{
                    label: 'Scores',
                    data: <?php echo json_encode($scores); ?>,
                    backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 206, 86, 0.2)'], // Add more colors if needed
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)', 'rgba(255, 206, 86, 1)'], // Add more colors if needed
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

    // Function to display the graph for a specific year level
    function displayGraph(yearLevel) {
        // Filter the data based on the selected year level
        var filteredPositions = <?php echo json_encode($positions); ?>.filter(function(value, index) {
            return <?php echo json_encode($yearLevels); ?>[index] === yearLevel;
        });
        var filteredScores = <?php echo json_encode($scores); ?>.filter(function(value, index) {
            return <?php echo json_encode($yearLevels); ?>[index] === yearLevel;
        });
        var filteredNames = <?php echo json_encode($names); ?>.filter(function(value, index) {
            return <?php echo json_encode($yearLevels); ?>[index] === yearLevel;
        });

        // Update the chart with the filtered data
        myChart.data.labels = filteredNames;
        myChart.data.datasets[0].data = filteredScores;
        myChart.update();

        // Update the position label
        document.getElementById("positionLabel").innerHTML = "Year Level: " + yearLevel;
    }
</script>
</body>
</html>
