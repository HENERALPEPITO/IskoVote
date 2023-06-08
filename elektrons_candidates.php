<?php
// Check if the form is submitted
session_start();
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

    // Loop through the submitted candidate data and insert each candidate into the database
    for ($i = 0; $i < count($candidateNames); $i++) {
        $name = $candidateNames[$i];
        $position = $positions[$i];
        $yearLevel = $yearLevels[$i];

        // Check if a candidate already exists for the given position and year level
        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM elektrons_candidates WHERE position = ? AND year_level = ?");
        $stmt->bind_param("ss", $position, $yearLevel);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];

        if ($count > 0) {
            echo "Error: Only one candidate per position per year level is allowed.";
            $stmt->close();
            $conn->close();
            exit;
        }

        // Prepare and execute the SQL statement to insert candidate data into the database
        $stmt = $conn->prepare("INSERT INTO elektrons_candidates (name, position, year_level) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $position, $yearLevel);
        $stmt->execute();
        $stmt->close();
    }

    $conn->close();

    // Return a response back to the client
    header("elektrons_view_scores.php");
    echo "Candidates saved successfully!";
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Elektrons Candidates</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=1440, maximum-scale=1.0" />
    <link href="https://fonts.googleapis.com/css?family=Exo&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Exo+2&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="globalcss.css" />
    <link rel="stylesheet" type="text/css" href="elektrons.css" />
</head>
<body>
  <div class="header">
    <p id="uni">University of the Philippines Visayas</p>
    <a href="HomePage.html"><img src="ivIcon.png" id="iv"></a>
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
    <div class="candidates">
      <div class="resultExit">
        <a href="admin_election.html" id="return">Return to Elections</a>
      </div>
      <div class="candidateList">
        <div class="candidateData">
          <p>Candidate List</p>
          <div class="personalDetails">
            <ol id="dispList"></ol>
          </div>
        </div>
        <div class="addCandidateForm">
          <form id="candidateForm" action="elektrons_candidates.php" method="POST">
            <div class="field">
              <p>Name</p>
              <input id="canName" type="text" name="candidateName" required />
            </div>
            <div class="field">
              <p>Position</p>
              <select id="positionDd" name="position" required>
                <option value="President">President</option>
                <option value="Vice President">Vice President</option>
                <option value="Secretary">Secretary</option>
              </select>
            </div>
            <div class="field">
              <p>Year Level</p>
              <select id="yearLv" name="yearLevel" required>
                <option value="1st Year">1st Year</option>
                <option value="2nd Year">2nd Year</option>
                <option value="3rd Year">3rd Year</option>
                <option value="4th Year">4th Year</option>
              </select>
            </div>
            <button id="add" type="button">Add Candidate to List</button>
            <button id="saveCandidates" type="button">Save Candidates</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="footer">
      <p id="copy">Copyright © 2023. All Rights Reserved.</p>
    </div>
  <script>
    document.getElementById("add").addEventListener("click", function(event) {
      event.preventDefault(); // Prevent the form from being submitted
      addCandidate();
    });

    document.getElementById("saveCandidates").addEventListener("click", function(event) {
      event.preventDefault(); // Prevent the form from being submitted
      saveCandidates();
    });

    function addCandidate() {
      var addName = document.getElementById("canName").value;
      if (addName === "") {
        alert("Candidate's name cannot be blank!");
        return;
      }

      var posLabel = document.getElementById("positionDd");
      var addPos = posLabel.options[posLabel.selectedIndex].text;

      var yrLabel = document.getElementById("yearLv");
      var addYr = yrLabel.options[yrLabel.selectedIndex].text;


      var list = document.getElementById("dispList");
      var li = document.createElement("li");
      li.innerHTML =
        "<span class='candidateName'>" +
        addName +
        "</span>\t\t" +
        "<span class='candidatePosition'>" +
        addPos +
        "</span>\t\t" +
        "<span class='candidateYearLevel'>" +
        addYr +
        "</span>\t\t";

      var icon = document.createElement("img");
      icon.src = "user.png";
      icon.style.width = "25px";
      icon.style.height = "25px";
      icon.style.marginLeft = "5px";
      icon.style.marginRight = "5px";
      icon.style.float = "left";
      li.appendChild(icon);

      var removeBtn = document.createElement("button");
      removeBtn.innerText = "Remove";
      removeBtn.style.float = "right";
      removeBtn.addEventListener("click", function() {
        li.remove();
      });
      li.appendChild(removeBtn);

      list.appendChild(li);
      document.getElementById("canName").value = "";
    }

    function saveCandidates() {
      var list = document.getElementById("dispList");
      var candidates = list.getElementsByTagName("li");

      if (candidates.length === 0) {
        alert("No candidates to save.");
        return;
      }

      var candidateNames = [];
      var positions = [];
      var yearLevels = [];

      for (var i = 0; i < candidates.length; i++) {
        var candidate = candidates[i];
        var name = candidate.querySelector(".candidateName").textContent.trim();
        var position = candidate.querySelector(".candidatePosition").textContent.trim();
        var yearLevel = candidate.querySelector(".candidateYearLevel").textContent.trim();

        candidateNames.push(name);
        positions.push(position);
        yearLevels.push(yearLevel);
      }

      // Send the form data to the server using an AJAX request
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "elektrons_candidates.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            alert("Candidates saved successfully!");
            list.innerHTML = ""; // Clear the candidate list after saving
            window.location.replace("elektrons_view_scores.php");
          }
        }
      };
      xhr.send(
        "candidateName=" + encodeURIComponent(candidateNames.join(",")) +
        "&position=" + encodeURIComponent(positions.join(",")) +
        "&yearLevel=" + encodeURIComponent(yearLevels.join(","))
      );
    }
  </script>
</body>
</html>
