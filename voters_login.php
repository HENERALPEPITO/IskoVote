<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=1440, maximum-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="globalcss.css" />
    <link rel="stylesheet" type="text/css" href="login.css" />
  </head>
  <body>
    <div class="container-center-horizontal">
      <div class="login">
        <div class="header">
            <p id="uni">University of the Philippines Visayas</p>
            <a href="HomePage.html"><img src="images/logo.png" id="iv"></a>
        </div>
        <div class="content">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
              <div class="loginField"><a href="HomePage.html">
                <img src="loginAcc.png" id="ac"></a>              
                <input type="text" id="email" name="email" placeholder="Email">
                <input type="password" id="password" name="password" placeholder="Password">
              </div>
              <input type="submit" value="Login">
            </form>
        </div>
        <div class="footer">
            <p id="copy">Copyright © 2023. All Rights Reserved.</p>
        </div>
      </div>
    </div>
    
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
        $sql = "SELECT * FROM registration WHERE email = '$email' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_id = $row["id"];
            $name = $row["name"];
            $organization = $row["organization"];

            // Set the user ID and name in the session
            $_SESSION["user_id"] = $user_id;
            $_SESSION["user_name"] = $name;

            // Redirect to the respective homepage based on the organization
            switch ($organization) {
                case "ELEKTRONS":
                    header("Location: elektrons_homepage.php?name=" . urlencode($name));
                    break;
                case "SKIMMERS":
                    header("Location: skimmers_homepage.php?name=" . urlencode($name));
                    break;
                case "CLOVERS":
                    header("Location: clovers_homepage.php?name=" . urlencode($name));
                    break;
                case "REDBOLTS":
                    header("Location: redbolts_homepage.php?name=" . urlencode($name));
                    break;
                default:
                    // Redirect to a default homepage if organization not found
                    header("Location: HomePage.html");
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
  </body>
</html>
