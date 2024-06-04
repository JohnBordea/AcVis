<?php
session_start();
define('BASE_PATH', dirname(__DIR__));

require_once "./assets/php/functions.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>AcVis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assetss/css/style.css">
</head>
<body>
    <div class="bg-image">
    </div>
    <div class="bg-text">
        <h2>Explore the Stars: Unveil Insights, Dive into Stories.</h2>
        <h1 style="font-size:50px">Actors Smart Visualiser</h1>
        <div class="buttons">
            <button class="documentation-btn"><a href="main.php">Home</a></button>
            <button class="documentation-btn"><a href="about.php">About</a></button>
            <button class="documentation-btn"><a href="actors.php">Actors</a></button>
            <?php
            if (!isset($_COOKIE["token"])) {
                echo '<button class="login-btn"><a href="login.php">Login</a></button>';
            } else {
                echo '<button class="register-btn"><a href="user.php"> Profile</a></button>';
                if(is_admin($_COOKIE["token"])) {
                    echo '<button class="register-btn"><a href="admin.php"> Admin Page</a></button>';
                }
                echo '<button class="register-btn"><a href="logout.php"> Logout</a></button>';
            }
            ?>
        </div>
    </div>
</body>

</html>