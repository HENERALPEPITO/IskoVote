<?php
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

// Start the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve input values
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if the user exists in the database
    $sql = "SELECT organization FROM registration WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $organization = $row["organization"];

        // Redirect to the respective homepage based on the organization
        switch ($organization) {
            case "ELEKTRONS":
                header("Location: elektrons_homepage.html");
                break;
            case "SKIMMERS":
                header("Location: skimmers_homepage.html");
                break;
            case "CLOVERS":
                header("Location: clovers_homepage.html");
                break;
            case "REDBOLTS":
                header("Location: redbolts_homepage.html");
                break;
            default:
                // Redirect to a default homepage if organization not found
                header("Location: default_homepage.html");
                break;
        }
        exit();
    } else {
        // Show error message
        echo "<script>alert('Invalid email or password. Please try again.');</script>";
    }
}

$conn->close();
?>
