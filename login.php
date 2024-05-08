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
        <li><a href="register.php">Register</a></li>
        <li><a href="Main.html">Main</a></li>
        <li><a href="about.html">About</a></li>
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
                <a href="restore_account.html">Forgot Password?</a>
            </div>
            <hr>
            <div class="text">
                New to AcVis? <a href="./register.php">Create an account</a>
            </div>
        </div>
    </main>
</body>

</html>