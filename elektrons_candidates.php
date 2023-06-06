<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted candidate data
    $candidateNames = explode(",", $_POST["candidateName"]);
    $positions = explode(",", $_POST["position"]);
    $yearLevels = explode(",", $_POST["yearLevel"]);

    // Establish database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "admin";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL statement to insert candidate data into the database
    $stmt = $conn->prepare("INSERT INTO candidates (name, position, year_level) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $position, $yearLevel);

    // Loop through the submitted candidate data and insert each candidate into the database
    for ($i = 0; $i < count($candidateNames); $i++) {
        $name = $candidateNames[$i];
        $position = $positions[$i];
        $yearLevel = $yearLevels[$i];

        $stmt->execute();
    }

    $stmt->close();
    $conn->close();

    // Return a response back to the client
    header("HTTP/1.1 200 OK");
    echo "Candidates saved successfully!";
    exit;
}
?>
