<?php

// Establish database connection (replace with your own credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["description"];

    // Insert values into the contacts table
    $insertQuery = "INSERT INTO contacts (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($insertQuery) === true) {
        echo "Message sent successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <link href="https://fonts.googleapis.com/css?family=Exo&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Exo+2&display=swap" rel="stylesheet" />
    <link href="globalcss.css" rel="stylesheet" />
    <link href="contacts.css" rel="stylesheet" />
    <title>Contacts</title>
  </head>
  <body>
    <div class="header">
      <p id="uni">University of the Philippines Visayas</p>
      <a href="HomePage.html"><img src="images/logo.png" id="iv"></a>
    </div>
    <div class="nav">
      <span class="NavBarHome">
        <a class="navigation" href="registration.php">Voter</a>
        <a class="navigation" href="admin_login.php">Admin</a>
        <a class="navigation" href="AboutUs.html">About Us</a>
        <a class="navigation" href="contacts.php">Contacts</a>
      </span>
    </div>
    <div class="contact">
      <div class="info">
        <div class="deets">
          <img src="contacts/image_16.png" id="r1a">
        </div>
        <div class="deets">
          <img src="contacts/rectangle_231.png" id="r2a">
          <span  class="official_address">UP Visayas, Miagao, 5023, Iloilo</span>
        </div>
        <div class="deets">
          <img src="contacts/rectangle_232.png" id="r2b">
          <span  class="official_email">iskovote@up.edu.ph</span>
        </div>
        <div class="deets">
          <img src="contacts/rectangle_233.png" id="r2c">
          <span  class="official_number">09696969420</span>
        </div>
      </div>
      <div class="feedback">
        <form method="POST">
          <div class="formRow1">
            <label id="DS" for="description">Full Name:</label>
            <input type="text" id="regName" name="name" placeholder="Name" required>
          </div>
          <div class="formRow1">
            <label id="DS" for="description">E-mail:</label>
            <input type="text" id="regEmail" name="email" placeholder="Email" required>
          </div>
          <div class="formRow1">
            <label id="DS" for="description">Message:</label>
            <textarea id="description" name="description" placeholder="What's on your mind?" required></textarea>
          </div>
          <div class="formRow2">
            <input id="contact" type="submit" value="Contact">
          </div>
        </form>
      </div>
    </div>
    <div class="footer">
      <p id="copy">Copyright © 2023. All Rights Reserved.</p>
    </div>
  </body>
</html>

<?php
$conn->close();
?>

<!DOCTYPE html>
<html>
  <head>
    <link href="https://fonts.googleapis.com/css?family=Exo&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Exo+2&display=swap" rel="stylesheet" />
    <link href="globalcss.css" rel="stylesheet" />
    <link href="contacts.css" rel="stylesheet" />
    <title>Contacts</title>
  </head>
  <body>
    <div class="header">
      <p id="uni">University of the Philippines Visayas</p>
      <a href="HomePage.html"><img src="images/logo.png" id="iv"></a>
    </div>
    <div class="nav">
      <span class="NavBarHome">
        <a class="navigation" href="registration.php">Voter</a>
        <a class="navigation" href="admin_login.php">Admin</a>
        <a class="navigation" href="AboutUs.html">About Us</a>
        <a class="navigation" href="contacts.php">Contacts</a>
      </span>
    </div>
    <div class="contact">
      <div class="info">
        <div class="deets">
          <img src="contacts/image_16.png" id="r1a">
        </div>
        <div class="deets">
          <img src="contacts/rectangle_231.png" id="r2a">
          <span  class="official_address">UP Visayas, Miagao, 5023, Iloilo</span>
        </div>
        <div class="deets">
          <img src="contacts/rectangle_232.png" id="r2b">
          <span  class="official_email">iskovote@up.edu.ph</span>
        </div>
        <div class="deets">
          <img src="contacts/rectangle_233.png" id="r2c">
          <span  class="official_number">09696969420</span>
        </div>
      </div>
      <div class="feedback">
        <form>
          <div class="formRow1">
            <label id="DS" for="description">Full Name:</label>
            <input type="text" id="regName" name="name" placeholder="Name" required>
          </div>
          <div class="formRow1">
            <label id="DS" for="description">E-mail:</label>
            <input type="text" id="regEmail" name="email" placeholder="Email" required>
          </div>
          <div class="formRow1">
            <label id="DS" for="description">Message:</label>
            <textarea id="description" name="description" placeholder="What's on your mind?" required></textarea>
          </div>
          <div class="formRow2">
            <input id="contact" type="submit" value="Contact">
          </div>
        </form>
      </div>
    </div>
    <div class="footer">
      <p id="copy">Copyright © 2023. All Rights Reserved.</p>
    </div>
  </body>
</html>