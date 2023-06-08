<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

if ($email === 'elektrons@up.edu.ph' && $password === '1234') {
    $_SESSION['email'] = $email;
    $_SESSION['admin_logged_in'] = true;
    header('Location: elektrons_settings.php');
    exit();
} elseif ($email === 'redbolts@up.edu.ph' && $password === '1234') {
    $_SESSION['email'] = $email;
    $_SESSION['admin_logged_in'] = true;
    header('Location: redbolts_settings.php');
    exit();
} elseif ($email === 'clovers@up.edu.ph' && $password === '1234') {
    $_SESSION['email'] = $email;
    $_SESSION['admin_logged_in'] = true;
    header('Location: clovers_settings.php');
    exit();
} elseif ($email === 'skimmers@up.edu.ph' && $password === '1234') {
    $_SESSION['email'] = $email;
    $_SESSION['admin_logged_in'] = true;
    header('Location: skimmers_settings.php');
    exit();
} else {
    // Invalid email or password, show pop-up box and redirect to login page
    echo "<script>alert('Invalid Admin Credentials. Please try again.');</script>";
    header('Location: admin_login.php');
    exit();
}
?>

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
          <form action="admin_login.php" method="POST">  
            <div class="loginField"><a href="HomePage.html">
              <img src="loginAcc.png" id="ac"></a>
              <input type="text" id="email" name="email" placeholder="Email">
              <input type="password" id="password" name="password" placeholder="Password">
              <input type="submit" value="Login">
            </div>
          </form>
        </div>
        <div class="footer">
            <p id="copy">Copyright © 2023. All Rights Reserved.</p>
        </div>
      </div>
    </div>
  </body>
</html>