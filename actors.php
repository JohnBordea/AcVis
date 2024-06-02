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
            <li><a href="Main.html">Main</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="user.php">Profile</a></li>
            <li><a class="active">Actors</a></li>
            <?php
            if (isset($_COOKIE["token"]) && is_logged_in($_COOKIE["token"])) {
                echo '<li><a href="">Logout</a></li>';
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
        </div>
    </div>
    <div class="container">
        <canvas id="actor-chart" style="width:100%;max-width:700px"></canvas>
    </div>
    <div class="container">
        <h2>Results</h2>
        <div class="favorite" id="favorite-container">
            <div class="tab-bar-content">
                <table id="general-result-table">
                    <tr>
                        <th class="name-content">Category</th>
                        <th class="name-content">Show</th>
                        <th class="name-content">Result</th>
                    </tr>
                    <tr>
                        <td class="name-content">Category</td>
                        <td class="name-content">Show</td>
                        <td class="name-content">Result</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
