<?php
session_start();
define('BASE_PATH', dirname(__DIR__));

require_once "./assets/php/functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>AcVis - Actors Data</title>
    <link rel="stylesheet" href="assets/css/nav-style.css">
    <link rel="stylesheet" href="assets/css/user-style.css">
    <script defer src="assets/js/actors-visual.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
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
            <li><a class="active">Actors</a></li>
            <li><a href="about.php">About</a></li>
            <?php
            if (isset($_COOKIE["token"]) && is_logged_in($_COOKIE["token"])) {
                echo '<li><a href="logout.php">Logout</a></li>';
            }
            ?>
        </ul>
    </nav>
    <div class="container">
        <h2>Actors</h2>
        <div class="data-box">
            <div class="component">
                <label>Actor</label>
                <select id="entry-actor" name="Actor">
                </select>
            </div>
            <div class="component">
                <button id="view-actor">View Actor's Data</button>
            </div>
        </div>
    </div>
    <div class="container">
        <canvas id="actor-chart" style="width:100%;max-width:700px"></canvas>
        <div class="data-box">
            <div class="component">
                <button id="view-actor-data-img">View Actor's Data as PNG</button>
            </div>
        </div>
    </div>
    <div class="container bottom">
        <h2 id="result-year">Rewards</h2>
        <div class="favorite" id="favorite-container">
            <div class="tab-bar-content">
                <table id="general-result-table">
                    <tr>
                        <th class="name-content">Category</th>
                        <th class="name-content">Show</th>
                        <th class="name-content">Result</th>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td>Show</td>
                        <td>Result</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
