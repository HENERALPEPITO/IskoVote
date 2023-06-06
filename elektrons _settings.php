<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "admin";

    // Get the submitted form data
    $description = $_POST["description"];
    $durationFrom = $_POST["duration-from"];
    $durationTo = $_POST["duration-to"];

    // Establish database connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL statement to insert form data into the database
    $stmt = $conn->prepare("INSERT INTO election_settings (description, duration_from, duration_to) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $description, $durationFrom, $durationTo);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    // Redirect to elektrons_candidates.html
    header("Location: elektrons_candidates.php");
    exit;
}
?>
