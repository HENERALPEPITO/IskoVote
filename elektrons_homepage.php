<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: voters_login.php");
    exit();
}

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

// Retrieve the name from the database
$userId = $_SESSION["user_id"];

// Prepare the SQL query
$query = "SELECT name FROM registration WHERE id = $userId";

// Execute the query
$result = mysqli_query($conn, $query);

// Check if the query was successful and retrieve the name
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
} else {
    $name = "Unknown";
}

mysqli_close($conn);

// Output the greeting message
echo "Hi, $name!";
?>
