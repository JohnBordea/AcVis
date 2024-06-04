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
    <link rel="stylesheet" href="assetss/css/main.css" />
</head>
<body>
    <div class="container">
        <img src="assetss/img/imageq.jpg" alt="Notebook" style="width:100%;">
        <div class="content">
            <h1>AcVis</h1>
            <p>Explore the Stars: Unveil Insights, Dive into Stories.</p>
        </div>
    </div>
    <ul class="topnav">
        <li><a class="active">Home</a></li>
        <li><a href="actors.php">Actors</a></li>
        <li><a href="about.php">About</a></li>
        <?php
        if (!isset($_COOKIE["token"])) {
            echo '<li><a href="login.php">Login</a></li>';
        } else {
            echo '<li><a href="user.php">Profile</a></li>';
            if(is_admin($_COOKIE["token"])) {
                echo '<li><a href="admin.php">Admin</a></li>';
            }
            echo '<li><a href="logout.php">Logout</a></li>';
        }
        ?>
    </ul>

    <h1 style="align-self: center;">Top Artists in the last year</h1>
    <div class="responsive">
        <div class="gallery">
            <a target="_blank" href="actor.html">
                <img src="assetss/img/cm.jpg" alt="Cinque Terre" width="600" height="400">
            </a>
            <div class="desc">Add a description of the image here</div>
        </div>
    </div>
    <div class="responsive">
        <div class="gallery">
            <a target="_blank" href="actor.html">
                <img src="assetss/img/cm.jpg" alt="Forest" width="600" height="400">
            </a>
            <div class="desc">Add a description of the image here</div>
        </div>
    </div>
    <div class="responsive">
        <div class="gallery">
            <a target="_blank" href="actor.html">
                <img src="assetss/img/cm.jpg" alt="Northern Lights" width="600" height="400">
            </a>
            <div class="desc">Add a description of the image here</div>
        </div>
    </div>
    <div class="responsive">
        <div class="gallery">
            <a target="_blank" href="actor.html">
                <img src="assetss/img/cm.jpg" alt="Mountains" width="600" height="400">
            </a>
            <div class="desc">Add a description of the image here</div>
        </div>
    </div>
    <div class="clearfix"></div>
    <h1>The list of prizes awarded in the last year</h1>
    <div style="overflow-x:auto;">
        <table class="center">
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Points</th>
                <th>Points</th>
                <th>Points</th>
                <th>Points</th>
                <th>Points</th>
                <th>Points</th>
            </tr>
            <tr>
                <td>Lorem</td>
                <td>Ipsum</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
            </tr>
            <tr>
                <td>Lorem</td>
                <td>Ipsum</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
            </tr>
            <tr>
                <td>Lorem</td>
                <td>Ipsum</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
            </tr>
            <tr>
                <td>Lorem</td>
                <td>Ipsum</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
            </tr>
        </table>
    </div>
    <h1 style="align-self: center;">Top movies in the last year</h1>
    <div class="responsive">
        <div class="gallery">
            <a target="_blank" href="index.html">
                <img src="assetss/img/op.jpg" alt="Cinque Terre" width="600" height="400">
            </a>
            <div class="desc">Add a description of the image here</div>
        </div>
    </div>
    <div class="responsive">
        <div class="gallery">
            <a target="_blank" href="assetss/img/op.jpg">
                <img src="assetss/img/op.jpg" alt="Forest" width="600" height="400">
            </a>
            <div class="desc">Add a description of the image here</div>
        </div>
    </div>
    <div class="responsive">
        <div class="gallery">
            <a target="_blank" href="assetss/img/op.jpg">
                <img src="assetss/img/op.jpg" alt="Northern Lights" width="600" height="400">
            </a>
            <div class="desc">Add a description of the image here</div>
        </div>
    </div>
    <div class="responsive">
        <div class="gallery">
            <a target="_blank" href="assetss/img/op.jpg">
                <img src="assetss/img/op.jpg" alt="Mountains" width="600" height="400">
            </a>
            <div class="desc">Add a description of the image here</div>
        </div>
    </div>
    <div class="clearfix"></div>
</body>
</html>