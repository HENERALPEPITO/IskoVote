<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

if ($email === 'elektrons@up.edu.ph' && $password === '1234') {
    $_SESSION['email'] = $email;
    header('Location: elektrons_admin.html');
    exit();
} elseif ($email === 'redbolts@up.edu.ph' && $password === '1234') {
    $_SESSION['email'] = $email;
    header('Location: redbolts_admin.html');
    exit();
} elseif ($email === 'clovers@up.edu.ph' && $password === '1234') {
    $_SESSION['email'] = $email;
    header('Location: clovers_admin.html');
    exit();
} elseif ($email === 'skimmers@up.edu.ph' && $password === '1234') {
    $_SESSION['email'] = $email;
    header('Location: skimmers_admin.html');
    exit();
} else {
    // Invalid email or password, show pop-up box and redirect to login page
    echo "<script>alert('Invalid Admin Credentials. Please try again.');</script>";
    header('Location: admin-login.html');
    exit();
}
?>
