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
    <script defer src="assets/js/user-self-edit.js"></script>
</head>
<body>
  <nav>
    <ul class="topnav">
      <li><a href="Main.html">Main</a></li>
      <li><a href="about.html">About</a></li>
      <li><a href="user.html" class="active">Profile</a></li>
      <li><a href="">Logout</a></li>
    </ul>
  </nav>
    <main class="container">
        <div class="user-profile">
            <!--
                <img src="./assets/imgs/profile_icon.bmp" alt="Profile">
            -->
            <form class="data-box">
                <div class="component">
                    <label>Firstname</label>
                    <input placeholder="Firstname" id="user-firstname" value="Firstname" type="text" readonly>
                </div>
                <div class="component">
                    <label>Lastname</label>
                    <input placeholder="Lastname" id="user-lastname" value="Lastname" type="text" readonly>
                </div>
                <div class="component">
                    <label>Username</label>
                    <input placeholder="Username" id="user-username" value="Username" type="text" readonly>
                </div>
                <div class="component">
                    <label>Email</label>
                    <input placeholder="Email" id="user-email" value="email@email.email" type="email" readonly>
                </div>
                <div class="component pair">
                    <button name="edit" id="button-edit" class="enabled">Edit</button>
                    <button name="save" id="button-save" class="disabled" disabled>Save</button>
                </div>
            </form>
        </div>
    </main>
    <hr>
    <div class="container">
        <h2>Favorite Actors</h2>
        <div class="favorite" id="favorite-container">
            <div class="tab-bar-content">
                <table id="general-fav-table">
                    <tr>
                        <th class="name-content">Full Name</th>
                        <th class="action-content small">Actions</th>
                    </tr>
                    <tr>
                        <td style="display:none">id</td>
                        <td>Name</td>
                        <td class="delete small">Unfavorite</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="data-box">
            <div class="component centered">
                <button id="button-favorite-previous" class="page-index previous">Previous</button>
                <input placeholder="Page" id="favorite-page-index" type="number" value="1" class="favorite-page">
                <button id="button-favorite-next" class="page-index next">Next</button>
            </div>
        </div>
    </div>
</body>
</html>
