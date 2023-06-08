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
    header('Location: admin-login.html');
    exit();
}
?>
