<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: voters_login.php");
    exit();
}

// Check if the user's name is set in the session
if (!isset($_SESSION["user_name"])) {
    // Retrieve the name from the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "admin";

    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve the name from the database using the user's ID
    $userId = $_SESSION["user_id"];
    $query = "SELECT name FROM registration WHERE id = $userId";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful and retrieve the name
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $_SESSION["user_name"] = $name; // Store the name in the session for future use
    } else {
        $name = "Unknown";
    }

    mysqli_close($conn);
} else {
    // Retrieve the user's name from the session
    $name = $_SESSION["user_name"];
}

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the list of year levels
$query = "SELECT DISTINCT year_level FROM elektrons_candidates";
$result = $conn->query($query);

// Retrieve candidates based on the selected year level
if (isset($_GET['yearLevel'])) {
    $selectedYearLevel = $_GET['yearLevel'];
    $query = "SELECT * FROM elektrons_candidates WHERE year_level = '$selectedYearLevel'";
    $candidatesResult = $conn->query($query);
    $candidates = $candidatesResult->fetch_all(MYSQLI_ASSOC);
}

// Retrieve the settings data
$query = "SELECT * FROM elektrons_settings";
$settingsResult = $conn->query($query);
$settings = $settingsResult->fetch_assoc();

// Retrieve the distinct positions for the selected year level
if (isset($_GET['yearLevel'])) {
    $selectedYearLevel = $_GET['yearLevel'];
    $query = "SELECT DISTINCT position FROM elektrons_candidates WHERE year_level = '$selectedYearLevel'";
    $positionsResult = $conn->query($query);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['vote'])) {
    $selectedCandidateId = $_POST['candidate_id'];

    // Check if the user has already voted for the selected position
    $userId = $_SESSION["user_id"];
    $selectedPosition = $_GET['position'];
    $query = "SELECT * FROM votes WHERE user_id = $userId AND position = '$selectedPosition'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // User has already voted for this position
        echo "<script>alert('You have already voted for this position.');</script>";
    } else {
        // Update the candidate's score and record the vote
        $query = "UPDATE elektrons_candidates SET score = score + 1 WHERE id = $selectedCandidateId";
        $conn->query($query);

        $query = "INSERT INTO votes (user_id, position) VALUES ($userId, '$selectedPosition')";
        $conn->query($query);

        // Redirect to the same page to prevent resubmission
        header("Location: ".$_SERVER['REQUEST_URI']);
        exit();
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Elektrons Candidates</title>
    <link href="https://fonts.googleapis.com/css?family=Exo+2&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Exo&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="position.css">
</head>
<body>
    <div class="page">
        <div class="banner"></div>
        <div class="dashboard_cont">
            <h1>Welcome, <?php echo isset($name) ? $name : "Unknown"; ?>!</h1>

            <?php if (!isset($_GET['yearLevel']) && $result->num_rows > 0) { ?>
                <h3>Select Year Level:</h3>
                <form method="GET" action="">
                    <?php
                    // Display year level buttons
                    while ($row = $result->fetch_assoc()) {
                        $yearLevel = $row['year_level'];
                        echo "<button type='submit' name='yearLevel' value='$yearLevel'>$yearLevel</button>";
                    }
                    ?>
                </form>
            <?php } ?>

            <?php if (isset($_GET['yearLevel']) && isset($positionsResult) && $positionsResult->num_rows > 0) { ?>
                <h3>Select Position:</h3>
                <form method="GET" action="">
                    <input type="hidden" name="yearLevel" value="<?php echo $selectedYearLevel; ?>">
                    <?php while ($row = $positionsResult->fetch_assoc()) { ?>
                        <?php $position = $row['position']; ?>
                        <button type="submit" name="position" value="<?php echo $position; ?>"><?php echo $position; ?></button>
                    <?php } ?>
                </form>
            <?php } ?>

            <?php if (isset($_GET['position']) && isset($candidates)) { ?>
                <?php $selectedPosition = $_GET['position']; ?>
                <h3>Candidates for Position: <?php echo $selectedPosition; ?></h3>
                <ul>
                    <?php foreach ($candidates as $candidate) { ?>
                        <?php if ($candidate['position'] === $selectedPosition) { ?>
                            <li>
                                <?php echo $candidate['name']; ?>
                                <form method="POST" action="">
                                    <input type="hidden" name="candidate_id" value="<?php echo $candidate['id']; ?>">
                                    <button type="submit" name="vote">Vote</button>
                                </form>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
        <div class="user_img"></div>
        <div class="dashboard_icon"></div>
    </div>

   <div class="top-right" style="position: relative; z-index: 9999;">
    <?php if (isset($settings)) { ?>
        <p>Settings:</p>
        <p style="color: black;">Description: <?php echo $settings['description']; ?></p>
        <p style="color: black;">Duration: <?php echo $settings['duration_from']; ?> - <?php echo $settings['duration_to']; ?></p>
    <?php } else { ?>
        <p>No settings available</p>
    <?php } ?>
</div>

</body>
</html>
