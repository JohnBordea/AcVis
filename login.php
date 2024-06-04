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
    <title>AcVis - Login</title>
    <link rel="stylesheet" href="assets/css/nav-style.css">
    <link rel="stylesheet" href="assets/css/login-style.css">
    <script defer src="./assets/js/login.js"></script>

</head>

<body>
    <nav>
        <ul class="topnav">
            <li><a href="main.php">Main</a></li>
            <?php
            if (isset($_COOKIE["token"]) && is_logged_in($_COOKIE["token"])) {
                echo '<li><a href="user.php">Profile</a></li>';
                if(is_admin($_COOKIE["token"])) {
                    echo '<li><a class="active">Admin</a></li>';
                }
            }
            ?>
            <li><a href="actors.php">Actors</a></li>
            <li><a href="about.php">About</a></li>
            <?php
            if (isset($_COOKIE["token"]) && is_logged_in($_COOKIE["token"])) {
                echo '<li><a href="logout.php">Logout</a></li>';
            }
            ?>
        </ul>
    </nav>

    <main class="container">
        <div id="login-form" class="form">
            <h2 class="text">Login Form</h2>

            <div id="login-error-msg-holder" style="display: none;">
                <p id="login-error-msg">Invalid username <span id="error-msg-second-line">and/or password</span></p>
            </div>
            <div id="login-connect-msg-holder" style="display: none;">
                <p id="login-connect-msg"></p>
            </div>

            <input type="text" name="uid" placeholder="Username/Email" id="username-field">
            <input type="password" name="pwd" placeholder="Password" id="password-field">
            <button type="submit" name="login-submit" id="login-form-submit">Login</button>
            <div class="text">
                <a href="restore_account.php">Forgot Password?</a>
            </div>
            <hr>
            <div class="text">
                New to AcVis? <a href="./register.php">Create an account</a>
            </div>
        </div>
    </main>
</body>

</html>