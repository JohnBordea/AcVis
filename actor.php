<?php
session_start();
define('BASE_PATH', dirname(__DIR__));

require_once "./assets/php/functions.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actors Main Page</title>
    <link rel="stylesheet" href="assets/css/nav-style.css">
    <link rel="stylesheet" href="assets/css/user-style.css">
    <script defer src="assets/js/actor.js"></script>
</head>
<body>
    <nav>
        <ul class="topnav">
            <li><a href="main.php">Main</a></li>
            <?php
            if (isset($_COOKIE["token"]) && is_logged_in($_COOKIE["token"])) {
                echo '<li><a href="user.php">Profile</a></li>';
                if(is_admin($_COOKIE["token"])) {
                    echo '<li><a href="admin.php">Admin</a></li>';
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
    <div class="container data">
        <div class="side">
            <img id="actor-img" style="width: 100%;">
        </div>
        <div class="column middle">
            <h2 id="actor-name"></h2>
            <div id="actor-movie-info">
            </div>
        </div>
    </div>
    <?php
    if (isset($_COOKIE["token"]) && is_logged_in($_COOKIE["token"])) {
        echo '<div class="container">';
        echo '<div class="data-box">';
        echo '<div class="component pair">';
        echo '<button id="button-actor-add" class="enabled" style="display:none">Add as Favorite</button>';
        echo '<button id="button-actor-remove" class="enabled"  style="display:none">Remove as Favorite</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    ?>
    <div class="container bottom">
        <h2 id="result-year">Results</h2>
        <div class="favorite" id="favorite-container">
            <div class="tab-bar-content">
                <table id="general-result-table">
                    <tr>
                        <th class="name-content">Year</th>
                        <th class="name-content">Category</th>
                        <th class="name-content">Show</th>
                        <th class="name-content">Result</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>