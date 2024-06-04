<?php
session_start();
define('BASE_PATH', dirname(__DIR__));

require_once "./assets/php/functions.php";

if (isset($_COOKIE["token"])) {
    if(is_logged_in($_COOKIE["token"])) {
        header("Location: ./user.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>AcVis - Restore Account</title>
    <link rel="stylesheet" href="assets/css/nav-style.css">
    <link rel="stylesheet" href="assets/css/login-style.css">
    <script defer src="assets/js/restore_account.js"></script>
</head>
<body>
    <nav>
        <ul class="topnav">
            <li><a href="main.php">Main</a></li>
            <li><a class="active">Register</a></li>
            <li><a href="about.php">About</a></li>
        </ul>
    </nav>

    <main class="container">
        <div id="restore-user-password" class="form">
            <h2 class="text">Restore your Account</h2>

            <div class="text" id="restore-error" style="display:none"></div>

            <input type="email" placeholder="Email / Username" id="username-field" required>
            <input type="password" placeholder="New Password" id="password-field" required>
            <input type="password" placeholder="Repeat New Password" id="password-repeat-field" required>

            <button type="submit" name="submit" id="register-new-user">Restore</button>
            <div class="text"></div>
            <hr>
            <div class="text">
                Remembered your account? <a href="./login.php">Sign in Here</a>
            </div>
        </div>
        <div id="user-password-restored" class="form" style="display:none">
            <h2 class="text">Restore your Account</h2>

            <div class="text">
                User Password Successfully Reset
            </div>
            <div class="text">
                Proceed to <a href="./login.php">Log in</a>
            </div>
        </div>
    </main>
</body>
</html>