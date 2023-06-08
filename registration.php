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

    // Check if the email already exists in the database
    $checkEmailQuery = "SELECT * FROM registration WHERE email = '$email'";
    $checkEmailResult = $conn->query($checkEmailQuery);

    if ($checkEmailResult->num_rows > 0) {
        // Email already exists, show alert message
        echo "<script>alert('Email already exists. Please choose a different email.');</script>";
    } else {
        // Email is unique, store the registration data in the database
        $sql = "INSERT INTO registration (name, email, password, organization)
            VALUES ('$name', '$email', '$password', '$address')";

        if ($conn->query($sql) === true) {
            // Retrieve the user ID of the registered user
            $user_id = $conn->insert_id;

            // Set the user ID in the session
            $_SESSION["user_id"] = $user_id;
            $_SESSION["user_name"] = $name; // Add this line to store the user's name in the session

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
                    header("Location: elektrons_homepage.php?name=" . urlencode($name)); // Pass the user's name as a parameter
                    break;
                case "SKIMMERS":
                    header("Location: skimmers_homepage.php?name=" . urlencode($name)); // Pass the user's name as a parameter
                    break;
                case "CLOVERS":
                    header("Location: clovers_homepage.php?name=" . urlencode($name)); // Pass the user's name as a parameter
                    break;
                case "REDBOLTS":
                    header("Location: redbolts_homepage.php?name=" . urlencode($name)); // Pass the user's name as a parameter
                    break;
                default:
                    // Redirect to a default homepage if organization not found
                    header("Location:HomePage.html");
                    break;
            }

            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <link href="https://fonts.googleapis.com/css?family=Exo&display=swap" rel="stylesheet" />
	  <link href="https://fonts.googleapis.com/css?family=Exo+2&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="globalcss.css" />
    <link rel="stylesheet" type="text/css" href="registration.css" />
  </head>
  <body>
    <div class="container-center-horizontal">
      <div class="registration">
        <div class="header">
          <p id="uni">University of the Philippines Visayas</p>
          <a href="HomePage.html"><img src="images/logo.png" id="iv"></a>
        </div>
        <div class="content">
          <a href="HomePage.html"><img src="exitIcon.png" id="exit"></a>
          <img src="createAcc.png" id="ca">
          <form action="registration.php" method="post" novalidate>
            <div class="formRow">
              <input type="text" id="regName" name="name" placeholder="Name">
            </div>
            <div class="formRow">
              <select id="regAddr" name="address">
                <option value="ELEKTRONS">ELEKTRONS</option>
                <option value="SKIMMERS">SKIMMERS</option>
                <option value="CLOVERS">CLOVERS</option>
                <option value="REDBOLTS">REDBOLTS</option>
              </select>
            </div>
            <div class="formRow">
              <input type="text" id="regEmail" name="email" placeholder="Email">
              <input type="password" id="regPass" name="password" placeholder="Password">
            </div>
            <input type="submit" value="Register">
          </form>
          <p>
            <span>Already have an account?</span>
            <span><a href="voters_login.php">Log in here</a> instead</span>
          </p>
        </div>
        <div class="footer">
          <p id="copy">Copyright © 2023. All Rights Reserved.</p>
        </div>
      </div>
    </div>
  </body>
</html>