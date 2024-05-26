<?php
session_start();
define('BASE_PATH', dirname(__DIR__));

require_once "./assets/php/functions.php";


if (!isset($_COOKIE["token"])) {
    header("Location: ./index.html");
    exit();
} else {
    if(!is_logged_in($_COOKIE["token"])) {
        header("Location: ./index.html");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>AcVis - User</title>
    <link rel="stylesheet" href="assets/css/nav-style.css">
    <link rel="stylesheet" href="assets/css/user-style.css">
    <script defer src="assets/js/actors-visual.js"></script>
</head>
<body>
  <nav>
    <ul class="topnav">
      <li><a href="Main.html">Main</a></li>
      <li><a href="about.html">About</a></li>
      <li><a href="user.html" class="active">Profile</a></li>
      <li><a href="">Logout</a></li>
    </ul>
    <div class="container">
        <h2>Actors</h2>
        <div class="favorite" id="actor-container">
        </div>
        <div class="data-box">
            <div class="component centered">
                <button id="button-favorite-previous" class="page-index previous">Previous</button>
                <input placeholder="Page" id="actor-page-index" type="number" value="1" class="favorite-page">
                <button id="button-favorite-next" class="page-index next">Next</button>
            </div>
        </div>
    </div>
</body>
</html>
