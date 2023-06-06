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
    $name = $_POST["name"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Store the registration data in the database
    $sql = "INSERT INTO registration (name, email, password, organization)
            VALUES ('$name', '$email', '$password', '$address')";

    if ($conn->query($sql) === true) {
        // Retrieve the user ID of the registered user
        $user_id = $conn->insert_id;
        
        // Set the user ID in the session
        $_SESSION["user_id"] = $user_id;
        
        // Show alert message
        echo "<script>alert('Registered account!');</script>";

        // Reset the form values
        echo "<script>
            document.getElementById('regName').value = '';
            document.getElementById('regAddr').value = 'ELEKTRONS';
            document.getElementById('regEmail').value = '';
            document.getElementById('regPass').value = '';
        </script>";

        // Redirect to the respective homepage based on the organization
        switch ($address) {
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
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
