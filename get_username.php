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

// Check if the user is logged in
if (!isset($_SESSION["email"])) {
    header("Location: voters_login.php");
    exit();
}

$email = $_SESSION["email"];

// Prepare the SQL query
$sql = "SELECT name FROM registration WHERE email = '$email'";

// Execute the query
$result = $conn->query($sql);

// Check if the query was successful and retrieve the name
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row["name"];
} else {
    $name = "Unknown";
}

$conn->close();

// Output the greeting message
echo "Hi, $name!";
?>
