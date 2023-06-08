<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    // Redirect to the login page or display an error message
    header("Location: admin_login.php");
    exit;}
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
    $stmt = $conn->prepare("INSERT INTO elektrons_settings (description, duration_from, duration_to) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $description, $durationFrom, $durationTo);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    // Set a success message in the session
    session_start();
    $_SESSION["success_message"] = "Form submitted successfully!";

    // Redirect to elektrons_settings.html
    header("Location: elektrons_candidates.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <link href="https://fonts.googleapis.com/css?family=Exo&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Exo+2&display=swap" rel="stylesheet" />
  <link href="globalcss.css" rel="stylesheet" />  
  <link href="elektrons.css" rel="stylesheet" />
  <title>Election Settings</title>
</head>
<body>
  <div class="header">
    <p id="uni">University of the Philippines Visayas</p>
    <a href="HomePage.html"><img src="images/logo.png" id="iv"></a>
  </div>
  <div class="content">
    <div class="sidebar">
      <button id="ES" onclick="Election_settings()">Election Settings</button>
      <button id="CD" onclick="Candidates()">Candidates</button>
      <button id="VW" onclick="ViewScores()">View Scores</button>
      <script>
        function Election_settings() {
          location.replace("elektrons_settings.php");
        }
        function Candidates() {
          location.replace("elektrons_candidates.php");
        }
        function ViewScores() {
          location.replace("elektrons_view_scores.php");
        }
      </script>
    </div>
    <div class="form-container">
      <form id="candidateForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="form-row">
          <label id="DS" for="description">Election description:</label>
          <textarea id="description" name="description" placeholder="What's on your mind?"></textarea>
        </div>
        <div class="form-row">
          <label id="ED" for="duration-from">Election duration (From):</label>
          <input type="date" id="duration-from" name="duration-from" required>
        </div>
        <div class="form-row">
          <label id="EF" for="duration-to">Election duration (To):</label>
          <input type="date" id="duration-to" name="duration-to">
        </div>
        <div class>
          <input id="apply" type="submit" value="Apply">
        </div>
      </form>
    </div>
    <script>
      const durationFromInput = document.getElementById('duration-from');
      const durationToInput = document.getElementById('duration-to');
      const electionForm = document.getElementById('candidateForm');

      // The following code executes when the form is submitted
      electionForm.addEventListener('submit', (event) => {
        event.preventDefault(); // prevent form submission

        const durationFromDate = new Date(durationFromInput.value);
        const formattedDurationFromDate = durationFromDate.toLocaleDateString('en-US', {
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        });

        const durationToDate = new Date(durationToInput.value);
        const formattedDurationToDate = durationToDate.toLocaleDateString('en-US', {
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        });

        const electionDescription = document.getElementById('description').value;
        console.log(`Election description: ${electionDescription}`);
        console.log(`Election duration: ${formattedDurationFromDate} - ${formattedDurationToDate}`);

        const formData = new FormData(electionForm); // Create a FormData object with the form data

        // Send the form data to the PHP script using Fetch API
        fetch('<?php echo $_SERVER['PHP_SELF']; ?>', {
          method: 'POST',
          body: formData
        })
          .then(response => response.text())
          .then(data => {
            console.log(data);
            // Clear form inputs after successful submission
            electionForm.reset();

            // Redirect to elektrons_candidates.php
            location.replace("elektrons_candidates.php");

            // Handle the response data as needed
          })
          .catch(error => {
            console.error('Error:', error);
          });
      });
    </script>
  </div>
  <div class="footer">
      <p id="copy">Copyright © 2023. All Rights Reserved.</p>
  </div>
</body>
</html>
