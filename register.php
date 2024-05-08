<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>AcVis - Register</title>
    <link rel="stylesheet" href="../assets/css/nav-style.css">
    <link rel="stylesheet" href="../assets/css/login-style.css">
    <script defer src="./assets/js/register.js"></script>

</head>
<body>
  <nav>
    <ul class="topnav">
      <li><a href="login.html">Login</a></li>
      <li><a href="Main.html">Main</a></li>
      <li><a href="about.html">About</a></li>
    </ul>
  </nav>

    <main class="container">
        <form id="register-new-user-form" class="form">
            <h2 class="text">Sign Up</h2>

            <p class="line-item">
                <input type="text" name="firstname" placeholder="Type Your Firstame*" required>
                <input type="text" name="lastname" placeholder="Type Your Lastname*" required>
            </p>
            <p class="line-item">
                <input type="text" name="username" placeholder="Type Your Username*" required>
                <input type="email" name="email" placeholder="Type Your Email*" required>
            </p>
            <p class="line-item">
                <input type="password" name="password" placeholder="Type Your Password*" required>
                <input type="password" name="password_repeat" placeholder="Retype Your Password*" required>
            </p>
            <button type="submit" name="submit" id="register-new-user">Register</button>
            <div class="text"></div>
            <hr>
            <div class="text">
                Already have an account? <a href="./login.php">Sign in Here</a>
            </div>
        </form>
    </main>
</body>
</html>